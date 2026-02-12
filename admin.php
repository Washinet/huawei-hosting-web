<?php
require_once 'includes/auth.php';
requireAuth();
require_once 'includes/config.php';
$adminUser = getCurrentUser();
$pageTitle = 'Panel de Administración';
$pageDescription = 'Panel de configuración del sitio Huawei Hosting.';
include 'includes/header.php';
?>

<section class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Admin Header -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="font-heading font-bold text-2xl sm:text-3xl text-white">Panel de Administración</h1>
                <p class="text-hw-text-muted text-sm mt-1">Bienvenido,
                    <?= htmlspecialchars($adminUser['nombre'])?> (
                    <?= htmlspecialchars($adminUser['email'])?>)
                </p>
            </div>
            <div class="flex items-center gap-3">
                <span
                    class="inline-flex items-center gap-2 bg-green-500/10 border border-green-500/30 text-green-400 text-xs px-3 py-1.5 rounded-full"><i
                        class="fas fa-circle text-[8px]"></i> Activo</span>
                <a href="api/logout.php"
                    class="inline-flex items-center gap-2 bg-hw-dark border border-hw-border/50 text-hw-text-muted hover:text-hw-red hover:border-hw-red/40 text-xs px-4 py-2 rounded-lg transition-all no-underline"><i
                        class="fas fa-sign-out-alt"></i> Cerrar Sesión</a>
            </div>
        </div>

        <!-- Forced Password Change Overlay -->
        <?php if (isset($_SESSION['force_password_change'])): ?>
        <div id="passwordOverlay"
            class="fixed inset-0 z-[100] bg-hw-dark/95 backdrop-blur-xl flex items-center justify-center p-4">
            <div class="card max-w-md w-full !p-8 border-hw-red/30 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-hw-red"></div>
                <div class="text-center mb-8">
                    <div class="w-16 h-16 rounded-2xl bg-hw-red/10 flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-key text-hw-red text-2xl"></i>
                    </div>
                    <h2 class="font-heading font-bold text-2xl text-white">Cambio Obligatorio</h2>
                    <p class="text-hw-text-muted text-sm mt-2">Por seguridad, debes cambiar tu contraseña antes de
                        continuar.</p>
                </div>

                <form onsubmit="handleForcedPasswordChange(event)" class="space-y-5">
                    <div>
                        <label class="block text-hw-text-secondary text-sm font-medium mb-2">Nueva Contraseña</label>
                        <input type="password" name="n_password" class="form-input" required placeholder="••••••••">
                    </div>
                    <div>
                        <label class="block text-hw-text-secondary text-sm font-medium mb-2">Confirmar
                            Contraseña</label>
                        <input type="password" name="c_password" class="form-input" required placeholder="••••••••">
                    </div>

                    <div class="p-4 rounded-xl bg-hw-dark/50 border border-hw-border/30">
                        <p class="text-[10px] text-hw-text-muted uppercase tracking-wider font-bold mb-2">REQUISITOS:
                        </p>
                        <ul class="text-[11px] space-y-1 text-hw-text-secondary">
                            <li><i class="fas fa-check-circle text-hw-red/50 mr-1"></i> Mínimo 8 caracteres</li>
                            <li><i class="fas fa-check-circle text-hw-red/50 mr-1"></i> Mayúscula, minúscula y número
                            </li>
                            <li><i class="fas fa-check-circle text-hw-red/50 mr-1"></i> Carácter especial (.@,#_)</li>
                        </ul>
                    </div>

                    <button type="submit" class="btn-primary w-full justify-center !py-3">
                        <i class="fas fa-shield-alt"></i> Actualizar y Continuar
                    </button>

                    <a href="api/logout.php"
                        class="block text-center text-hw-text-muted hover:text-white text-xs mt-4 transition-colors">
                        Cancelar y Cerrar Sesión
                    </a>
                </form>
            </div>
        </div>
        <?php
endif; ?>

        <!-- Toast -->
        <div id="toast"
            class="fixed top-24 right-6 z-50 transform translate-x-[120%] transition-transform duration-300">
            <div id="toastInner" class="flex items-center gap-3 px-5 py-3 rounded-xl shadow-lg backdrop-blur-sm">
                <i id="toastIcon" class="fas fa-check-circle"></i>
                <span id="toastMsg">Guardado</span>
            </div>
        </div>

        <!-- Tab Navigation -->
        <div class="flex flex-wrap gap-1 mb-8 p-1 bg-hw-surface/50 rounded-xl border border-hw-border/30">
            <?php
$tabs = [
    ['id' => 'sitio', 'icon' => 'fa-cog', 'label' => 'Sitio & Marca'],
    ['id' => 'colores', 'icon' => 'fa-palette', 'label' => 'Colores'],
    ['id' => 'empresa', 'icon' => 'fa-building', 'label' => 'Empresa'],
    ['id' => 'hero', 'icon' => 'fa-star', 'label' => 'Hero'],
    ['id' => 'servicios', 'icon' => 'fa-cubes', 'label' => 'Servicios'],
    ['id' => 'precios', 'icon' => 'fa-tags', 'label' => 'Precios'],
    ['id' => 'ventajas', 'icon' => 'fa-trophy', 'label' => 'Ventajas'],
    ['id' => 'hosting', 'icon' => 'fa-server', 'label' => 'Hosting'],
    ['id' => 'textos', 'icon' => 'fa-pen', 'label' => 'Textos'],
    ['id' => 'redes', 'icon' => 'fa-share-alt', 'label' => 'Redes'],
    ['id' => 'correo', 'icon' => 'fa-envelope-open-text', 'label' => 'Correo'],
    ['id' => 'configurador', 'icon' => 'fa-sliders-h', 'label' => 'Configurador'],
    ['id' => 'usuarios', 'icon' => 'fa-users-cog', 'label' => 'Usuarios'],
];
foreach ($tabs as $i => $t): ?>
            <button onclick="switchTab('<?= $t['id']?>')" id="tab-<?= $t['id']?>"
                class="tab-btn flex-1 min-w-[100px] px-3 py-2.5 rounded-lg text-xs font-medium transition-all <?= $i === 0 ? 'bg-hw-red text-white' : 'text-hw-text-muted hover:text-white hover:bg-hw-dark/50'?>">
                <i class="fas <?= $t['icon']?> mr-1"></i>
                <?= $t['label']?>
            </button>
            <?php
endforeach; ?>
        </div>

        <!-- ============== TAB: Sitio & Marca ============== -->
        <div id="panel-sitio" class="tab-panel">
            <div class="card !p-8">
                <h2 class="font-heading font-bold text-xl text-white mb-6 flex items-center gap-3"><i
                        class="fas fa-cog text-hw-red"></i> Identidad del Sitio</h2>
                <form onsubmit="saveSection(event,'sitio')" class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div><label class="block text-hw-text-secondary text-sm font-medium mb-2">Nombre
                                Principal</label><input type="text" name="nombre" class="form-input"
                                value="<?= htmlspecialchars(cfg('sitio.nombre'))?>"></div>
                        <div><label class="block text-hw-text-secondary text-sm font-medium mb-2">Nombre Corto
                                (Logo)</label><input type="text" name="nombre_corto" class="form-input"
                                value="<?= htmlspecialchars(cfg('sitio.nombre_corto'))?>"></div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div><label class="block text-hw-text-secondary text-sm font-medium mb-2">Nombre Marca
                                (Logo)</label><input type="text" name="nombre_marca" class="form-input"
                                value="<?= htmlspecialchars(cfg('sitio.nombre_marca'))?>"></div>
                        <div><label class="block text-hw-text-secondary text-sm font-medium mb-2">Icono del Logo (Font
                                Awesome)</label><input type="text" name="logo_icono" class="form-input"
                                value="<?= htmlspecialchars(cfg('sitio.logo_icono'))?>"></div>
                    </div>
                    <div><label class="block text-hw-text-secondary text-sm font-medium mb-2">Slogan</label><input
                            type="text" name="slogan" class="form-input"
                            value="<?= htmlspecialchars(cfg('sitio.slogan'))?>"></div>
                    <button type="submit" class="btn-primary !py-3"><i class="fas fa-save"></i> Guardar Sitio</button>
                </form>
            </div>
        </div>

        <!-- ============== TAB: Colores ============== -->
        <div id="panel-colores" class="tab-panel hidden">
            <div class="card !p-8">
                <h2 class="font-heading font-bold text-xl text-white mb-2 flex items-center gap-3"><i
                        class="fas fa-palette text-hw-red"></i> Paleta de Colores</h2>
                <p class="text-hw-text-muted text-sm mb-6">Ajusta los colores del sitio. Los cambios se aplican al
                    recargar.</p>
                <form onsubmit="saveSection(event,'colores')" class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        <?php
$colorFields = [
    ['key' => 'fondo_principal', 'label' => 'Fondo Principal'],
    ['key' => 'superficie', 'label' => 'Superficie (Cards)'],
    ['key' => 'superficie_clara', 'label' => 'Superficie Clara'],
    ['key' => 'acento', 'label' => 'Color Acento'],
    ['key' => 'acento_hover', 'label' => 'Acento Hover'],
    ['key' => 'texto_principal', 'label' => 'Texto Principal'],
    ['key' => 'texto_secundario', 'label' => 'Texto Secundario'],
    ['key' => 'texto_muted', 'label' => 'Texto Muted'],
    ['key' => 'borde', 'label' => 'Color Borde'],
];
foreach ($colorFields as $cf): ?>
                        <div>
                            <label class="block text-hw-text-secondary text-sm font-medium mb-2">
                                <?= $cf['label']?>
                            </label>
                            <div class="flex items-center gap-3">
                                <input type="color" name="<?= $cf['key']?>"
                                    value="<?= htmlspecialchars(cfg('colores.' . $cf['key']))?>"
                                    class="w-10 h-10 rounded-lg border border-hw-border/50 bg-transparent cursor-pointer">
                                <input type="text" value="<?= htmlspecialchars(cfg('colores.' . $cf['key']))?>"
                                    class="form-input !py-2 !text-sm font-mono"
                                    oninput="this.previousElementSibling.value=this.value"
                                    onchange="this.previousElementSibling.value=this.value"
                                    data-mirror="<?= $cf['key']?>">
                            </div>
                        </div>
                        <?php
endforeach; ?>
                    </div>
                    <button type="submit" class="btn-primary !py-3"><i class="fas fa-save"></i> Guardar Colores</button>
                </form>
            </div>
        </div>

        <!-- ============== TAB: Empresa ============== -->
        <div id="panel-empresa" class="tab-panel hidden">
            <div class="card !p-8">
                <h2 class="font-heading font-bold text-xl text-white mb-6 flex items-center gap-3"><i
                        class="fas fa-building text-hw-red"></i> Información de Empresa</h2>
                <form onsubmit="saveSection(event,'empresa')" class="space-y-4">
                    <div><label class="block text-hw-text-secondary text-sm font-medium mb-2">Nombre Legal</label><input
                            type="text" name="nombre" class="form-input"
                            value="<?= htmlspecialchars(cfg('empresa.nombre'))?>"></div>
                    <div><label class="block text-hw-text-secondary text-sm font-medium mb-2">Dirección</label><input
                            type="text" name="direccion" class="form-input"
                            value="<?= htmlspecialchars(cfg('empresa.direccion'))?>"></div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div><label class="block text-hw-text-secondary text-sm font-medium mb-2">Teléfono</label><input
                                type="tel" name="telefono" class="form-input"
                                value="<?= htmlspecialchars(cfg('empresa.telefono'))?>"></div>
                        <div><label class="block text-hw-text-secondary text-sm font-medium mb-2">Email</label><input
                                type="email" name="email" class="form-input"
                                value="<?= htmlspecialchars(cfg('empresa.email'))?>"></div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div><label class="block text-hw-text-secondary text-sm font-medium mb-2">Horario
                                Principal</label><input type="text" name="horario" class="form-input"
                                value="<?= htmlspecialchars(cfg('empresa.horario'))?>"></div>
                        <div><label class="block text-hw-text-secondary text-sm font-medium mb-2">Horario
                                Extra</label><input type="text" name="horario_extra" class="form-input"
                                value="<?= htmlspecialchars(cfg('empresa.horario_extra'))?>"></div>
                    </div>
                    <div><label class="block text-hw-text-secondary text-sm font-medium mb-2">WhatsApp URL</label><input
                            type="url" name="whatsapp" class="form-input"
                            value="<?= htmlspecialchars(cfg('empresa.whatsapp'))?>"></div>
                    <button type="submit" class="btn-primary !py-3"><i class="fas fa-save"></i> Guardar Empresa</button>
                </form>
            </div>
        </div>

        <!-- ============== TAB: Hero ============== -->
        <div id="panel-hero" class="tab-panel hidden">
            <div class="card !p-8">
                <h2 class="font-heading font-bold text-xl text-white mb-6 flex items-center gap-3"><i
                        class="fas fa-star text-hw-red"></i> Sección Hero (Portada)</h2>
                <form onsubmit="saveSection(event,'hero')" class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div><label class="block text-hw-text-secondary text-sm font-medium mb-2">Badge
                                Texto</label><input type="text" name="badge" class="form-input"
                                value="<?= htmlspecialchars(cfg('hero.badge'))?>"></div>
                        <div><label class="block text-hw-text-secondary text-sm font-medium mb-2">Badge
                                Icono</label><input type="text" name="badge_icono" class="form-input"
                                value="<?= htmlspecialchars(cfg('hero.badge_icono'))?>"></div>
                    </div>
                    <div><label class="block text-hw-text-secondary text-sm font-medium mb-2">Título
                            Principal</label><input type="text" name="titulo" class="form-input"
                            value="<?= htmlspecialchars(cfg('hero.titulo'))?>"></div>
                    <div><label class="block text-hw-text-secondary text-sm font-medium mb-2">Subtítulo</label><textarea
                            name="subtitulo"
                            class="form-input !min-h-[80px]"><?= htmlspecialchars(cfg('hero.subtitulo'))?></textarea>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div><label class="block text-hw-text-secondary text-sm font-medium mb-2">Botón Primario
                                Texto</label><input type="text" name="btn_primario_texto" class="form-input"
                                value="<?= htmlspecialchars(cfg('hero.btn_primario_texto'))?>"></div>
                        <div><label class="block text-hw-text-secondary text-sm font-medium mb-2">Botón Primario
                                URL</label><input type="text" name="btn_primario_url" class="form-input"
                                value="<?= htmlspecialchars(cfg('hero.btn_primario_url'))?>"></div>
                        <div><label class="block text-hw-text-secondary text-sm font-medium mb-2">Botón Primario
                                Icono</label><input type="text" name="btn_primario_icono" class="form-input"
                                value="<?= htmlspecialchars(cfg('hero.btn_primario_icono'))?>"></div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div><label class="block text-hw-text-secondary text-sm font-medium mb-2">Botón Secundario
                                Texto</label><input type="text" name="btn_secundario_texto" class="form-input"
                                value="<?= htmlspecialchars(cfg('hero.btn_secundario_texto'))?>"></div>
                        <div><label class="block text-hw-text-secondary text-sm font-medium mb-2">Botón Secundario
                                URL</label><input type="text" name="btn_secundario_url" class="form-input"
                                value="<?= htmlspecialchars(cfg('hero.btn_secundario_url'))?>"></div>
                        <div><label class="block text-hw-text-secondary text-sm font-medium mb-2">Botón Secundario
                                Icono</label><input type="text" name="btn_secundario_icono" class="form-input"
                                value="<?= htmlspecialchars(cfg('hero.btn_secundario_icono'))?>"></div>
                    </div>
                    <button type="submit" class="btn-primary !py-3"><i class="fas fa-save"></i> Guardar Hero</button>
                </form>
            </div>
        </div>

        <!-- ============== TAB: Servicios ============== -->
        <div id="panel-servicios" class="tab-panel hidden">
            <div class="card !p-8 mb-6">
                <h2 class="font-heading font-bold text-xl text-white mb-6 flex items-center gap-3"><i
                        class="fas fa-cubes text-hw-red"></i> Sección de Servicios</h2>
                <form onsubmit="saveServiciosTexts(event)" class="space-y-4">
                    <div><label class="block text-hw-text-secondary text-sm font-medium mb-2">Badge</label><input
                            type="text" name="seccion_badge" class="form-input"
                            value="<?= htmlspecialchars(cfg('servicios.seccion_badge'))?>"></div>
                    <div><label class="block text-hw-text-secondary text-sm font-medium mb-2">Título de
                            Sección</label><input type="text" name="seccion_titulo" class="form-input"
                            value="<?= htmlspecialchars(cfg('servicios.seccion_titulo'))?>"></div>
                    <div><label class="block text-hw-text-secondary text-sm font-medium mb-2">Subtítulo de
                            Sección</label><textarea name="seccion_subtitulo"
                            class="form-input !min-h-[60px]"><?= htmlspecialchars(cfg('servicios.seccion_subtitulo'))?></textarea>
                    </div>
                    <button type="submit" class="btn-primary !py-3"><i class="fas fa-save"></i> Guardar Textos</button>
                </form>
            </div>
            <?php
$serviceItems = cfg('servicios.items', []);
foreach ($serviceItems as $i => $svc): ?>
            <div class="card !p-6 mb-4">
                <h3 class="font-heading font-bold text-base text-white mb-4 flex items-center gap-2"><i
                        class="fas <?= htmlspecialchars($svc['icono'])?> text-hw-red text-sm"></i> Servicio
                    <?= $i + 1?>:
                    <?= htmlspecialchars($svc['titulo'])?>
                </h3>
                <form onsubmit="saveServiceItem(event, <?= $i?>)" class="space-y-3">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div><label class="block text-hw-text-muted text-xs mb-1">Título</label><input type="text"
                                name="titulo" class="form-input !py-2 !text-sm"
                                value="<?= htmlspecialchars($svc['titulo'])?>"></div>
                        <div><label class="block text-hw-text-muted text-xs mb-1">Icono (Font Awesome)</label><input
                                type="text" name="icono" class="form-input !py-2 !text-sm"
                                value="<?= htmlspecialchars($svc['icono'])?>"></div>
                    </div>
                    <div><label class="block text-hw-text-muted text-xs mb-1">Descripción</label><textarea
                            name="descripcion"
                            class="form-input !py-2 !text-sm !min-h-[60px]"><?= htmlspecialchars($svc['descripcion'])?></textarea>
                    </div>
                    <button type="submit" class="btn-primary !py-2 !text-sm"><i class="fas fa-save"></i>
                        Guardar</button>
                </form>
            </div>
            <?php
endforeach; ?>
        </div>

        <!-- ============== TAB: Precios ============== -->
        <div id="panel-precios" class="tab-panel hidden">
            <div class="card !p-8 mb-6">
                <h2 class="font-heading font-bold text-xl text-white mb-6 flex items-center gap-3"><i
                        class="fas fa-tags text-hw-red"></i> Sección de Precios</h2>
                <form onsubmit="savePreciosTexts(event)" class="space-y-4">
                    <div><label class="block text-hw-text-secondary text-sm font-medium mb-2">Badge</label><input
                            type="text" name="seccion_badge" class="form-input"
                            value="<?= htmlspecialchars(cfg('precios.seccion_badge'))?>"></div>
                    <div><label class="block text-hw-text-secondary text-sm font-medium mb-2">Título de
                            Sección</label><input type="text" name="seccion_titulo" class="form-input"
                            value="<?= htmlspecialchars(cfg('precios.seccion_titulo'))?>"></div>
                    <div><label class="block text-hw-text-secondary text-sm font-medium mb-2">Subtítulo</label><textarea
                            name="seccion_subtitulo"
                            class="form-input !min-h-[60px]"><?= htmlspecialchars(cfg('precios.seccion_subtitulo'))?></textarea>
                    </div>
                    <button type="submit" class="btn-primary !py-3"><i class="fas fa-save"></i> Guardar Textos</button>
                </form>
            </div>
            <?php
$planKeys = ['basico', 'profesional', 'enterprise'];
$planColors = ['border-hw-border/30', 'border-hw-red/30', 'border-hw-border/30'];
foreach ($planKeys as $pi => $pk):
    $plan = cfg("precios.planes.$pk", []);
?>
            <div class="card !p-6 mb-4 <?= $planColors[$pi]?>">
                <h3 class="font-heading font-bold text-base text-white mb-4 flex items-center gap-2">
                    <?= htmlspecialchars($plan['nombre'] ?? ucfirst($pk))?>
                    <?php if ($pk === 'profesional'): ?><span
                        class="text-xs bg-hw-red/20 text-hw-red px-2 py-0.5 rounded-full">Popular</span>
                    <?php
    endif; ?>
                </h3>
                <form onsubmit="savePlan(event,'<?= $pk?>')" class="space-y-3">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                        <div><label class="block text-hw-text-muted text-xs mb-1">Nombre</label><input type="text"
                                name="nombre" class="form-input !py-2 !text-sm"
                                value="<?= htmlspecialchars($plan['nombre'] ?? '')?>"></div>
                        <div><label class="block text-hw-text-muted text-xs mb-1">Subtítulo</label><input type="text"
                                name="subtitulo" class="form-input !py-2 !text-sm"
                                value="<?= htmlspecialchars($plan['subtitulo'] ?? '')?>"></div>
                        <div><label class="block text-hw-text-muted text-xs mb-1">Precio ($/mes)</label><input
                                type="text" name="precio" class="form-input !py-2 !text-sm"
                                value="<?= htmlspecialchars($plan['precio'] ?? '')?>"></div>
                        <div><label class="block text-hw-text-muted text-xs mb-1">Almacenamiento</label><input
                                type="text" name="almacenamiento" class="form-input !py-2 !text-sm"
                                value="<?= htmlspecialchars($plan['almacenamiento'] ?? '')?>"></div>
                    </div>
                    <div>
                        <label class="block text-hw-text-muted text-xs mb-1">Características (una por línea)</label>
                        <textarea name="caracteristicas"
                            class="form-input !py-2 !text-sm !min-h-[100px]"><?= htmlspecialchars(implode("\n", $plan['caracteristicas'] ?? []))?></textarea>
                    </div>
                    <div>
                        <label class="block text-hw-text-muted text-xs mb-1">No incluye (una por línea)</label>
                        <textarea name="no_incluye"
                            class="form-input !py-2 !text-sm !min-h-[60px]"><?= htmlspecialchars(implode("\n", $plan['no_incluye'] ?? []))?></textarea>
                    </div>
                    <button type="submit" class="btn-primary !py-2 !text-sm"><i class="fas fa-save"></i> Guardar
                        Plan</button>
                </form>
            </div>
            <?php
endforeach; ?>
        </div>

        <!-- ============== TAB: Ventajas ============== -->
        <div id="panel-ventajas" class="tab-panel hidden">
            <div class="card !p-8 mb-6">
                <h2 class="font-heading font-bold text-xl text-white mb-6 flex items-center gap-3"><i
                        class="fas fa-trophy text-hw-red"></i> Sección ¿Por Qué Elegirnos?</h2>
                <form onsubmit="saveVentajasTexts(event)" class="space-y-4">
                    <div><label class="block text-hw-text-secondary text-sm font-medium mb-2">Badge</label><input
                            type="text" name="seccion_badge" class="form-input"
                            value="<?= htmlspecialchars(cfg('ventajas.seccion_badge'))?>"></div>
                    <div><label class="block text-hw-text-secondary text-sm font-medium mb-2">Título</label><input
                            type="text" name="seccion_titulo" class="form-input"
                            value="<?= htmlspecialchars(cfg('ventajas.seccion_titulo'))?>"></div>
                    <button type="submit" class="btn-primary !py-3"><i class="fas fa-save"></i> Guardar Textos</button>
                </form>
            </div>
            <?php
$ventajas = cfg('ventajas.items', []);
foreach ($ventajas as $vi => $v): ?>
            <div class="card !p-6 mb-4">
                <form onsubmit="saveVentajaItem(event, <?= $vi?>)" class="space-y-3">
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div><label class="block text-hw-text-muted text-xs mb-1">Icono</label><input type="text"
                                name="icono" class="form-input !py-2 !text-sm"
                                value="<?= htmlspecialchars($v['icono'])?>"></div>
                        <div class="sm:col-span-2"><label
                                class="block text-hw-text-muted text-xs mb-1">Título</label><input type="text"
                                name="titulo" class="form-input !py-2 !text-sm"
                                value="<?= htmlspecialchars($v['titulo'])?>"></div>
                    </div>
                    <div><label class="block text-hw-text-muted text-xs mb-1">Descripción</label><textarea
                            name="descripcion"
                            class="form-input !py-2 !text-sm !min-h-[60px]"><?= htmlspecialchars($v['descripcion'])?></textarea>
                    </div>
                    <button type="submit" class="btn-primary !py-2 !text-sm"><i class="fas fa-save"></i>
                        Guardar</button>
                </form>
            </div>
            <?php
endforeach; ?>
        </div>

        <!-- ============== TAB: Hosting ============== -->
        <div id="panel-hosting" class="tab-panel hidden">
            <div class="card !p-8 mb-6">
                <h2 class="font-heading font-bold text-xl text-white mb-6 flex items-center gap-3"><i
                        class="fas fa-server text-hw-red"></i> Cabecera de Página Hosting</h2>
                <form onsubmit="saveSection(event,'hosting_page')" class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div><label class="block text-hw-text-secondary text-sm font-medium mb-2">Badge</label><input
                                type="text" name="badge" class="form-input"
                                value="<?= htmlspecialchars(cfg('hosting_page.badge'))?>"></div>
                        <div><label class="block text-hw-text-secondary text-sm font-medium mb-2">Título</label><input
                                type="text" name="titulo" class="form-input"
                                value="<?= htmlspecialchars(cfg('hosting_page.titulo'))?>"></div>
                    </div>
                    <div><label class="block text-hw-text-secondary text-sm font-medium mb-2">Subtítulo</label><textarea
                            name="subtitulo"
                            class="form-input !min-h-[60px]"><?= htmlspecialchars(cfg('hosting_page.subtitulo'))?></textarea>
                    </div>
                    <button type="submit" class="btn-primary !py-3"><i class="fas fa-save"></i> Guardar
                        Cabecera</button>
                </form>
            </div>
            <?php
$hostingSections = [
    ['key' => 'shared', 'label' => 'Hosting Compartido', 'icon' => 'fa-globe'],
    ['key' => 'cloud', 'label' => 'Hosting Cloud', 'icon' => 'fa-cloud'],
    ['key' => 'vps', 'label' => 'Servidores VPS', 'icon' => 'fa-server'],
];
foreach ($hostingSections as $hs):
    $secPlanes = cfg("hosting_page.{$hs['key']}_planes", []);
?>
            <div class="card !p-6 mb-6">
                <h3 class="font-heading font-bold text-lg text-white mb-4 flex items-center gap-2"><i
                        class="fas <?= $hs['icon']?> text-hw-red"></i>
                    <?= $hs['label']?>
                </h3>
                <form onsubmit="saveHostingSectionTexts(event,'<?= $hs['key']?>')" class="space-y-3 mb-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div><label class="block text-hw-text-muted text-xs mb-1">Título</label><input type="text"
                                name="titulo" class="form-input !py-2 !text-sm" value="<?= htmlspecialchars(cfg("
                                hosting_page.{$hs['key']}_titulo"))?>"></div>
                        <div><label class="block text-hw-text-muted text-xs mb-1">Subtítulo</label><input type="text"
                                name="subtitulo" class="form-input !py-2 !text-sm" value="<?= htmlspecialchars(cfg("
                                hosting_page.{$hs['key']}_subtitulo"))?>"></div>
                    </div>
                    <button type="submit" class="btn-primary !py-2 !text-sm"><i class="fas fa-save"></i> Guardar
                        Títulos</button>
                </form>
                <?php foreach ($secPlanes as $spi => $sp): ?>
                <div class="bg-hw-dark/30 rounded-xl p-4 mb-3 border border-hw-border/20">
                    <form onsubmit="saveHostingPlan(event,'<?= $hs['key']?>',<?= $spi?>)" class="space-y-3">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div><label class="block text-hw-text-muted text-xs mb-1">Nombre</label><input type="text"
                                    name="nombre" class="form-input !py-2 !text-sm"
                                    value="<?= htmlspecialchars($sp['nombre'] ?? '')?>"></div>
                            <div><label class="block text-hw-text-muted text-xs mb-1">Precio</label><input type="text"
                                    name="precio" class="form-input !py-2 !text-sm"
                                    value="<?= htmlspecialchars($sp['precio'] ?? '')?>"></div>
                        </div>
                        <div><label class="block text-hw-text-muted text-xs mb-1">Especificaciones (una por
                                línea)</label>
                            <textarea name="specs"
                                class="form-input !py-2 !text-sm !min-h-[80px]"><?= htmlspecialchars(implode("\n", $sp['specs'] ?? []))?></textarea>
                        </div>
                        <button type="submit" class="btn-primary !py-2 !text-sm"><i class="fas fa-save"></i> Guardar
                            <?= htmlspecialchars($sp['nombre'] ?? 'Plan')?>
                        </button>
                    </form>
                </div>
                <?php
    endforeach; ?>
            </div>
            <?php
endforeach; ?>
            <!-- Comparativa -->
            <div class="card !p-6 mb-6">
                <h3 class="font-heading font-bold text-lg text-white mb-4 flex items-center gap-2"><i
                        class="fas fa-table text-hw-red"></i> Tabla Comparativa</h3>
                <form onsubmit="saveComparativa(event)" class="space-y-3">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-4">
                        <div><label class="block text-hw-text-muted text-xs mb-1">Título</label><input type="text"
                                name="comparativa_titulo" class="form-input !py-2 !text-sm"
                                value="<?= htmlspecialchars(cfg('hosting_page.comparativa_titulo'))?>"></div>
                        <div><label class="block text-hw-text-muted text-xs mb-1">Subtítulo</label><input type="text"
                                name="comparativa_subtitulo" class="form-input !py-2 !text-sm"
                                value="<?= htmlspecialchars(cfg('hosting_page.comparativa_subtitulo'))?>"></div>
                    </div>
                    <div class="grid grid-cols-4 gap-2 mb-1">
                        <span class="text-hw-text-muted text-xs font-bold">Característica</span>
                        <span class="text-hw-text-muted text-xs font-bold">Compartido</span>
                        <span class="text-hw-text-muted text-xs font-bold">Cloud</span>
                        <span class="text-hw-text-muted text-xs font-bold">VPS</span>
                    </div>
                    <?php $comp = cfg('hosting_page.comparativa', []);
foreach ($comp as $ci => $cr): ?>
                    <div class="grid grid-cols-4 gap-2">
                        <input type="text" name="comp_<?= $ci?>_carac" class="form-input !py-1.5 !text-xs"
                            value="<?= htmlspecialchars($cr['caracteristica'] ?? '')?>">
                        <input type="text" name="comp_<?= $ci?>_compartido" class="form-input !py-1.5 !text-xs"
                            value="<?= htmlspecialchars($cr['compartido'] ?? '')?>">
                        <input type="text" name="comp_<?= $ci?>_cloud" class="form-input !py-1.5 !text-xs"
                            value="<?= htmlspecialchars($cr['cloud'] ?? '')?>">
                        <input type="text" name="comp_<?= $ci?>_vps" class="form-input !py-1.5 !text-xs"
                            value="<?= htmlspecialchars($cr['vps'] ?? '')?>">
                    </div>
                    <?php
endforeach; ?>
                    <p class="text-hw-text-muted text-xs mt-2">Use ✓ y ✗ para marcas de check/cruz en la tabla.</p>
                    <button type="submit" class="btn-primary !py-2 !text-sm"><i class="fas fa-save"></i> Guardar
                        Comparativa</button>
                </form>
            </div>
            <!-- FAQs -->
            <div class="card !p-6">
                <h3 class="font-heading font-bold text-lg text-white mb-4 flex items-center gap-2"><i
                        class="fas fa-question-circle text-hw-red"></i> Preguntas Frecuentes</h3>
                <div class="flex gap-2 mb-4">
                    <input type="text" id="faqTituloInput" class="form-input !py-2 !text-sm"
                        value="<?= htmlspecialchars(cfg('hosting_page.faq_titulo'))?>" placeholder="Título sección FAQ">
                    <button onclick="saveFaqTitulo()" class="btn-primary !py-2 !text-sm !px-4 whitespace-nowrap"><i
                            class="fas fa-save"></i></button>
                </div>
                <?php $hostingFaqs = cfg('hosting_page.faqs', []);
foreach ($hostingFaqs as $fi => $fq): ?>
                <div class="bg-hw-dark/30 rounded-xl p-4 mb-3 border border-hw-border/20">
                    <form onsubmit="saveFaqItem(event,<?= $fi?>)" class="space-y-2">
                        <input type="text" name="pregunta" class="form-input !py-2 !text-sm"
                            value="<?= htmlspecialchars($fq['pregunta'] ?? '')?>" placeholder="Pregunta">
                        <textarea name="respuesta" class="form-input !py-2 !text-sm !min-h-[60px]"
                            placeholder="Respuesta"><?= htmlspecialchars($fq['respuesta'] ?? '')?></textarea>
                        <div class="flex gap-2">
                            <button type="submit" class="btn-primary !py-2 !text-sm"><i class="fas fa-save"></i>
                                Guardar</button>
                            <button type="button" onclick="deleteFaq(<?= $fi?>)"
                                class="px-3 py-2 rounded-lg text-xs bg-red-500/10 text-red-400 border border-red-500/30 hover:bg-red-500/20 transition-all"><i
                                    class="fas fa-trash"></i></button>
                        </div>
                    </form>
                </div>
                <?php
endforeach; ?>
                <button onclick="addFaq()"
                    class="w-full mt-2 py-3 rounded-xl border-2 border-dashed border-hw-border/40 text-hw-text-muted hover:text-hw-red hover:border-hw-red/40 transition-all text-sm"><i
                        class="fas fa-plus mr-2"></i>Agregar Pregunta</button>
            </div>
        </div>

        <!-- ============== TAB: Textos Generales ============== -->
        <div id="panel-textos" class="tab-panel hidden">
            <!-- CTA -->
            <div class="card !p-8 mb-6">
                <h2 class="font-heading font-bold text-xl text-white mb-6 flex items-center gap-3"><i
                        class="fas fa-bullhorn text-hw-red"></i> Banner CTA (Llamada a la acción)</h2>
                <form onsubmit="saveSection(event,'cta')" class="space-y-4">
                    <div><label class="block text-hw-text-secondary text-sm font-medium mb-2">Título</label><input
                            type="text" name="titulo" class="form-input"
                            value="<?= htmlspecialchars(cfg('cta.titulo'))?>"></div>
                    <div><label class="block text-hw-text-secondary text-sm font-medium mb-2">Subtítulo</label><textarea
                            name="subtitulo"
                            class="form-input !min-h-[60px]"><?= htmlspecialchars(cfg('cta.subtitulo'))?></textarea>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div><label class="block text-hw-text-secondary text-sm font-medium mb-2">Botón
                                Primario</label><input type="text" name="btn_primario_texto" class="form-input"
                                value="<?= htmlspecialchars(cfg('cta.btn_primario_texto'))?>"></div>
                        <div><label class="block text-hw-text-secondary text-sm font-medium mb-2">Botón
                                Secundario</label><input type="text" name="btn_secundario_texto" class="form-input"
                                value="<?= htmlspecialchars(cfg('cta.btn_secundario_texto'))?>"></div>
                    </div>
                    <button type="submit" class="btn-primary !py-3"><i class="fas fa-save"></i> Guardar CTA</button>
                </form>
            </div>
            <!-- Contact Page Texts -->
            <div class="card !p-8 mb-6">
                <h2 class="font-heading font-bold text-xl text-white mb-6 flex items-center gap-3"><i
                        class="fas fa-envelope text-hw-red"></i> Página de Contacto</h2>
                <form onsubmit="saveSection(event,'contacto')" class="space-y-4">
                    <div><label class="block text-hw-text-secondary text-sm font-medium mb-2">Badge</label><input
                            type="text" name="seccion_badge" class="form-input"
                            value="<?= htmlspecialchars(cfg('contacto.seccion_badge'))?>"></div>
                    <div><label class="block text-hw-text-secondary text-sm font-medium mb-2">Título</label><input
                            type="text" name="seccion_titulo" class="form-input"
                            value="<?= htmlspecialchars(cfg('contacto.seccion_titulo'))?>"></div>
                    <div><label class="block text-hw-text-secondary text-sm font-medium mb-2">Subtítulo</label><textarea
                            name="seccion_subtitulo"
                            class="form-input !min-h-[60px]"><?= htmlspecialchars(cfg('contacto.seccion_subtitulo'))?></textarea>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div><label class="block text-hw-text-secondary text-sm font-medium mb-2">Título
                                formulario</label><input type="text" name="form_titulo" class="form-input"
                                value="<?= htmlspecialchars(cfg('contacto.form_titulo'))?>"></div>
                        <div><label class="block text-hw-text-secondary text-sm font-medium mb-2">Subtítulo
                                formulario</label><input type="text" name="form_subtitulo" class="form-input"
                                value="<?= htmlspecialchars(cfg('contacto.form_subtitulo'))?>"></div>
                    </div>
                    <button type="submit" class="btn-primary !py-3"><i class="fas fa-save"></i> Guardar
                        Contacto</button>
                </form>
            </div>
            <!-- Footer Texts -->
            <div class="card !p-8 mb-6">
                <h2 class="font-heading font-bold text-xl text-white mb-6 flex items-center gap-3"><i
                        class="fas fa-columns text-hw-red"></i> Footer</h2>
                <form onsubmit="saveSection(event,'footer')" class="space-y-4">
                    <div><label
                            class="block text-hw-text-secondary text-sm font-medium mb-2">Descripción</label><textarea
                            name="descripcion"
                            class="form-input !min-h-[60px]"><?= htmlspecialchars(cfg('footer.descripcion'))?></textarea>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div><label class="block text-hw-text-secondary text-sm font-medium mb-2">Título Enlaces
                                Rápidos</label><input type="text" name="enlaces_rapidos_titulo" class="form-input"
                                value="<?= htmlspecialchars(cfg('footer.enlaces_rapidos_titulo'))?>"></div>
                        <div><label class="block text-hw-text-secondary text-sm font-medium mb-2">Título
                                Servicios</label><input type="text" name="servicios_titulo" class="form-input"
                                value="<?= htmlspecialchars(cfg('footer.servicios_titulo'))?>"></div>
                    </div>
                    <button type="submit" class="btn-primary !py-3"><i class="fas fa-save"></i> Guardar Footer</button>
                </form>
            </div>
            <!-- Hosting Page -->
            <div class="card !p-8">
                <h2 class="font-heading font-bold text-xl text-white mb-6 flex items-center gap-3"><i
                        class="fas fa-server text-hw-red"></i> Página de Hosting</h2>
                <form onsubmit="saveSection(event,'hosting_page')" class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div><label class="block text-hw-text-secondary text-sm font-medium mb-2">Badge</label><input
                                type="text" name="badge" class="form-input"
                                value="<?= htmlspecialchars(cfg('hosting_page.badge'))?>"></div>
                        <div><label class="block text-hw-text-secondary text-sm font-medium mb-2">Título</label><input
                                type="text" name="titulo" class="form-input"
                                value="<?= htmlspecialchars(cfg('hosting_page.titulo'))?>"></div>
                    </div>
                    <div><label class="block text-hw-text-secondary text-sm font-medium mb-2">Subtítulo</label><textarea
                            name="subtitulo"
                            class="form-input !min-h-[60px]"><?= htmlspecialchars(cfg('hosting_page.subtitulo'))?></textarea>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div><label class="block text-hw-text-secondary text-sm font-medium mb-2">Título Shared
                                Hosting</label><input type="text" name="shared_titulo" class="form-input"
                                value="<?= htmlspecialchars(cfg('hosting_page.shared_titulo'))?>"></div>
                        <div><label class="block text-hw-text-secondary text-sm font-medium mb-2">Subtítulo
                                Shared</label><input type="text" name="shared_subtitulo" class="form-input"
                                value="<?= htmlspecialchars(cfg('hosting_page.shared_subtitulo'))?>"></div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div><label class="block text-hw-text-secondary text-sm font-medium mb-2">Título
                                Cloud</label><input type="text" name="cloud_titulo" class="form-input"
                                value="<?= htmlspecialchars(cfg('hosting_page.cloud_titulo'))?>"></div>
                        <div><label class="block text-hw-text-secondary text-sm font-medium mb-2">Subtítulo
                                Cloud</label><input type="text" name="cloud_subtitulo" class="form-input"
                                value="<?= htmlspecialchars(cfg('hosting_page.cloud_subtitulo'))?>"></div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div><label class="block text-hw-text-secondary text-sm font-medium mb-2">Título
                                VPS</label><input type="text" name="vps_titulo" class="form-input"
                                value="<?= htmlspecialchars(cfg('hosting_page.vps_titulo'))?>"></div>
                        <div><label class="block text-hw-text-secondary text-sm font-medium mb-2">Subtítulo
                                VPS</label><input type="text" name="vps_subtitulo" class="form-input"
                                value="<?= htmlspecialchars(cfg('hosting_page.vps_subtitulo'))?>"></div>
                    </div>
                    <button type="submit" class="btn-primary !py-3"><i class="fas fa-save"></i> Guardar Hosting</button>
                </form>
            </div>
        </div>

        <!-- ============== TAB: Redes Sociales ============== -->
        <div id="panel-redes" class="tab-panel hidden">
            <div class="card !p-8">
                <h2 class="font-heading font-bold text-xl text-white mb-6 flex items-center gap-3"><i
                        class="fas fa-share-alt text-hw-red"></i> Redes Sociales</h2>
                <form onsubmit="saveSection(event,'redes_sociales')" class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-blue-600/10 flex items-center justify-center flex-shrink-0">
                            <i class="fab fa-facebook-f text-blue-400"></i>
                        </div><input type="url" name="facebook" class="form-input"
                            placeholder="https://facebook.com/..."
                            value="<?= htmlspecialchars(cfg('redes_sociales.facebook'))?>">
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-pink-500/10 flex items-center justify-center flex-shrink-0">
                            <i class="fab fa-instagram text-pink-400"></i>
                        </div><input type="url" name="instagram" class="form-input"
                            placeholder="https://instagram.com/..."
                            value="<?= htmlspecialchars(cfg('redes_sociales.instagram'))?>">
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-sky-500/10 flex items-center justify-center flex-shrink-0">
                            <i class="fab fa-twitter text-sky-400"></i>
                        </div><input type="url" name="twitter" class="form-input" placeholder="https://twitter.com/..."
                            value="<?= htmlspecialchars(cfg('redes_sociales.twitter'))?>">
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-blue-700/10 flex items-center justify-center flex-shrink-0">
                            <i class="fab fa-linkedin-in text-blue-500"></i>
                        </div><input type="url" name="linkedin" class="form-input"
                            placeholder="https://linkedin.com/..."
                            value="<?= htmlspecialchars(cfg('redes_sociales.linkedin'))?>">
                    </div>
                    <button type="submit" class="btn-primary !py-3"><i class="fas fa-save"></i> Guardar Redes</button>
                </form>
            </div>
        </div>

        <!-- ============== TAB: Correo ============== -->
        <div id="panel-correo" class="tab-panel hidden">
            <div class="card !p-8">
                <h2 class="font-heading font-bold text-xl text-white mb-6 flex items-center gap-3"><i
                        class="fas fa-envelope-open-text text-hw-red"></i> Configuración de Correo</h2>
                <form onsubmit="saveSection(event,'correo')" class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div><label class="block text-hw-text-secondary text-sm font-medium mb-2">Servidor
                                SMTP</label><input type="text" name="servidor" class="form-input"
                                value="<?= htmlspecialchars(cfg('correo.servidor'))?>" placeholder="smtp.ejemplo.com">
                        </div>
                        <div><label class="block text-hw-text-secondary text-sm font-medium mb-2">Puerto</label><input
                                type="text" name="puerto" class="form-input"
                                value="<?= htmlspecialchars(cfg('correo.puerto'))?>" placeholder="587"></div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div><label class="block text-hw-text-secondary text-sm font-medium mb-2">Cuenta de
                                Envío</label><input type="text" name="cuenta_envio" class="form-input"
                                value="<?= htmlspecialchars(cfg('correo.cuenta_envio'))?>"
                                placeholder="no-reply@ejemplo.com"></div>
                        <div><label class="block text-hw-text-secondary text-sm font-medium mb-2">Contraseña
                                SMTP</label><input type="password" name="password" class="form-input"
                                value="<?= htmlspecialchars(cfg('correo.password'))?>" placeholder="••••••••"></div>
                    </div>
                    <div><label class="block text-hw-text-secondary text-sm font-medium mb-2">Cuenta de Recepción
                            (Destino Contacto)</label><input type="email" name="cuenta_recepcion" class="form-input"
                            value="<?= htmlspecialchars(cfg('correo.cuenta_recepcion'))?>"
                            placeholder="info@ejemplo.com"></div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <button type="submit" class="btn-primary !py-3"><i class="fas fa-save"></i> Guardar
                            Configuración</button>
                        <button type="button" onclick="testEmailConfig()"
                            class="btn-secondary !py-3 !bg-gray-700 hover:!bg-gray-600"><i
                                class="fas fa-paper-plane"></i>
                            Probar Configuración</button>
                    </div>

                    <!-- Email Test Logs -->
                    <div id="emailTestLog"
                        class="hidden mt-4 p-4 bg-black/30 rounded-lg border border-hw-border text-xs font-mono text-green-400 h-48 overflow-y-auto whitespace-pre-wrap">
                    </div>

                </form>
            </div>
        </div>

        <!-- ============== TAB: Configurador ============== -->
        <div id="panel-configurador" class="tab-panel hidden">
            <div class="card !p-8 mb-6">
                <h2 class="font-heading font-bold text-xl text-white mb-6 flex items-center gap-3"><i
                        class="fas fa-sliders-h text-hw-red"></i> Precios Base Configurador</h2>
                <form onsubmit="saveConfiguradorBase(event)" class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div><label class="block text-hw-text-secondary text-sm font-medium mb-2">Precio vCPU
                                Core</label><input type="number" name="cpu_core" class="form-input"
                                value="<?=(int)cfg('configurador.precios_base.cpu_core')?>"></div>
                        <div><label class="block text-hw-text-secondary text-sm font-medium mb-2">Precio RAM (por
                                GB)</label><input type="number" name="ram_gb" class="form-input"
                                value="<?=(int)cfg('configurador.precios_base.ram_gb')?>"></div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div><label class="block text-hw-text-secondary text-sm font-medium mb-2">Precio Disco (por
                                GB)</label><input type="number" name="disco_gb" class="form-input"
                                value="<?=(int)cfg('configurador.precios_base.disco_gb')?>"></div>
                        <div><label class="block text-hw-text-secondary text-sm font-medium mb-2">Extra SSD NVMe (por
                                GB)</label><input type="number" name="ssd_nvme_extra" class="form-input"
                                value="<?=(int)cfg('configurador.precios_base.ssd_nvme_extra')?>"></div>
                    </div>
                    <button type="submit" class="btn-primary !py-3"><i class="fas fa-save"></i> Guardar Precios</button>
                </form>
            </div>

            <?php
$confOptions = [
    ['key' => 'sistemas_operativos', 'label' => 'Sistemas Operativos', 'icon' => 'fa-microchip'],
    ['key' => 'bases_datos', 'label' => 'Bases de Datos', 'icon' => 'fa-database'],
    ['key' => 'respaldos', 'label' => 'Planes de Respaldo', 'icon' => 'fa-history'],
    ['key' => 'soporte', 'label' => 'Niveles de Soporte', 'icon' => 'fa-headset'],
];
foreach ($confOptions as $opt):
    $items = cfg("configurador.opciones.{$opt['key']}", []);
?>
            <div class="card !p-6 mb-6">
                <h3 class="font-heading font-bold text-lg text-white mb-4 flex items-center gap-2"><i
                        class="fas <?= $opt['icon']?> text-hw-red"></i>
                    <?= $opt['label']?>
                </h3>
                <div class="space-y-3">
                    <?php foreach ($items as $idx => $it): ?>
                    <form onsubmit="saveConfiguradorOption(event, '<?= $opt['key']?>', <?= $idx?>)" class="flex gap-3">
                        <input type="text" name="nombre" class="form-input !py-2 !text-sm flex-1"
                            value="<?= htmlspecialchars($it['nombre'])?>">
                        <input type="number" name="precio" class="form-input !py-2 !text-sm w-32"
                            value="<?=(int)$it['precio']?>" placeholder="Precio extra">
                        <button type="submit" class="btn-primary !py-2 !px-4"><i class="fas fa-save"></i></button>
                    </form>
                    <?php

    endforeach; ?>
                </div>
            </div>
            <?php
endforeach; ?>
        </div>

        <!-- ============== TAB: Usuarios ============== -->
        <div id="panel-usuarios" class="tab-panel hidden">
            <div class="card !p-8 mb-6">
                <h2 class="font-heading font-bold text-xl text-white mb-6 flex items-center gap-3"><i
                        class="fas fa-user-plus text-hw-red"></i> Crear Nuevo Usuario</h2>
                <form id="createUserForm" onsubmit="createUser(event)" class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div><label class="block text-hw-text-secondary text-sm font-medium mb-2">Nombre</label><input
                                type="text" name="nombre" class="form-input" required placeholder="Nombre completo">
                        </div>
                        <div><label class="block text-hw-text-secondary text-sm font-medium mb-2">Email</label><input
                                type="email" name="email" class="form-input" required placeholder="usuario@ejemplo.com">
                        </div>
                    </div>
                    <div><label class="block text-hw-text-secondary text-sm font-medium mb-2">Contraseña
                            Inicial</label><input type="password" name="password" class="form-input" required
                            placeholder="••••••••">
                    </div>
                    <p class="text-hw-text-muted text-xs"><i class="fas fa-info-circle mr-1"></i>El usuario deberá
                        establecer su contraseña en el primer inicio de sesión. La contraseña debe tener mínimo 8
                        caracteres, mayúscula, minúscula, número y carácter especial (.@,#_).</p>
                    <button type="submit" class="btn-primary !py-3"><i class="fas fa-user-plus"></i> Crear
                        Usuario</button>

                </form>
            </div>
            <div class="card !p-8">
                <h2 class="font-heading font-bold text-xl text-white mb-6 flex items-center gap-3"><i
                        class="fas fa-users text-hw-red"></i> Usuarios Registrados</h2>
                <div id="usersList" class="space-y-3">
                    <p class="text-hw-text-muted text-sm">Cargando usuarios...</p>
                </div>
            </div>
        </div>

    </div>
</section>

<script>
    // ——— Tab switching ———
    function switchTab(id) {
        document.querySelectorAll('.tab-panel').forEach(p => p.classList.add('hidden'));
        document.querySelectorAll('.tab-btn').forEach(b => { b.classList.remove('bg-hw-red', 'text-white'); b.classList.add('text-hw-text-muted'); });
        document.getElementById('panel-' + id).classList.remove('hidden');
        const btn = document.getElementById('tab-' + id);
        btn.classList.add('bg-hw-red', 'text-white');
        btn.classList.remove('text-hw-text-muted');
    }

    // ——— Toast ———
    function showToast(msg, success = true) {
        const toast = document.getElementById('toast');
        const inner = document.getElementById('toastInner');
        const icon = document.getElementById('toastIcon');
        document.getElementById('toastMsg').textContent = msg;
        if (success) {
            inner.className = 'flex items-center gap-3 px-5 py-3 rounded-xl shadow-lg backdrop-blur-sm bg-green-500/20 border border-green-500/40 text-green-400';
            icon.className = 'fas fa-check-circle';
        } else {
            inner.className = 'flex items-center gap-3 px-5 py-3 rounded-xl shadow-lg backdrop-blur-sm bg-red-500/20 border border-red-500/40 text-red-400';
            icon.className = 'fas fa-times-circle';
        }
        toast.classList.remove('translate-x-[120%]');
        setTimeout(() => toast.classList.add('translate-x-[120%]'), 3000);
    }

    // ——— Generic section save ———
    async function saveSection(e, section) {
        e.preventDefault();
        const form = e.target;
        const btn = form.querySelector('button[type="submit"]');
        const origHTML = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';
        btn.disabled = true;

        const fd = new FormData(form);
        const values = {};
        for (const [k, v] of fd.entries()) values[k] = v;

        try {
            const res = await fetch('api/save_config.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ section, values })
            });
            const data = await res.json();
            if (data.success) {
                showToast(data.message);
                btn.innerHTML = '<i class="fas fa-check"></i> ¡Guardado!';
                btn.classList.add('!bg-green-600');
            } else {
                throw new Error(data.message);
            }
        } catch (err) {
            showToast(err.message || 'Error al guardar', false);
            btn.innerHTML = '<i class="fas fa-times"></i> Error';
            btn.classList.add('!bg-red-600');
        }
        setTimeout(() => { btn.innerHTML = origHTML; btn.className = btn.className.replace('!bg-green-600', '').replace('!bg-red-600', ''); btn.disabled = false; }, 2000);
    }

    // ——— Service items save ———
    async function saveServiciosTexts(e) {
        e.preventDefault();
        const fd = new FormData(e.target);
        const values = { seccion_badge: fd.get('seccion_badge'), seccion_titulo: fd.get('seccion_titulo'), seccion_subtitulo: fd.get('seccion_subtitulo') };
        await postSave('servicios', values, e.target);
    }

    async function saveServiceItem(e, index) {
        e.preventDefault();
        const fd = new FormData(e.target);
        // Load current items, update the item at index
        const res = await fetch('data/config.json?t=' + Date.now());
        const config = await res.json();
        const items = config.servicios?.items || [];
        items[index] = { ...items[index], titulo: fd.get('titulo'), icono: fd.get('icono'), descripcion: fd.get('descripcion') };
        await postSave('servicios', { items }, e.target);
    }

    // ——— Ventajas items save ———
    async function saveVentajasTexts(e) {
        e.preventDefault();
        const fd = new FormData(e.target);
        const values = { seccion_badge: fd.get('seccion_badge'), seccion_titulo: fd.get('seccion_titulo') };
        await postSave('ventajas', values, e.target);
    }

    async function saveVentajaItem(e, index) {
        e.preventDefault();
        const fd = new FormData(e.target);
        const res = await fetch('data/config.json?t=' + Date.now());
        const config = await res.json();
        const items = config.ventajas?.items || [];
        items[index] = { icono: fd.get('icono'), titulo: fd.get('titulo'), descripcion: fd.get('descripcion') };
        await postSave('ventajas', { items }, e.target);
    }

    // ——— Precios save ———
    async function savePreciosTexts(e) {
        e.preventDefault();
        const fd = new FormData(e.target);
        const values = { seccion_badge: fd.get('seccion_badge'), seccion_titulo: fd.get('seccion_titulo'), seccion_subtitulo: fd.get('seccion_subtitulo') };
        await postSave('precios', values, e.target);
    }

    async function savePlan(e, planKey) {
        e.preventDefault();
        const fd = new FormData(e.target);
        const caracText = fd.get('caracteristicas') || '';
        const noInclText = fd.get('no_incluye') || '';
        const planData = {
            nombre: fd.get('nombre'),
            subtitulo: fd.get('subtitulo'),
            precio: fd.get('precio'),
            almacenamiento: fd.get('almacenamiento'),
            caracteristicas: caracText.split('\n').filter(l => l.trim()),
            no_incluye: noInclText.split('\n').filter(l => l.trim())
        };
        // Read current to preserve 'destacado'
        const res = await fetch('data/config.json?t=' + Date.now());
        const config = await res.json();
        const current = config.precios?.planes?.[planKey] || {};
        planData.destacado = current.destacado ?? false;
        await postSave('precios', { planes: { [planKey]: planData } }, e.target);
    }

    // ——— Generic POST helper ———
    async function postSave(section, values, form) {
        const btn = form.querySelector('button[type="submit"]');
        const origHTML = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';
        btn.disabled = true;
        try {
            const res = await fetch('api/save_config.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ section, values })
            });
            const data = await res.json();
            if (data.success) {
                showToast(data.message);
                btn.innerHTML = '<i class="fas fa-check"></i> ¡Guardado!';
                btn.classList.add('!bg-green-600');
            } else {
                throw new Error(data.message);
            }
        } catch (err) {
            showToast(err.message || 'Error', false);
            btn.innerHTML = '<i class="fas fa-times"></i> Error';
            btn.classList.add('!bg-red-600');
        }
        setTimeout(() => { btn.innerHTML = origHTML; btn.className = btn.className.replace('!bg-green-600', '').replace('!bg-red-600', ''); btn.disabled = false; }, 2000);
    }

    // ——— Color picker sync ———
    document.querySelectorAll('input[type="color"]').forEach(picker => {
        picker.addEventListener('input', function () {
            const textInput = this.nextElementSibling;
            if (textInput) textInput.value = this.value;
        });
    });

    // ——— Hosting: section titles save ———
    async function saveHostingSectionTexts(e, key) {
        e.preventDefault();
        const fd = new FormData(e.target);
        const values = {};
        values[key + '_titulo'] = fd.get('titulo');
        values[key + '_subtitulo'] = fd.get('subtitulo');
        await postSave('hosting_page', values, e.target);
    }

    // ——— Hosting: individual plan save ———
    async function saveHostingPlan(e, key, index) {
        e.preventDefault();
        const fd = new FormData(e.target);
        const specsText = fd.get('specs') || '';
        const plan = {
            nombre: fd.get('nombre'),
            precio: fd.get('precio'),
            specs: specsText.split('\n').filter(l => l.trim())
        };
        const res = await fetch('data/config.json?t=' + Date.now());
        const config = await res.json();
        const planes = config.hosting_page?.[key + '_planes'] || [];
        planes[index] = plan;
        await postSave('hosting_page', { [key + '_planes']: planes }, e.target);
    }

    // ——— Hosting: comparativa save ———
    async function saveComparativa(e) {
        e.preventDefault();
        const fd = new FormData(e.target);
        const values = {
            comparativa_titulo: fd.get('comparativa_titulo'),
            comparativa_subtitulo: fd.get('comparativa_subtitulo')
        };
        const comparativa = [];
        let i = 0;
        while (fd.has('comp_' + i + '_carac')) {
            comparativa.push({
                caracteristica: fd.get('comp_' + i + '_carac'),
                compartido: fd.get('comp_' + i + '_compartido'),
                cloud: fd.get('comp_' + i + '_cloud'),
                vps: fd.get('comp_' + i + '_vps')
            });
            i++;
        }
        values.comparativa = comparativa;
        await postSave('hosting_page', values, e.target);
    }

    // ——— Hosting: FAQ save ———
    async function saveFaqTitulo() {
        const val = document.getElementById('faqTituloInput').value;
        const res = await fetch('api/save_config.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ section: 'hosting_page', values: { faq_titulo: val } })
        });
        const data = await res.json();
        showToast(data.success ? data.message : (data.message || 'Error'), data.success);
    }

    async function saveFaqItem(e, index) {
        e.preventDefault();
        const fd = new FormData(e.target);
        const res = await fetch('data/config.json?t=' + Date.now());
        const config = await res.json();
        const faqs = config.hosting_page?.faqs || [];
        faqs[index] = { pregunta: fd.get('pregunta'), respuesta: fd.get('respuesta') };
        await postSave('hosting_page', { faqs }, e.target);
    }

    async function deleteFaq(index) {
        if (!confirm('¿Eliminar esta pregunta?')) return;
        const res = await fetch('data/config.json?t=' + Date.now());
        const config = await res.json();
        const faqs = config.hosting_page?.faqs || [];
        faqs.splice(index, 1);
        const r = await fetch('api/save_config.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ section: 'hosting_page', values: { faqs } })
        });
        const data = await r.json();
        showToast(data.success ? 'Pregunta eliminada' : 'Error', data.success);
        if (data.success) setTimeout(() => location.reload(), 800);
    }

    function addFaq() {
        fetch('data/config.json?t=' + Date.now())
            .then(r => r.json())
            .then(config => {
                const faqs = config.hosting_page?.faqs || [];
                faqs.push({ pregunta: 'Nueva pregunta', respuesta: 'Respuesta...' });
                return fetch('api/save_config.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ section: 'hosting_page', values: { faqs } })
                });
            })
            .then(r => r.json())
            .then(data => {
                showToast(data.success ? 'Pregunta agregada' : 'Error', data.success);
                if (data.success) setTimeout(() => location.reload(), 800);
            });
    }

    // ——— Configurator save ———
    async function saveConfiguradorBase(e) {
        e.preventDefault();
        const fd = new FormData(e.target);
        const values = {
            cpu_core: Number(fd.get('cpu_core')),
            ram_gb: Number(fd.get('ram_gb')),
            disco_gb: Number(fd.get('disco_gb')),
            ssd_nvme_extra: Number(fd.get('ssd_nvme_extra'))
        };
        await postSave('configurador', { precios_base: values }, e.target);
    }

    async function saveConfiguradorOption(e, key, index) {
        e.preventDefault();
        const fd = new FormData(e.target);
        const res = await fetch('data/config.json?t=' + Date.now());
        const config = await res.json();
        const options = config.configurador?.opciones?.[key] || [];

        // Update item preserving ID if possible or generating one if needed (though usually ID is static for logic, here we edit display values)
        options[index] = {
            ...options[index],
            nombre: fd.get('nombre'),
            precio: Number(fd.get('precio'))
        };

        await postSave('configurador', { opciones: { [key]: options } }, e.target);
    }

    async function addConfiguradorOption(e, key) {
        e.preventDefault();
        const fd = new FormData(e.target);
        const res = await fetch('data/config.json?t=' + Date.now());
        const config = await res.json();
        const options = config.configurador?.opciones?.[key] || [];

        const newOption = {
            id: fd.get('id') || ('opt_' + Date.now()),
            nombre: fd.get('nombre'),
            precio: Number(fd.get('precio'))
        };

        options.push(newOption);
        await postSave('configurador', { opciones: { [key]: options } }, e.target);
        if (options.length > 0) setTimeout(() => location.reload(), 1000); // Reload to show new item
    }

    async function deleteConfiguradorOption(key, index) {
        if (!confirm('¿Eliminar esta opción?')) return;
        const res = await fetch('data/config.json?t=' + Date.now());
        const config = await res.json();
        const options = config.configurador?.opciones?.[key] || [];

        options.splice(index, 1);

        // We use a custom fetch here because postSave assumes a form button
        const body = { section: 'configurador', values: { opciones: { [key]: options } } };

        try {
            const r = await fetch('api/save_config.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(body)
            });
            const data = await r.json();
            showToast(data.success ? 'Opción eliminada' : 'Error', data.success);
            if (data.success) setTimeout(() => location.reload(), 800);
        } catch (err) {
            showToast('Error de conexión', false);
        }
    }

    // ——— User Management ———
    async function createUser(e) {
        e.preventDefault();
        const form = e.target;
        const fd = new FormData(form);
        const btn = form.querySelector('button[type="submit"]');
        const origHTML = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Creando...';
        btn.disabled = true;
        try {
            const res = await fetch('api/users.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ action: 'create', nombre: fd.get('nombre'), email: fd.get('email'), password: fd.get('password') })
            });
            const data = await res.json();
            if (data.success) {
                showToast(data.message);
                form.reset();
                loadUsers();
                btn.innerHTML = '<i class="fas fa-check"></i> ¡Creado!';
                btn.classList.add('!bg-green-600');
            } else {
                throw new Error(data.message);
            }
        } catch (err) {
            showToast(err.message || 'Error al crear usuario', false);
            btn.innerHTML = '<i class="fas fa-times"></i> Error';
            btn.classList.add('!bg-red-600');
        }
        setTimeout(() => { btn.innerHTML = origHTML; btn.className = btn.className.replace('!bg-green-600', '').replace('!bg-red-600', ''); btn.disabled = false; }, 2000);
    }

    async function deleteUser(email) {
        if (!confirm('¿Eliminar al usuario ' + email + '?')) return;
        try {
            const res = await fetch('api/users.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ action: 'delete', email })
            });
            const data = await res.json();
            showToast(data.success ? data.message : data.message, data.success);
            if (data.success) loadUsers();
        } catch (err) {
            showToast('Error de conexión', false);
        }
    }

    async function loadUsers() {
        const container = document.getElementById('usersList');
        try {
            const res = await fetch('api/users.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ action: 'list' })
            });
            const data = await res.json();
            if (!data.success) throw new Error(data.message);
            if (data.users.length === 0) {
                container.innerHTML = '<p class="text-hw-text-muted text-sm">No hay usuarios registrados.</p>';
                return;
            }
            container.innerHTML = data.users.map(u => `
                <div class="flex items-center justifborder border-hw-border/20">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-hw-red/20 flex items-center justify-center">
                            <i class="fas fa-user text-hw-red"></i>
                        </div>
                        <div>
                            <p class="text-white font-medium">${u.nombre}</p>
                            <p class="text-hw-text-muted text-sm">${u.email}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-xs px-2 py-1 rounded-full ${u.pending ? 'bg-yellow-500/10 text-yellow-400 border border-yellow-500/30' : 'bg-green-500/10 text-green-400 border border-green-500/30'}">
                            ${u.pending ? 'Pendiente' : u.rol}
                        </span>
                        <button onclick="deleteUser('${u.email}')" class="p-2 rounded-lg text-hw-text-muted hover:text-red-400 hover:bg-red-500/10 transition-all" title="Eliminar">
                            <i class="fas fa-trash text-sm"></i>
                        </button>
                    </div>
                </div>
            `).join('');
        } catch (err) {
            container.innerHTML = '<p class="text-red-400 text-sm">Error al cargar usuarios: ' + (err.message || '') + '</p>';
        }
    }

    async function handleForcedPasswordChange(e) {
        e.preventDefault();
        const fd = new FormData(e.target);
        const p1 = fd.get('n_password');
        const p2 = fd.get('c_password');

        if (p1 !== p2) {
            showToast('Las contraseñas no coinciden', false);
            return;
        }

        const btn = e.target.querySelector('button[type="submit"]');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Actualizando...';

        try {
            const res = await fetch('api/users.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ action: 'change_password', password: p1 })
            });
            const data = await res.json();
            if (data.success) {
                showToast('Contraseña actualizada correctamente');
                setTimeout(() => location.reload(), 1000);
            } else {
                throw new Error(data.message);
            }
        } catch (err) {
            showToast(err.message || 'Error al cambiar contraseña', false);
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-shield-alt"></i> Actualizar y Continuar';
        }
    }

    // Load users when switching to the tab
    const origSwitchTab = switchTab;
    switchTab = function (id) {
        origSwitchTab(id);
        if (id === 'usuarios') loadUsers();
    };
</script>

<?php include 'includes/footer.php'; ?>