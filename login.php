<?php
require_once 'includes/auth.php';

// If already logged in, redirect to admin
if (isset($_SESSION['admin_user'])) {
    header('Location: admin.php');
    exit;
}

$error = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $error = 'Todos los campos son obligatorios';
    }
    else {
        $result = attemptLogin($email, $password);
        if ($result['success']) {
            header('Location: admin.php');
            exit;
        }
        else {
            $error = $result['message'];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Panel de Administración</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'hw-dark': '#0d0d0d',
                        'hw-surface': '#1a1a2e',
                        'hw-red': '#C7000B',
                        'hw-red-hover': '#e5000d',
                        'hw-text-secondary': '#cbd5e1',
                        'hw-text-muted': '#64748b',
                        'hw-border': '#334155',
                    },
                    fontFamily: {
                        'heading': ['Outfit', 'sans-serif'],
                        'body': ['Inter', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Outfit:wght@400;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #0d0d0d;
            color: #cbd5e1;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        h1,
        h2,
        h3 {
            font-family: 'Outfit', sans-serif;
        }

        .login-card {
            background: rgba(26, 26, 46, 0.7);
            border: 1px solid rgba(51, 65, 85, 0.5);
            border-radius: 24px;
            backdrop-filter: blur(20px);
            position: relative;
            overflow: hidden;
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, transparent, #C7000B, transparent);
        }

        .form-input {
            background: rgba(13, 13, 13, 0.6);
            border: 1px solid rgba(51, 65, 85, 0.5);
            border-radius: 12px;
            padding: 14px 18px;
            color: #ffffff;
            font-family: 'Inter', sans-serif;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            width: 100%;
        }

        .form-input:focus {
            outline: none;
            border-color: #C7000B;
            box-shadow: 0 0 0 3px rgba(199, 0, 11, 0.15);
        }

        .form-input::placeholder {
            color: #64748b;
        }

        .btn-login {
            background: linear-gradient(135deg, #C7000B, #e5000d);
            color: white;
            font-weight: 600;
            padding: 14px 32px;
            border-radius: 12px;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            width: 100%;
            font-family: 'Inter', sans-serif;
            font-size: 1rem;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(199, 0, 11, 0.4);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .bg-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.15;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 0.1;
            }

            50% {
                opacity: 0.2;
            }
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        .animate-pulse-slow {
            animation: pulse 4s ease-in-out infinite;
        }

        .password-toggle {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #64748b;
            cursor: pointer;
            padding: 4px;
            transition: color 0.3s;
        }

        .password-toggle:hover {
            color: #C7000B;
        }
    </style>
</head>

<body>
    <!-- Background orbs -->
    <div class="bg-orb w-96 h-96 bg-hw-red -top-48 -left-48 animate-pulse-slow"></div>
    <div class="bg-orb w-72 h-72 bg-hw-red bottom-0 right-0 translate-x-1/3 translate-y-1/3 animate-pulse-slow"
        style="animation-delay:2s"></div>
    <div class="bg-orb w-48 h-48 bg-blue-500 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 animate-float"></div>

    <div class="login-card w-full max-w-md mx-4 p-8 sm:p-10">
        <!-- Logo -->
        <div class="text-center mb-8">
            <div
                class="w-16 h-16 rounded-2xl bg-gradient-to-br from-hw-red to-hw-red-hover flex items-center justify-center mx-auto mb-4 shadow-lg shadow-hw-red/20">
                <i class="fas fa-server text-white text-2xl"></i>
            </div>
            <h1 class="font-heading font-bold text-2xl text-white">Panel de Administración</h1>
            <p class="text-hw-text-muted text-sm mt-1">Ingresa tus credenciales para continuar</p>
        </div>

        <?php if ($error): ?>
        <div
            class="mb-6 p-4 rounded-xl bg-red-500/10 border border-red-500/30 text-red-400 text-sm flex items-center gap-3">
            <i class="fas fa-exclamation-circle"></i>
            <span>
                <?= htmlspecialchars($error)?>
            </span>
        </div>
        <?php
endif; ?>

        <form method="POST" action="login.php">
            <div class="mb-5">
                <label class="block text-hw-text-secondary text-sm font-medium mb-2">
                    <i class="fas fa-envelope text-hw-text-muted text-xs mr-1"></i> Correo electrónico
                </label>
                <input type="email" name="email" class="form-input" placeholder="tu@email.com"
                    value="<?= htmlspecialchars($email)?>" required autocomplete="email">
            </div>
            <div class="mb-6">
                <label class="block text-hw-text-secondary text-sm font-medium mb-2">
                    <i class="fas fa-lock text-hw-text-muted text-xs mr-1"></i> Contraseña
                </label>
                <div class="relative">
                    <input type="password" name="password" id="passwordInput" class="form-input !pr-12"
                        placeholder="••••••••" required autocomplete="current-password">
                    <button type="button" class="password-toggle" onclick="togglePassword()">
                        <i class="fas fa-eye" id="eyeIcon"></i>
                    </button>
                </div>
                <p class="text-hw-text-muted text-xs mt-2">Mín. 8 caracteres: mayúscula, minúscula, número y carácter
                    especial (.@,#_)</p>
            </div>
            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt mr-2"></i> Iniciar Sesión
            </button>
        </form>

        <div class="mt-8 pt-6 border-t border-hw-border/30 text-center">
            <a href="index.php" class="text-hw-text-muted hover:text-hw-red transition-colors text-sm no-underline">
                <i class="fas fa-arrow-left mr-1"></i> Volver al sitio principal
            </a>
        </div>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('passwordInput');
            const icon = document.getElementById('eyeIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>
</body>

</html>