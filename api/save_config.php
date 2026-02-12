<?php
/**
 * API Endpoint: Save site configuration
 * Receives JSON POST body and writes to data/config.json
 * Protected by session authentication
 */
session_start();

// Check authentication
if (!isset($_SESSION['admin_user'])) {
    http_response_code(401);
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
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

$configPath = __DIR__ . '/../data/config.json';

// Load current config
$currentConfig = [];
if (file_exists($configPath)) {
    $currentConfig = json_decode(file_get_contents($configPath), true) ?: [];
}

$section = $data['section'] ?? null;
$values = $data['values'] ?? null;

if (!$section || $values === null) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Faltan campos: section y values']);
    exit;
}

// Valid top-level sections
$validSections = [
    'sitio', 'colores', 'empresa', 'navegacion', 'hero',
    'servicios', 'precios', 'ventajas', 'cta', 'contacto',
    'hosting_page', 'footer', 'redes_sociales', 'correo', 'configurador'
];

if (!in_array($section, $validSections)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Sección inválida: ' . $section]);
    exit;
}

// Deep merge for nested structures
function deepMerge($current, $new)
{
    foreach ($new as $key => $value) {
        if (is_array($value) && isset($current[$key]) && is_array($current[$key]) && !isset($value[0])) {
            // Associative array — merge recursively
            $current[$key] = deepMerge($current[$key], $value);
        }
        else {
            // Scalar or indexed array — overwrite
            $current[$key] = $value;
        }
    }
    return $current;
}

// Apply the update
if (is_array($values) && !isset($values[0])) {
    // Associative array — deep merge
    $currentConfig[$section] = deepMerge($currentConfig[$section] ?? [], $values);
}
else {
    // Replace the entire section
    $currentConfig[$section] = $values;
}

// Write back
$result = file_put_contents(
    $configPath,
    json_encode($currentConfig, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
);

if ($result === false) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error al escribir config.json. Verifica los permisos del directorio data/']);
    exit;
}

echo json_encode(['success' => true, 'message' => 'Configuración guardada correctamente']);