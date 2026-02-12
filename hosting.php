<?php
$pageTitle = 'Planes de Hosting';
$pageDescription = 'Descubre nuestros planes de hosting web, cloud y VPS con tecnología Huawei Cloud. Alta velocidad, seguridad y soporte 24/7.';
include 'includes/header.php';
?>

<!-- Page Header -->
<section class="relative py-20 overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-b from-hw-surface/50 to-hw-dark"></div>
    <div class="absolute top-0 right-0 w-96 h-96 bg-hw-red/5 rounded-full blur-3xl"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="text-hw-red font-semibold text-sm uppercase tracking-widest">
            <?= htmlspecialchars(cfg('hosting_page.badge', 'Nuestros Planes'))?>
        </span>
        <h1 class="font-heading font-bold text-4xl sm:text-5xl lg:text-6xl text-white mt-3 mb-5">
            <?= htmlspecialchars(cfg('hosting_page.titulo', 'Planes de Hosting'))?>
        </h1>
        <p class="text-hw-text-secondary text-lg max-w-2xl mx-auto">
            <?= htmlspecialchars(cfg('hosting_page.subtitulo', 'Infraestructura de clase mundial para cada tipo de proyecto.'))?>
        </p>
    </div>
</section>

<!-- Hosting Plans Detail -->
<section class="py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <?php
$planSections = [
    [
        'title_key' => 'shared_titulo',
        'title_default' => 'Hosting Web Compartido',
        'plans_key' => 'shared_planes',
        'icon' => 'fa-globe',
        'color' => 'from-blue-500/20 to-blue-900/10'
    ],
    [
        'title_key' => 'cloud_titulo',
        'title_default' => 'Hosting Cloud',
        'plans_key' => 'cloud_planes',
        'icon' => 'fa-cloud',
        'color' => 'from-purple-500/20 to-purple-900/10'
    ],
    [
        'title_key' => 'vps_titulo',
        'title_default' => 'Servidores VPS',
        'plans_key' => 'vps_planes',
        'icon' => 'fa-server',
        'color' => 'from-hw-red/20 to-hw-red/5'
    ],
];
foreach ($planSections as $ps):
    $sectionTitle = cfg('hosting_page.' . $ps['title_key'], $ps['title_default']);
    $plans = cfg('hosting_page.' . $ps['plans_key'], []);
?>
        <div class="mb-20 reveal">
            <div class="flex items-center gap-4 mb-8">
                <div
                    class="w-14 h-14 rounded-2xl bg-gradient-to-br <?= $ps['color']?> flex items-center justify-center">
                    <i class="fas <?= $ps['icon']?> text-hw-red text-2xl"></i>
                </div>
                <h2 class="font-heading font-bold text-3xl text-white">
                    <?= htmlspecialchars($sectionTitle)?>
                </h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <?php foreach ($plans as $item): ?>
                <div class="card hover:border-hw-red/40">
                    <h3 class="font-heading font-bold text-xl text-white mb-1">
                        <?= htmlspecialchars($item['nombre'] ?? '')?>
                    </h3>
                    <div class="mb-5"><span class="font-heading font-black text-4xl text-white">
                            <?= htmlspecialchars($item['precio'] ?? '')?>
                        </span><span class="text-hw-text-muted text-sm">/mes</span></div>
                    <ul class="space-y-2.5 mb-6">
                        <?php foreach (($item['specs'] ?? []) as $spec): ?>
                        <li class="flex items-center gap-3 text-sm text-hw-text-secondary"><i
                                class="fas fa-check text-hw-red text-xs"></i>
                            <?= htmlspecialchars($spec)?>
                        </li>
                        <?php
        endforeach; ?>
                    </ul>
                    <a href="contacto.php?plan=<?= urlencode($item['nombre'] ?? '')?>"
                        class="btn-secondary w-full justify-center no-underline text-sm">Contratar</a>
                </div>
                <?php
    endforeach; ?>
            </div>
        </div>
        <?php
endforeach; ?>
    </div>
</section>

