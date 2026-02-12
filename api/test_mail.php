<?php
/**
 * API Endpoint: Test Email Configuration
 * Sends a test email using provided or saved SMTP settings.
 * Returns detailed logs of the SMTP transaction.
 */
session_start();
require_once '../includes/config.php';
require_once '../includes/SimpleSMTP.php';

// Check authentication
if (!isset($_SESSION['admin_user'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

// Use provided settings or fallback to config
$config = loadConfig();
$mailConf = $config['correo'] ?? [];

$host = $input['servidor'] ?? $mailConf['servidor'] ?? '';
$port = $input['puerto'] ?? $mailConf['puerto'] ?? 587;
$user = $input['cuenta_envio'] ?? $mailConf['cuenta_envio'] ?? '';
$pass = $input['password'] ?? $mailConf['password'] ?? '';
$to = $input['test_email'] ?? $mailConf['cuenta_recepcion'] ?? '';

if (empty($host) || empty($user) || empty($pass) || empty($to)) {
    echo json_encode(['success' => false, 'message' => 'Faltan datos de configuración SMTP o email de destino']);
    exit;
}

$smtp = new SimpleSMTP($host, $port, $user, $pass);
$smtp->setDebug(true);

try {
    $subject = "Prueba de Configuración SMTP - Huawei Hosting";
    $body = "Hola,\n\nSi estás leyendo esto, la configuración de correo SMTP es correcta.\n\n" .
        "Servidor: $host:$port\n" .
        "Usuario: $user\n\n" .
        "Enviado el: " . date('Y-m-d H:i:s');

    $smtp->send($user, $to, $subject, $body);

    echo json_encode([
        'success' => true,
        'message' => 'Correo de prueba enviado correctamente a ' . $to,
        'logs' => $smtp->getLog()
    ]);

}
catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error al enviar: ' . $e->getMessage(),
        'logs' => $smtp->getLog()
    ]);
}