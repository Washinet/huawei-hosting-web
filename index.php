<?php
$pageTitle = 'Inicio';
$pageDescription = 'Huawei Hosting — Soluciones de alojamiento web de alto rendimiento con tecnología Huawei Cloud.';
include 'includes/header.php';
?>

<!-- Hero Section -->
<section class="relative min-h-[90vh] flex items-center overflow-hidden">
    <div class="absolute inset-0">
        <img src="assets/img/hero-bg.png" alt="" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-b from-hw-dark/80 via-hw-dark/70 to-hw-dark"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-hw-dark/90 via-transparent to-hw-dark/60"></div>
    </div>
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-1/4 left-1/4 w-2 h-2 bg-hw-red/30 rounded-full animate-float"></div>
        <div class="absolute top-1/3 right-1/3 w-1.5 h-1.5 bg-hw-red/20 rounded-full animate-float"
            style="animation-delay:1s"></div>
        <div class="absolute bottom-1/4 left-1/2 w-1 h-1 bg-hw-red/40 rounded-full animate-float"
            style="animation-delay:2s"></div>
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="max-w-3xl">
            <div class="animate-fade-in-up">
                <span
                    class="inline-flex items-center gap-2 bg-hw-red/10 border border-hw-red/30 text-hw-red text-sm font-semibold px-4 py-1.5 rounded-full mb-6">
                    <i class="fas <?= htmlspecialchars(cfg('hero.badge_icono', 'fa-bolt'))?>"></i>
                    <?= htmlspecialchars(cfg('hero.badge', 'Tecnología Huawei Cloud'))?>
                </span>
            </div>
            <h1 class="font-heading font-black text-5xl sm:text-6xl lg:text-7xl text-white leading-tight mb-6 animate-fade-in-up"
                style="animation-delay:0.1s">
                <?= htmlspecialchars(cfg('hero.titulo', 'Hosting de Alto Rendimiento'))?>
            </h1>
            <p class="text-hw-text-secondary text-lg sm:text-xl leading-relaxed mb-10 max-w-xl animate-fade-in-up"
                style="animation-delay:0.2s">
                <?= htmlspecialchars(cfg('hero.subtitulo', 'Potencia tu presencia digital con servidores de última generación.'))?>
            </p>
            <div class="flex flex-wrap gap-4 animate-fade-in-up" style="animation-delay:0.3s">
                <a href="<?= htmlspecialchars(cfg('hero.btn_primario_url', 'hosting.php'))?>"
                    class="btn-primary text-lg !py-4 !px-8 no-underline">
                    <i class="fas <?= htmlspecialchars(cfg('hero.btn_primario_icono', 'fa-rocket'))?>"></i>
                    <?= htmlspecialchars(cfg('hero.btn_primario_texto', 'Ver Planes'))?>
                </a>
                <a href="configurador.php" class="btn-secondary text-lg !py-4 !px-8 no-underline">
                    <i class="fas fa-sliders-h"></i> Personalizar mi Plan
                </a>
            </div>
            <div class="flex flex-wrap gap-8 mt-14 animate-fade-in-up" style="animation-delay:0.4s">
                <?php $stats = cfg('hero.stats', [['valor' => '99.9%', 'etiqueta' => 'Uptime'], ['valor' => '+5K', 'etiqueta' => 'Clientes'], ['valor' => '24/7', 'etiqueta' => 'Soporte'], ['valor' => '<50ms', 'etiqueta' => 'Latencia']]);
foreach ($stats as $si => $stat): ?>
                <?php if ($si > 0): ?>
                <div class="w-px bg-hw-border/50 self-stretch <?= $si === 3 ? 'hidden sm:block' : ''?>"></div>
                <?php
    endif; ?>
                <div class="text-center <?= $si === 3 ? 'hidden sm:block' : ''?>">
                    <div class="text-3xl font-heading font-bold text-white">
                        <?= htmlspecialchars($stat['valor'])?>
                    </div>
                    <div class="text-hw-text-muted text-sm mt-1">
                        <?= htmlspecialchars($stat['etiqueta'])?>
                    </div>
                </div>
                <?php
endforeach; ?>
            </div>
        </div>
    </div>
