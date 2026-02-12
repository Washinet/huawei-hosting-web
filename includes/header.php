<?php
// Load site configuration
if (!function_exists('cfg')) {
    require_once __DIR__ . '/config.php';
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo isset($pageTitle) ? $pageTitle . ' | ' . cfg('sitio.nombre', 'Huawei Hosting') : cfg('sitio.nombre', 'Huawei Hosting') . ' — ' . cfg('sitio.slogan', 'Soluciones de Alojamiento Web'); ?>
    </title>
    <meta name="description"
        content="<?php echo isset($pageDescription) ? $pageDescription : 'Hosting web de alto rendimiento con tecnología Huawei Cloud. Planes desde hosting compartido hasta servidores dedicados.'; ?>">

    <!-- Tailwind CSS v3 CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'hw-dark': 'var(--hw-dark)',
                        'hw-surface': 'var(--hw-surface)',
                        'hw-surface-light': 'var(--hw-surface-light)',
                        'hw-red': 'var(--hw-red)',
                        'hw-red-hover': 'var(--hw-red-hover)',
                        'hw-text': 'var(--hw-text)',
                        'hw-text-secondary': 'var(--hw-text-secondary)',
                        'hw-text-muted': 'var(--hw-text-muted)',
                        'hw-border': 'var(--hw-border)',
                    },
                    fontFamily: {
                        'heading': ['Outfit', 'sans-serif'],
                        'body': ['Inter', 'sans-serif'],
                    },
                }
            }
        }
    </script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Outfit:wght@400;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        /* ===== Dynamic Color Variables from config.json ===== */
        :root {
            --hw-dark: <?=cfg('colores.fondo_principal', '#0d0d0d')?>;
            --hw-surface: <?=cfg('colores.superficie', '#1a1a2e')?>;
            --hw-surface-light: <?=cfg('colores.superficie_clara', '#16213e')?>;
            --hw-red: <?=cfg('colores.acento', '#C7000B')?>;
            --hw-red-hover: <?=cfg('colores.acento_hover', '#e5000d')?>;
            --hw-text: <?=cfg('colores.texto_principal', '#ffffff')?>;
            --hw-text-secondary: <?=cfg('colores.texto_secundario', '#cbd5e1')?>;
            --hw-text-muted: <?=cfg('colores.texto_muted', '#64748b')?>;
            --hw-border: <?=cfg('colores.borde', '#334155')?>;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--hw-dark);
            color: var(--hw-text-secondary);
            overflow-x: hidden;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Outfit', sans-serif;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--hw-dark);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--hw-border);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--hw-red);
        }

        /* Navbar */
        .navbar {
            backdrop-filter: blur(20px);
            background: color-mix(in srgb, var(--hw-dark) 85%, transparent);
            border-bottom: 1px solid color-mix(in srgb, var(--hw-border) 40%, transparent);
            transition: all 0.3s ease;
        }

        .navbar.scrolled {
            background: color-mix(in srgb, var(--hw-dark) 95%, transparent);
            box-shadow: 0 4px 30px color-mix(in srgb, var(--hw-red) 10%, transparent);
        }

        .nav-link {
            position: relative;
            color: var(--hw-text-secondary);
            transition: color 0.3s ease;
            font-weight: 500;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--hw-red), var(--hw-red-hover));
            transition: width 0.3s ease;
            border-radius: 2px;
        }

        .nav-link:hover,
        .nav-link.active {
            color: var(--hw-text);
        }

        .nav-link:hover::after,
        .nav-link.active::after {
            width: 100%;
        }

        /* Mobile menu */
        .mobile-menu {
            transform: translateX(100%);
            transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .mobile-menu.open {
            transform: translateX(0);
        }

        .mobile-overlay {
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }

        .mobile-overlay.open {
            opacity: 1;
            pointer-events: auto;
        }

        /* Hamburger animation */
        .hamburger span {
            display: block;
            width: 24px;
            height: 2px;
            background: var(--hw-text-secondary);
            border-radius: 2px;
            transition: all 0.3s ease;
        }

        .hamburger.active span:nth-child(1) {
            transform: rotate(45deg) translate(5px, 5px);
        }

        .hamburger.active span:nth-child(2) {
            opacity: 0;
        }

        .hamburger.active span:nth-child(3) {
            transform: rotate(-45deg) translate(5px, -5px);
        }

        /* Buttons */
        .btn-primary {
            background: linear-gradient(135deg, var(--hw-red), var(--hw-red-hover));
            color: white;
            font-weight: 600;
            padding: 12px 32px;
            border-radius: 8px;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-family: 'Inter', sans-serif;
            font-size: 0.95rem;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px color-mix(in srgb, var(--hw-red) 40%, transparent);
        }

        .btn-secondary {
            background: transparent;
            color: var(--hw-text);
            font-weight: 600;
            padding: 12px 32px;
            border-radius: 8px;
            border: 2px solid var(--hw-red);
            transition: all 0.3s ease;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-family: 'Inter', sans-serif;
            font-size: 0.95rem;
        }

        .btn-secondary:hover {
            background: color-mix(in srgb, var(--hw-red) 15%, transparent);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px color-mix(in srgb, var(--hw-red) 20%, transparent);
        }

        /* Cards */
        .card {
            background: color-mix(in srgb, var(--hw-surface) 60%, transparent);
            border: 1px solid color-mix(in srgb, var(--hw-border) 40%, transparent);
            border-radius: 16px;
            padding: 32px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, transparent, var(--hw-red), transparent);
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .card:hover {
            transform: translateY(-8px) scale(1.02);
            border-color: color-mix(in srgb, var(--hw-red) 40%, transparent);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4), 0 0 30px color-mix(in srgb, var(--hw-red) 10%, transparent);
        }

        .card:hover::before {
            opacity: 1;
        }

        .card img {
            aspect-ratio: 1/1;
            object-fit: cover;
            border-radius: 12px;
        }

        /* Pricing cards */
        .pricing-card {
            background: color-mix(in srgb, var(--hw-surface) 50%, transparent);
            border: 1px solid color-mix(in srgb, var(--hw-border) 40%, transparent);
            border-radius: 20px;
            padding: 40px 32px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }

        .pricing-card.featured {
            background: linear-gradient(145deg, color-mix(in srgb, var(--hw-red) 8%, transparent), color-mix(in srgb, var(--hw-surface) 80%, transparent));
            border-color: color-mix(in srgb, var(--hw-red) 50%, transparent);
            transform: scale(1.05);
        }

        .pricing-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
        }

        .pricing-card.featured:hover {
            transform: scale(1.05) translateY(-8px);
        }

        /* Section gradients */
        .section-gradient {
            position: relative;
        }

        .section-gradient::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60%;
            height: 1px;
            background: linear-gradient(90deg, transparent, color-mix(in srgb, var(--hw-red) 30%, transparent), transparent);
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        @keyframes pulse-glow {

            0%,
            100% {
                box-shadow: 0 0 20px color-mix(in srgb, var(--hw-red) 20%, transparent);
            }

            50% {
                box-shadow: 0 0 40px color-mix(in srgb, var(--hw-red) 40%, transparent);
            }
        }

        @keyframes gradient-shift {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.8s ease forwards;
        }

        .animate-float {
            animation: float 4s ease-in-out infinite;
        }

        .animate-pulse-glow {
            animation: pulse-glow 3s ease-in-out infinite;
        }

        /* Glow effects */
        .glow-red {
            box-shadow: 0 0 30px color-mix(in srgb, var(--hw-red) 15%, transparent);
        }

        .text-gradient {
            background: linear-gradient(135deg, var(--hw-text), var(--hw-red));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Form styles */
        .form-input {
            background: color-mix(in srgb, var(--hw-surface) 60%, transparent);
            border: 1px solid color-mix(in srgb, var(--hw-border) 50%, transparent);
            border-radius: 10px;
            padding: 14px 18px;
            color: var(--hw-text);
            font-family: 'Inter', sans-serif;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            width: 100%;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--hw-red);
            box-shadow: 0 0 0 3px color-mix(in srgb, var(--hw-red) 15%, transparent);
        }

        .form-input::placeholder {
            color: var(--hw-text-muted);
        }

        select.form-input {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%2364748b' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 16px center;
            padding-right: 40px;
        }

        textarea.form-input {
            resize: vertical;
            min-height: 120px;
        }

        /* Intersection Observer reveal */
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar fixed top-0 left-0 w-full z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 lg:h-20">
                <!-- Logo -->
                <a href="index.php" class="flex items-center gap-3 no-underline">
                    <div
                        class="w-10 h-10 rounded-lg bg-gradient-to-br from-hw-red to-hw-red-hover flex items-center justify-center">
                        <i
                            class="fas <?= htmlspecialchars(cfg('sitio.logo_icono', 'fa-server'))?> text-white text-lg"></i>
                    </div>
                    <div>
                        <span class="text-white font-heading font-bold text-xl tracking-tight">
                            <?= htmlspecialchars(cfg('sitio.nombre_corto', 'HUAWEI'))?>
                        </span>
                        <span class="text-hw-red font-heading font-bold text-xl ml-1">
                            <?= htmlspecialchars(cfg('sitio.nombre_marca', 'HOSTING'))?>
                        </span>
                    </div>
                </a>

                <!-- Desktop Nav -->
                <div class="hidden lg:flex items-center gap-8">
                    <a href="index.php" class="nav-link <?= $activePage == 'index' ? 'active' : ''?>">Inicio</a>
                    <a href="hosting.php" class="nav-link <?= $activePage == 'hosting' ? 'active' : ''?>">Planes</a>
                    <a href="configurador.php"
                        class="nav-link <?= $activePage == 'configurador' ? 'active' : ''?>">Personalizar</a>
                    <a href="contacto.php"
                        class="nav-link <?= $activePage == 'contacto' ? 'active' : ''?>">Contacto</a>
                    <a href="<?= htmlspecialchars(cfg('navegacion.cta_url', 'contacto.php'))?>"
                        class="btn-primary text-sm !py-2.5 !px-6 no-underline">
                        <i class="fas fa-rocket"></i>
                        <?= htmlspecialchars(cfg('navegacion.cta_texto', 'Comenzar'))?>
                    </a>
                </div>

                <!-- Mobile Hamburger -->
                <button class="hamburger lg:hidden flex flex-col gap-1.5 p-2 z-50" onclick="toggleMenu()"
                    aria-label="Menú">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
        </div>
    </nav>

    <!-- Mobile Overlay -->
    <div class="mobile-overlay fixed inset-0 bg-black/60 z-40" onclick="toggleMenu()"></div>

    <!-- Mobile Menu -->
    <div
        class="mobile-menu fixed top-0 right-0 h-full w-72 bg-hw-dark border-l border-hw-border z-50 flex flex-col pt-24 px-6">
        <?php foreach ($navItems as $nav): ?>
        <a href="<?= htmlspecialchars($nav['url'])?>"
            class="text-white font-heading text-lg py-3 border-b border-hw-border/50 no-underline hover:text-hw-red transition-colors flex items-center gap-3">
            <i class="fas <?= htmlspecialchars($nav['icono'])?> text-hw-red w-5"></i>
            <?= htmlspecialchars($nav['texto'])?>
        </a>
        <?php
endforeach; ?>
        <a href="<?= htmlspecialchars(cfg('navegacion.cta_url', 'contacto.php'))?>"
            class="btn-primary mt-6 justify-center no-underline">
            <i class="fas fa-rocket"></i>
            <?= htmlspecialchars(cfg('navegacion.cta_texto', 'Comenzar'))?>
        </a>
    </div>

    <!-- Spacer for fixed navbar -->
    <div class="h-16 lg:h-20"></div>

    <script>
        // Hamburger menu toggle
        function toggleMenu() {
            document.querySelector('.hamburger').classList.toggle('active');
            document.querySelector('.mobile-menu').classList.toggle('open');
            document.querySelector('.mobile-overlay').classList.toggle('open');
            document.body.style.overflow = document.querySelector('.mobile-menu').classList.contains('open') ? 'hidden' : '';
        }

        // Navbar scroll effect
        window.addEventListener('scroll', () => {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Intersection Observer for reveal animations
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
        });
    </script>