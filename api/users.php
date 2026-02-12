<?php
/**
 * API Endpoint: User Management
 * Create and delete admin users
 * Protected by session authentication (admin role only)
 */
session_start();

// Check authentication
if (!isset($_SESSION['admin_user'])) {
    http_response_code(401);
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    exit;
}

// Only admins can manage users
if (($_SESSION['admin_user']['rol'] ?? '') !== 'admin') {
    http_response_code(403);
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Permisos insuficientes']);
    exit;
}

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (!$data) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Datos JSON inválidos']);
    exit;
}

$usersFile = __DIR__ . '/../data/users.json';

function loadUsersData($file)
{
    if (!file_exists($file))
        return ['users' => [], 'password_rules' => []];
    $d = json_decode(file_get_contents($file), true);
    return $d ?: ['users' => [], 'password_rules' => []];
}

function saveUsersData($file, $data)
{
    return file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

$action = $data['action'] ?? '';

switch ($action) {
    case 'create':
        $email = trim($data['email'] ?? '');
        $nombre = trim($data['nombre'] ?? '');
        $password = trim($data['password'] ?? '');
        $rol = $data['rol'] ?? 'admin';

        if (empty($email) || empty($nombre) || empty($password)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Email, nombre y contraseña inicial son requeridos']);
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Email inválido']);
            exit;
        }

        $usersData = loadUsersData($usersFile);

        // Check for duplicate email
        foreach ($usersData['users'] as $u) {
            if ($u['email'] === $email) {
                http_response_code(409);
                echo json_encode(['success' => false, 'message' => 'Ya existe un usuario con ese email']);
                exit;
            }
        }

        // Create user with provided password and force change flag
        $newUser = [
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'nombre' => $nombre,
            'rol' => $rol,
            'force_change' => true, // Force change on first login
            'creado' => date('Y-m-d')
        ];

        $usersData['users'][] = $newUser;
        $result = saveUsersData($usersFile, $usersData);

        if ($result === false) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Error al guardar. Verifica permisos del directorio data/']);
            exit;
        }

        echo json_encode(['success' => true, 'message' => 'Usuario creado con éxito. Se le solicitará cambiar la contraseña en su primer inicio de sesión.']);
        break;

    case 'reset':
        $email = trim($data['email'] ?? '');
        $password = trim($data['password'] ?? '');

        if (empty($email) || empty($password)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Email y nueva contraseña son requeridos']);
            exit;
        }

        $usersData = loadUsersData($usersFile);
        $found = false;

        foreach ($usersData['users'] as $key => $u) {
            if ($u['email'] === $email) {
                $usersData['users'][$key]['password'] = password_hash($password, PASSWORD_DEFAULT);
                $usersData['users'][$key]['force_change'] = true;
                $found = true;
                break;
            }
        }

        if (!$found) {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Usuario no encontrado']);
            exit;
        }

        $result = saveUsersData($usersFile, $usersData);
        if ($result === false) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Error al guardar']);
            exit;
        }

        echo json_encode(['success' => true, 'message' => 'Contraseña restablecida con éxito.']);
        break;

    case 'delete':
        $email = trim($data['email'] ?? '');

        if (empty($email)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Email es requerido']);
            exit;
        }

        // Prevent self-deletion
        if ($email === $_SESSION['admin_user']['email']) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'No puedes eliminar tu propio usuario']);
            exit;
        }

        $usersData = loadUsersData($usersFile);
        $found = false;

        foreach ($usersData['users'] as $key => $u) {
            if ($u['email'] === $email) {
                array_splice($usersData['users'], $key, 1);
                $found = true;
                break;
            }
        }

        if (!$found) {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Usuario no encontrado']);
            exit;
        }

        $result = saveUsersData($usersFile, $usersData);

        if ($result === false) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Error al guardar']);
            exit;
        }

        echo json_encode(['success' => true, 'message' => 'Usuario eliminado correctamente']);
        break;

    case 'list':
        $usersData = loadUsersData($usersFile);
        // Return users without password hashes
        $safeUsers = array_map(function ($u) {
            return [
            'email' => $u['email'],
            'nombre' => $u['nombre'],
            'rol' => $u['rol'],
            'creado' => $u['creado'] ?? '',
            'pending' => ($u['password'] === '__PENDING_FIRST_LOGIN__'),
            'force_change' => ($u['force_change'] ?? false)
            ];
        }, $usersData['users']);
        echo json_encode(['success' => true, 'users' => array_values($safeUsers)]);
        break;

    case 'change_password':
        $password = trim($data['password'] ?? '');

        if (empty($password)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Contraseña requerida']);
            exit;
        }

        require_once '../includes/auth.php';
        $errors = validatePasswordComplexity($password);
        if (!empty($errors)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Contraseña no cumple requisitos: ' . implode(', ', $errors)]);
            exit;
        }

        $usersData = loadUsersData($usersFile);
        $email = $_SESSION['admin_user']['email'];
        $found = false;

        foreach ($usersData['users'] as $key => $u) {
            if ($u['email'] === $email) {
                $usersData['users'][$key]['password'] = password_hash($password, PASSWORD_DEFAULT);
                unset($usersData['users'][$key]['force_change']);
                $found = true;
                break;
            }
        }

        if (!$found) {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Usuario no encontrado']);
            exit;
        }

        $result = saveUsersData($usersFile, $usersData);
        if ($result === false) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Error al guardar']);
            exit;
        }

        // Clear session flag
        unset($_SESSION['force_password_change']);
        echo json_encode(['success' => true, 'message' => 'Contraseña actualizada con éxito.']);
        break;

    default:
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Acción inválida. Use: create, reset, delete, list, change_password']);
        break;
}