</section>

<!-- Services -->
<section class="py-24 section-gradient">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 reveal">
            <span class="text-hw-red font-semibold text-sm uppercase tracking-widest">
                <?= htmlspecialchars(cfg('servicios.seccion_badge', 'Nuestros Servicios'))?>
            </span>
            <h2 class="font-heading font-bold text-4xl sm:text-5xl text-white mt-3 mb-5">
                <?= htmlspecialchars(cfg('servicios.seccion_titulo', 'Soluciones para cada necesidad digital'))?>
            </h2>
            <p class="text-hw-text-secondary text-lg max-w-2xl mx-auto">
                <?= htmlspecialchars(cfg('servicios.seccion_subtitulo', 'Desde hosting compartido hasta servidores dedicados.'))?>
            </p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php
$services = cfg('servicios.items', []);
foreach ($services as $i => $s):
    $delay = ($i + 1) * 0.1; ?>
            <div class="card reveal" style="transition-delay:<?= $delay?>s">
                <img src="<?= htmlspecialchars($s['imagen'] ?? 'assets/img/service-web.png')?>"
                    alt="<?= htmlspecialchars($s['titulo'])?>" class="w-full h-48 object-cover rounded-xl mb-5">
                <div class="w-12 h-12 rounded-xl bg-hw-red/10 flex items-center justify-center mb-4"><i
                        class="fas <?= htmlspecialchars($s['icono'])?> text-hw-red text-xl"></i></div>
                <h3 class="font-heading font-bold text-xl text-white mb-3">
                    <?= htmlspecialchars($s['titulo'])?>
                </h3>
                <p class="text-hw-text-muted text-sm leading-relaxed mb-4">
                    <?= htmlspecialchars($s['descripcion'])?>
                </p>
                <a href="hosting.php"
                    class="text-hw-red text-sm font-semibold hover:text-hw-red-hover transition-colors no-underline inline-flex items-center gap-1">Ver
                    más <i class="fas fa-arrow-right text-xs"></i></a>
            </div>
            <?php
endforeach; ?>
        </div>
    </div>
</section>

<!-- Pricing -->
<section class="py-24 bg-hw-surface/30 section-gradient">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 reveal">
            <span class="text-hw-red font-semibold text-sm uppercase tracking-widest">
                <?= htmlspecialchars(cfg('precios.seccion_badge', 'Planes y Precios'))?>
            </span>
            <h2 class="font-heading font-bold text-4xl sm:text-5xl text-white mt-3 mb-5">
                <?= htmlspecialchars(cfg('precios.seccion_titulo', 'Elige tu plan ideal'))?>
            </h2>
            <p class="text-hw-text-secondary text-lg max-w-2xl mx-auto">
                <?= htmlspecialchars(cfg('precios.seccion_subtitulo', 'Planes flexibles que se adaptan a tu negocio.'))?>
            </p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8 items-start">
            <?php
$planKeys = ['basico', 'profesional', 'enterprise'];
foreach ($planKeys as $i => $pk):
    $p = cfg("precios.planes.$pk", []);
    $featured = !empty($p['destacado']);
    $feats = $p['caracteristicas'] ?? [];
    $noFeats = $p['no_incluye'] ?? [];
