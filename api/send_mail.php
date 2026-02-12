<?php
/**
 * API Endpoint: Send Email from Contact Form
 * Processes the contact form and sends an email using configured SMTP settings.
 */
require_once '../includes/config.php';

// Check method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

// Get input
$nombre = trim($_POST['nombre'] ?? '');
$email = trim($_POST['email'] ?? '');
$telefono = trim($_POST['telefono'] ?? '');
$servicio = trim($_POST['servicio'] ?? '');
$mensaje = trim($_POST['mensaje'] ?? '');

if (empty($nombre) || empty($email) || empty($mensaje)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Campos obligatorios faltantes']);
    exit;
}

// Get mail configuration
$config = loadConfig();
$mailConf = $config['correo'] ?? [];

$to = $mailConf['cuenta_recepcion'] ?? 'info@huaweihosting.com';
$subject = "Nuevo mensaje de contacto: $servicio - $nombre";

$body = "Has recibido un nuevo mensaje desde el sitio web:\n\n";
$body .= "Nombre: $nombre\n";
$body .= "Email: $email\n";
$body .= "Teléfono: $telefono\n";
$body .= "Servicio: $servicio\n\n";
$body .= "Mensaje:\n$mensaje\n";

$headers = "From: " . ($mailConf['cuenta_envio'] ?? 'no-reply@huaweihosting.com') . "\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "X-Mailer: PHP/" . phpversion();

// Check if SMTP is configured
if (!empty($mailConf['servidor']) && !empty($mailConf['cuenta_envio']) && !empty($mailConf['password'])) {
    require_once '../includes/SimpleSMTP.php';
    try {
        $smtp = new SimpleSMTP(
            $mailConf['servidor'],
            $mailConf['puerto'] ?? 587,
            $mailConf['cuenta_envio'],
            $mailConf['password']
            );
        $headers_arr = ['Reply-To' => $email, 'X-Mailer' => 'HuaweiHosting/1.0'];
        $success = $smtp->send($mailConf['cuenta_envio'], $to, $subject, $body, $headers_arr);
    }
    catch (Exception $e) {
        error_log("SMTP Error: " . $e->getMessage());
        $success = false;
    }
}
else {
    // Fallback to PHP mail()
    $success = mail($to, $subject, $body, $headers);
}

header('Content-Type: application/json');
if ($success) {
    echo json_encode(['success' => true, 'message' => '¡Mensaje enviado con éxito!']);
}
else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error al enviar el correo. Por favor contacte al soporte.']);
}