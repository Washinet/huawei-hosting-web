<?php
/**
 * Authentication Helper
 * Manages sessions, login validation, and password complexity
 */
session_start();

define('USERS_FILE', __DIR__ . '/../data/users.json');

/**
 * Check if user is authenticated, redirect to login if not
 */
function requireAuth()
{
    if (!isset($_SESSION['admin_user'])) {
        header('Location: login.php');
        exit;
    }
}

/**
 * Get current authenticated user
 */
function getCurrentUser()
{
    return $_SESSION['admin_user'] ?? null;
}

/**
 * Load users from JSON file
 */
function loadUsers()
{
    if (!file_exists(USERS_FILE))
        return ['users' => []];
    $data = json_decode(file_get_contents(USERS_FILE), true);
    return $data ?: ['users' => []];
}

/**
 * Save users to JSON file
 */
function saveUsers($data)
{
    file_put_contents(USERS_FILE, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

/**
 * Validate password complexity
 * Min 8 chars, uppercase, lowercase, number, special char (.@,#_)
 */
function validatePasswordComplexity($password)
{
    $errors = [];
    if (strlen($password) < 8) {
        $errors[] = 'Mínimo 8 caracteres';
    }
    if (!preg_match('/[A-Z]/', $password)) {
        $errors[] = 'Debe contener al menos una mayúscula';
    }
    if (!preg_match('/[a-z]/', $password)) {
        $errors[] = 'Debe contener al menos una minúscula';
    }
    if (!preg_match('/[0-9]/', $password)) {
        $errors[] = 'Debe contener al menos un número';
    }
    if (!preg_match('/[.@,#_]/', $password)) {
        $errors[] = 'Debe contener al menos un carácter especial (.@,#_)';
    }
    return $errors;
}

/**
 * Attempt login
 * Returns: ['success' => bool, 'message' => string]
 */
function attemptLogin($email, $password)
{
    $data = loadUsers();

    foreach ($data['users'] as $key => $user) {
        if ($user['email'] === $email) {
            // Handle forced password change
            if ($user['password'] === '__PENDING_FIRST_LOGIN__' || ($user['force_change'] ?? false)) {
                // Return success but with a flag to indicate change is required
                // The login.php will need to handle this.
                // For now, let's keep it simple: if it matches, we log them in but keep the flag
                // in the session so we can redirect them to a "change password" view.
                
                if ($user['password'] === '__PENDING_FIRST_LOGIN__') {
                    // Older logic for first login without initial password
                    $errors = validatePasswordComplexity($password);
                    if (!empty($errors)) {
                        return ['success' => false, 'message' => 'Contraseña no cumple requisitos: ' . implode(', ', $errors)];
                    }
                    $data['users'][$key]['password'] = password_hash($password, PASSWORD_DEFAULT);
                    unset($data['users'][$key]['force_change']);
                    saveUsers($data);
                } else {
                    // New logic: password MUST match current hash first
                    if (!password_verify($password, $user['password'])) {
                        return ['success' => false, 'message' => 'Contraseña incorrecta'];
                    }
                    // Password matches, but change is forced.
                    // We'll set a session flag.
                    $_SESSION['force_password_change'] = true;
                }

                $_SESSION['admin_user'] = [
                    'email' => $user['email'],
                    'nombre' => $user['nombre'],
                    'rol' => $user['rol']
                ];
                return ['success' => true, 'message' => 'Bienvenido. Por favor cambie su contraseña.'];
            }

            // Normal password verification
            if (password_verify($password, $user['password'])) {
                $_SESSION['admin_user'] = [
                    'email' => $user['email'],
                    'nombre' => $user['nombre'],
                    'rol' => $user['rol']
                ];
                unset($_SESSION['force_password_change']);
                return ['success' => true, 'message' => 'Bienvenido'];
            }
            else {
                return ['success' => false, 'message' => 'Contraseña incorrecta'];
            }
        }
    }

    return ['success' => false, 'message' => 'Usuario no encontrado'];
}

/**
 * Logout
 */
function logout()
{
    session_destroy();
    header('Location: /login.php');
    exit;
}