?>
            <div class="pricing-card <?= $featured ? 'featured animate-pulse-glow' : ''?> reveal"
                style="transition-delay:<?=($i + 1) * 0.1?>s">
                <?php if ($featured): ?>
                <div class="absolute -top-4 left-1/2 -translate-x-1/2"><span
                        class="bg-gradient-to-r from-hw-red to-hw-red-hover text-white text-xs font-bold px-4 py-1.5 rounded-full uppercase tracking-wider">Más
                        Popular</span></div>
                <?php
    endif; ?>
                <div class="text-center">
                    <h3 class="font-heading font-bold text-xl text-white mb-1">
                        <?= htmlspecialchars($p['nombre'] ?? ucfirst($pk))?>
                    </h3>
                    <p class="text-hw-text-muted text-sm mb-6">
                        <?= htmlspecialchars($p['subtitulo'] ?? '')?>
                    </p>
                    <div class="mb-8"><span class="text-hw-text-muted text-sm">$</span><span
                            class="font-heading font-black text-5xl text-white">
                            <?= htmlspecialchars($p['precio'] ?? '0')?>
                        </span><span class="text-hw-text-muted text-sm">/mes</span></div>
                </div>
                <ul class="space-y-3 mb-8">
                    <?php foreach ($feats as $f): ?>
                    <li class="flex items-center gap-3 text-sm text-hw-text-secondary"><i
                            class="fas fa-check text-hw-red text-xs"></i>
                        <?= htmlspecialchars($f)?>
                    </li>
                    <?php
    endforeach; ?>
                    <?php foreach ($noFeats as $n): ?>
                    <li class="flex items-center gap-3 text-sm text-hw-text-muted"><i
                            class="fas fa-times text-hw-border text-xs"></i>
                        <?= htmlspecialchars($n)?>
                    </li>
                    <?php
    endforeach; ?>
                </ul>
                <a href="contacto.php"
                    class="<?= $featured ? 'btn-primary' : 'btn-secondary'?> w-full justify-center no-underline">Elegir
                    Plan</a>
            </div>
            <?php
endforeach; ?>
        </div>
    </div>
</section>

<!-- Why Choose Us -->
<section class="py-24 section-gradient">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 reveal">
            <span class="text-hw-red font-semibold text-sm uppercase tracking-widest">
                <?= htmlspecialchars(cfg('ventajas.seccion_badge', '¿Por Qué Elegirnos?'))?>
            </span>
            <h2 class="font-heading font-bold text-4xl sm:text-5xl text-white mt-3 mb-5">
                <?= htmlspecialchars(cfg('ventajas.seccion_titulo', 'La diferencia Huawei'))?>
            </h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php
$features = cfg('ventajas.items', []);
foreach ($features as $i => $f): ?>
            <div class="card text-center reveal" style="transition-delay:<?=($i + 1) * 0.1?>s">
                <div
                    class="w-16 h-16 rounded-2xl bg-gradient-to-br from-hw-red/20 to-hw-red/5 flex items-center justify-center mx-auto mb-5">
                    <i class="fas <?= htmlspecialchars($f['icono'])?> text-hw-red text-2xl"></i>
                </div>
                <h3 class="font-heading font-bold text-lg text-white mb-3">
                    <?= htmlspecialchars($f['titulo'])?>
                </h3>
                <p class="text-hw-text-muted text-sm">
                    <?= htmlspecialchars($f['descripcion'])?>
                </p>
            </div>
            <?php
endforeach; ?>
        </div>
    </div>
</section>

<!-- CTA Banner -->
<section class="py-24 relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-r from-hw-red/10 via-hw-surface to-hw-red/5"></div>
    <div class="absolute top-0 left-0 w-96 h-96 bg-hw-red/5 rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2">
    </div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-hw-red/5 rounded-full blur-3xl translate-x-1/2 translate-y-1/2">
    </div>
    <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center reveal">
        <h2 class="font-heading font-bold text-4xl sm:text-5xl text-white mb-6">
            <?= htmlspecialchars(cfg('cta.titulo', '¿Listo para potenciar tu presencia digital?'))?>
        </h2>
        <p class="text-hw-text-secondary text-lg mb-10 max-w-2xl mx-auto">
            <?= htmlspecialchars(cfg('cta.subtitulo', 'Únete a más de 5,000 empresas que confían en Huawei Hosting.'))?>
        </p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="<?= htmlspecialchars(cfg('cta.btn_primario_url', 'hosting.php'))?>"
                class="btn-primary text-lg !py-4 !px-10 no-underline"><i class="fas fa-rocket"></i>
                <?= htmlspecialchars(cfg('cta.btn_primario_texto', 'Comenzar Ahora'))?>
            </a>
            <a href="<?= htmlspecialchars(cfg('cta.btn_secundario_url', 'contacto.php'))?>"
                class="btn-secondary text-lg !py-4 !px-10 no-underline"><i class="fas fa-phone"></i>
                <?= htmlspecialchars(cfg('cta.btn_secundario_texto', 'Hablar con Ventas'))?>
            </a>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>