<!-- Comparison Table -->
<section class="py-20 bg-hw-surface/30 section-gradient">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 reveal">
            <h2 class="font-heading font-bold text-3xl sm:text-4xl text-white mb-4">
                <?= htmlspecialchars(cfg('hosting_page.comparativa_titulo', 'Comparativa de Planes'))?>
            </h2>
            <p class="text-hw-text-secondary">
                <?= htmlspecialchars(cfg('hosting_page.comparativa_subtitulo', 'Compara las características principales de cada tipo de hosting.'))?>
            </p>
        </div>
        <div class="overflow-x-auto reveal">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-hw-border/40">
                        <th class="text-left py-4 px-4 text-hw-text-muted font-semibold">Característica</th>
                        <th class="text-center py-4 px-4 text-white font-heading font-bold">Compartido</th>
                        <th class="text-center py-4 px-4 text-white font-heading font-bold">Cloud</th>
                        <th class="text-center py-4 px-4 text-white font-heading font-bold">VPS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
$comparativa = cfg('hosting_page.comparativa', []);
foreach ($comparativa as $row):
    // Convert ✓ and ✗ to icons
    $cols = ['compartido', 'cloud', 'vps'];
?>
                    <tr class="border-b border-hw-border/20 hover:bg-hw-surface-light/30 transition-colors">
                        <td class="py-3.5 px-4 text-hw-text-secondary">
                            <?= htmlspecialchars($row['caracteristica'] ?? '')?>
                        </td>
                        <?php foreach ($cols as $col):
        $val = $row[$col] ?? '';
?>
                        <td class="py-3.5 px-4 text-center text-hw-text-muted">
                            <?php if ($val === '✓'): ?>
                            <i class="fas fa-check text-hw-red"></i>
                            <?php
        elseif ($val === '✗'): ?>
                            <i class="fas fa-times text-hw-border"></i>
                            <?php
        else: ?>
                            <?= htmlspecialchars($val)?>
                            <?php
        endif; ?>
                        </td>
                        <?php
    endforeach; ?>
                    </tr>
                    <?php
endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- FAQ -->
<section class="py-20">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 reveal">
            <span class="text-hw-red font-semibold text-sm uppercase tracking-widest">FAQ</span>
            <h2 class="font-heading font-bold text-3xl sm:text-4xl text-white mt-3">
                <?= htmlspecialchars(cfg('hosting_page.faq_titulo', 'Preguntas Frecuentes'))?>
            </h2>
        </div>
        <?php
$faqs = cfg('hosting_page.faqs', []);
foreach ($faqs as $i => $faq): ?>
        <div class="card mb-4 reveal cursor-pointer"
            onclick="this.querySelector('.faq-answer').classList.toggle('hidden');this.querySelector('.faq-icon').classList.toggle('rotate-180')">
            <div class="flex items-start justify-between gap-4">
                <h3 class="font-heading font-semibold text-white">
                    <?= htmlspecialchars($faq['pregunta'])?>
                </h3>
                <i class="fas fa-chevron-down text-hw-red text-sm mt-1 faq-icon transition-transform duration-300"></i>
            </div>
            <p class="faq-answer hidden text-hw-text-muted text-sm mt-3 leading-relaxed">
                <?= htmlspecialchars($faq['respuesta'])?>
            </p>
        </div>
        <?php
endforeach; ?>
    </div>
</section>

<!-- CTA -->
<section class="py-20 relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-r from-hw-red/10 via-hw-surface to-hw-red/5"></div>
    <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center reveal">
        <h2 class="font-heading font-bold text-3xl sm:text-4xl text-white mb-5">
            <?= htmlspecialchars(cfg('cta.titulo', '¿No estás seguro qué plan elegir?'))?>
        </h2>
        <p class="text-hw-text-secondary text-lg mb-8">
            <?= htmlspecialchars(cfg('cta.subtitulo', 'Nuestro equipo te ayudará a encontrar la solución perfecta.'))?>
        </p>
        <a href="contacto.php" class="btn-primary text-lg !py-4 !px-10 no-underline"><i class="fas fa-headset"></i>
            Contactar un Asesor</a>
    </div>
</section>

<?php include 'includes/footer.php'; ?>