<?php
$pageTitle = 'Contacto';
$pageDescription = 'Contáctanos para obtener más información sobre nuestros planes de hosting. Solicita una asesoría personalizada.';
include 'includes/header.php';
?>

<?php
$selectedPlan = $_GET['plan'] ?? '';
?>

<!-- Page Header -->
<section class="relative py-20 overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-b from-hw-surface/50 to-hw-dark"></div>
    <div class="absolute top-0 left-0 w-96 h-96 bg-hw-red/5 rounded-full blur-3xl"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="text-hw-red font-semibold text-sm uppercase tracking-widest">
            <?= htmlspecialchars(cfg('contacto.seccion_badge', 'Contáctanos'))?>
        </span>
        <h1 class="font-heading font-bold text-4xl sm:text-5xl lg:text-6xl text-white mt-3 mb-5">
            <?= htmlspecialchars(cfg('contacto.seccion_titulo', 'Estamos aquí para ayudarte'))?>
        </h1>
        <p class="text-hw-text-secondary text-lg max-w-2xl mx-auto">
            <?= htmlspecialchars(cfg('contacto.seccion_subtitulo', '¿Tienes preguntas? Nuestro equipo de expertos está listo para asesorarte.'))?>
        </p>
    </div>
</section>

<!-- Contact Content -->
<section class="py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

            <!-- Contact Form -->
            <div class="lg:col-span-2 reveal">
                <div class="card !p-8 sm:!p-10">
                    <h2 class="font-heading font-bold text-2xl text-white mb-2">
                        <?= htmlspecialchars(cfg('contacto.form_titulo', 'Envíanos un mensaje'))?>
                    </h2>
                    <p class="text-hw-text-muted text-sm mb-8">
                        <?= htmlspecialchars(cfg('contacto.form_subtitulo', 'Completa el formulario y te responderemos en menos de 24 horas.'))?>
                    </p>
                    <form id="contactForm" onsubmit="handleSubmit(event)">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
                            <div>
                                <label class="block text-hw-text-secondary text-sm font-medium mb-2">Nombre completo
                                    *</label>
                                <input type="text" name="nombre" class="form-input" placeholder="Tu nombre" required>
                            </div>
                            <div>
                                <label class="block text-hw-text-secondary text-sm font-medium mb-2">Email *</label>
                                <input type="email" name="email" class="form-input" placeholder="tu@email.com" required>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
                            <div>
                                <label class="block text-hw-text-secondary text-sm font-medium mb-2">Teléfono</label>
                                <input type="tel" name="telefono" class="form-input" placeholder="+1 (800) 123-4567">
                            </div>
                            <div>
                                <label class="block text-hw-text-secondary text-sm font-medium mb-2">Servicio de interés
                                    *</label>
                                <select name="servicio" class="form-input" required>
                                    <option value="">Selecciona un servicio</option>
                                    <option value="hosting-web" <?= (stripos($selectedPlan, 'Web') !== false || stripos($selectedPlan, 'Compartido') !== false) ? 'selected' : '' ?>>Hosting Web</option>
                                    <option value="hosting-cloud" <?= (stripos($selectedPlan, 'Cloud') !== false) ? 'selected' : '' ?>>Hosting Cloud</option>
                                    <option value="vps" <?= (stripos($selectedPlan, 'VPS') !== false) ? 'selected' : '' ?>>Servidor VPS</option>
                                    <option value="dominio" <?= (stripos($selectedPlan, 'Dominio') !== false) ? 'selected' : '' ?>>Registro de Dominio</option>
                                    <option value="migracion" <?= (stripos($selectedPlan, 'Migración') !== false) ? 'selected' : '' ?>>Migración de Sitio</option>
                                    <option value="otro" <?= ($selectedPlan && !in_array($selectedPlan, ['Web', 'Cloud', 'VPS'])) ? 'selected' : '' ?>>Otro: <?= htmlspecialchars($selectedPlan) ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-6">
                            <label class="block text-hw-text-secondary text-sm font-medium mb-2">Mensaje *</label>
                            <textarea name="mensaje" class="form-input"
                                placeholder="Cuéntanos sobre tu proyecto y necesidades..." required></textarea>
                        </div>
                        <button type="submit" class="btn-primary w-full sm:w-auto justify-center"><i
                                class="fas fa-paper-plane"></i> Enviar Mensaje</button>
                    </form>
                    <div id="formSuccess"
                        class="hidden mt-6 p-4 rounded-xl bg-green-500/10 border border-green-500/30 text-green-400 text-sm">
                        <i class="fas fa-check-circle mr-2"></i>¡Mensaje enviado con éxito! Te contactaremos pronto.
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6 reveal" style="transition-delay:0.2s">
                <!-- Contact Info -->
                <div class="card">
                    <h3 class="font-heading font-bold text-lg text-white mb-5">Información de Contacto</h3>
                    <div class="space-y-5">
                        <div class="flex items-start gap-4">
                            <div
                                class="w-10 h-10 rounded-lg bg-hw-red/10 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-map-marker-alt text-hw-red"></i>
                            </div>
                            <div>
                                <p class="text-white text-sm font-medium">Dirección</p>
                                <p class="text-hw-text-muted text-sm">
                                    <?= htmlspecialchars(cfg('empresa.direccion', 'Av. Tecnología 1234, Ciudad Empresarial, CP 10001'))?>
                                </p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div
                                class="w-10 h-10 rounded-lg bg-hw-red/10 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-phone text-hw-red"></i>
                            </div>
                            <div>
                                <p class="text-white text-sm font-medium">Teléfono</p>
                                <p class="text-hw-text-muted text-sm">
                                    <?= htmlspecialchars(cfg('empresa.telefono', '+1 (800) 123-4567'))?>
                                </p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div
                                class="w-10 h-10 rounded-lg bg-hw-red/10 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-envelope text-hw-red"></i>
                            </div>
                            <div>
                                <p class="text-white text-sm font-medium">Email</p>
                                <p class="text-hw-text-muted text-sm">
                                    <?= htmlspecialchars(cfg('empresa.email', 'info@huaweihosting.com'))?>
                                </p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div
                                class="w-10 h-10 rounded-lg bg-hw-red/10 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-clock text-hw-red"></i>
                            </div>
                            <div>
                                <p class="text-white text-sm font-medium">Horario</p>
                                <p class="text-hw-text-muted text-sm">
                                    <?= htmlspecialchars(cfg('empresa.horario', 'Lun - Vie: 9:00 - 18:00'))?><br>
                                    <?= htmlspecialchars(cfg('empresa.horario_extra', 'Sáb: 9:00 - 13:00'))?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Social -->
                <div class="card">
                    <h3 class="font-heading font-bold text-lg text-white mb-4">Síguenos</h3>
                    <div class="flex gap-3">
                        <a href="<?= htmlspecialchars(cfg('redes_sociales.facebook', '#'))?>" target="_blank"
                            rel="noopener"
                            class="w-11 h-11 rounded-lg bg-hw-dark border border-hw-border/40 flex items-center justify-center text-hw-text-muted hover:text-hw-red hover:border-hw-red/40 transition-all no-underline"><i
                                class="fab fa-facebook-f"></i></a>
                        <a href="<?= htmlspecialchars(cfg('redes_sociales.instagram', '#'))?>" target="_blank"
                            rel="noopener"
                            class="w-11 h-11 rounded-lg bg-hw-dark border border-hw-border/40 flex items-center justify-center text-hw-text-muted hover:text-hw-red hover:border-hw-red/40 transition-all no-underline"><i
                                class="fab fa-instagram"></i></a>
                        <a href="<?= htmlspecialchars(cfg('redes_sociales.twitter', '#'))?>" target="_blank"
                            rel="noopener"
                            class="w-11 h-11 rounded-lg bg-hw-dark border border-hw-border/40 flex items-center justify-center text-hw-text-muted hover:text-hw-red hover:border-hw-red/40 transition-all no-underline"><i
                                class="fab fa-twitter"></i></a>
                        <a href="<?= htmlspecialchars(cfg('redes_sociales.linkedin', '#'))?>" target="_blank"
                            rel="noopener"
                            class="w-11 h-11 rounded-lg bg-hw-dark border border-hw-border/40 flex items-center justify-center text-hw-text-muted hover:text-hw-red hover:border-hw-red/40 transition-all no-underline"><i
                                class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>

                <!-- Quick CTA -->
                <div class="card !bg-gradient-to-br !from-hw-red/10 !to-hw-surface !border-hw-red/30">
                    <div class="text-center">
                        <i class="fas fa-headset text-hw-red text-3xl mb-3"></i>
                        <h3 class="font-heading font-bold text-lg text-white mb-2">¿Necesitas ayuda urgente?</h3>
                        <p class="text-hw-text-muted text-sm mb-4">Nuestro soporte técnico está disponible 24/7</p>
                        <a href="<?= htmlspecialchars(cfg('empresa.whatsapp', 'tel:+18001234567'))?>" target="_blank"
                            class="btn-primary w-full justify-center text-sm no-underline"><i class="fas fa-phone"></i>
                            Llamar Ahora</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    async function handleSubmit(e) {
        e.preventDefault();
        const form = e.target;
        const btn = form.querySelector('button[type="submit"]');
        const origHTML = btn.innerHTML;

        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Enviando...';
        btn.disabled = true;

        try {
            const fd = new FormData(form);
            const res = await fetch('api/send_mail.php', {
                method: 'POST',
                body: fd
            });
            const data = await res.json();

            if (data.success) {
                form.style.display = 'none';
                document.getElementById('formSuccess').classList.remove('hidden');
            } else {
                throw new Error(data.message || 'Error al enviar mensaje');
            }
        } catch (err) {
            alert(err.message);
            btn.innerHTML = origHTML;
            btn.disabled = false;
        }
    }
</script>

<?php include 'includes/footer.php'; ?>