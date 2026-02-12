<!-- Footer -->
<footer class="relative bg-hw-surface border-t border-hw-border/40 pt-16 pb-8">
    <!-- Top gradient line -->
    <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-hw-red/40 to-transparent">
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">

            <!-- Brand Column -->
            <div class="lg:col-span-1">
                <a href="index.php" class="flex items-center gap-3 no-underline mb-5">
                    <div
                        class="w-10 h-10 rounded-lg bg-gradient-to-br from-hw-red to-hw-red-hover flex items-center justify-center">
                        <i
                            class="fas <?= htmlspecialchars(cfg('sitio.logo_icono', 'fa-server'))?> text-white text-lg"></i>
                    </div>
                    <div>
                        <span class="text-white font-heading font-bold text-xl">
                            <?= htmlspecialchars(cfg('sitio.nombre_corto', 'HUAWEI'))?>
                        </span>
                        <span class="text-hw-red font-heading font-bold text-xl ml-1">
                            <?= htmlspecialchars(cfg('sitio.nombre_marca', 'HOSTING'))?>
                        </span>
                    </div>
                </a>
                <p class="text-hw-text-muted text-sm leading-relaxed mb-5">
                    <?= htmlspecialchars(cfg('footer.descripcion', 'Soluciones de alojamiento web de alto rendimiento respaldadas por la tecnología de Huawei Cloud.'))?>
                </p>
                <div class="flex gap-3">
                    <a href="<?= htmlspecialchars(cfg('redes_sociales.facebook', '#'))?>" target="_blank" rel="noopener"
                        class="w-10 h-10 rounded-lg bg-hw-dark border border-hw-border/40 flex items-center justify-center text-hw-text-muted hover:text-hw-red hover:border-hw-red/40 transition-all duration-300 no-underline"
                        aria-label="Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="<?= htmlspecialchars(cfg('redes_sociales.instagram', '#'))?>" target="_blank"
                        rel="noopener"
                        class="w-10 h-10 rounded-lg bg-hw-dark border border-hw-border/40 flex items-center justify-center text-hw-text-muted hover:text-hw-red hover:border-hw-red/40 transition-all duration-300 no-underline"
                        aria-label="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="<?= htmlspecialchars(cfg('redes_sociales.twitter', '#'))?>" target="_blank" rel="noopener"
                        class="w-10 h-10 rounded-lg bg-hw-dark border border-hw-border/40 flex items-center justify-center text-hw-text-muted hover:text-hw-red hover:border-hw-red/40 transition-all duration-300 no-underline"
                        aria-label="Twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="<?= htmlspecialchars(cfg('redes_sociales.linkedin', '#'))?>" target="_blank" rel="noopener"
                        class="w-10 h-10 rounded-lg bg-hw-dark border border-hw-border/40 flex items-center justify-center text-hw-text-muted hover:text-hw-red hover:border-hw-red/40 transition-all duration-300 no-underline"
                        aria-label="LinkedIn">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h4 class="text-white font-heading font-bold text-sm uppercase tracking-wider mb-5">
                    <?= htmlspecialchars(cfg('footer.enlaces_rapidos_titulo', 'Enlaces Rápidos'))?>
                </h4>
                <ul class="space-y-3 list-none">
                    <li><a href="index.php"
                            class="text-hw-text-muted hover:text-hw-red transition-colors text-sm no-underline flex items-center gap-2"><i
                                class="fas fa-chevron-right text-[10px] text-hw-red/50"></i> Inicio</a></li>
                    <li><a href="hosting.php"
                            class="text-hw-text-muted hover:text-hw-red transition-colors text-sm no-underline flex items-center gap-2"><i
                                class="fas fa-chevron-right text-[10px] text-hw-red/50"></i> Planes de Hosting</a></li>
                    <li><a href="contacto.php"
                            class="text-hw-text-muted hover:text-hw-red transition-colors text-sm no-underline flex items-center gap-2"><i
                                class="fas fa-chevron-right text-[10px] text-hw-red/50"></i> Contacto</a></li>
                </ul>
            </div>

            <!-- Services -->
            <div>
                <h4 class="text-white font-heading font-bold text-sm uppercase tracking-wider mb-5">
                    <?= htmlspecialchars(cfg('footer.servicios_titulo', 'Servicios'))?>
                </h4>
                <ul class="space-y-3 list-none">
                    <?php $svcItems = cfg('servicios.items', []);
foreach ($svcItems as $svc): ?>
                    <li><a href="hosting.php"
                            class="text-hw-text-muted hover:text-hw-red transition-colors text-sm no-underline flex items-center gap-2"><i
                                class="fas fa-chevron-right text-[10px] text-hw-red/50"></i>
                            <?= htmlspecialchars($svc['titulo'])?>
                        </a></li>
                    <?php
endforeach; ?>
                </ul>
            </div>

            <!-- Contact Info -->
            <div>
                <h4 class="text-white font-heading font-bold text-sm uppercase tracking-wider mb-5">
                    <?= htmlspecialchars(cfg('footer.contacto_titulo', 'Contacto'))?>
                </h4>
                <ul class="space-y-4 list-none">
                    <li class="flex items-start gap-3">
                        <i class="fas fa-map-marker-alt text-hw-red mt-1 w-4 text-center"></i>
                        <span class="text-hw-text-muted text-sm">
                            <?= htmlspecialchars(cfg('empresa.direccion', 'Av. Tecnología 1234, Ciudad Empresarial'))?>
                        </span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class="fas fa-phone text-hw-red mt-1 w-4 text-center"></i>
                        <span class="text-hw-text-muted text-sm">
                            <?= htmlspecialchars(cfg('empresa.telefono', '+1 (800) 123-4567'))?>
                        </span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class="fas fa-envelope text-hw-red mt-1 w-4 text-center"></i>
                        <span class="text-hw-text-muted text-sm">
                            <?= htmlspecialchars(cfg('empresa.email', 'info@huaweihosting.com'))?>
                        </span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class="fas fa-clock text-hw-red mt-1 w-4 text-center"></i>
                        <span class="text-hw-text-muted text-sm">
                            <?= htmlspecialchars(cfg('empresa.horario', 'Lun - Vie: 9:00 - 18:00'))?>
                        </span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Bottom bar -->
        <div class="border-t border-hw-border/30 pt-8 flex flex-col md:flex-row items-center justify-between gap-4">
            <p class="text-hw-text-muted text-sm">&copy;
                <?php echo date('Y'); ?>
                <?= htmlspecialchars(cfg('empresa.nombre', 'Huawei Hosting'))?>. Todos los derechos reservados.
            </p>
            <div class="flex gap-6">
                <a href="#" class="text-hw-text-muted hover:text-hw-red transition-colors text-sm no-underline">
                    <?= htmlspecialchars(cfg('footer.privacidad_texto', 'Política de Privacidad'))?>
                </a>
                <a href="#" class="text-hw-text-muted hover:text-hw-red transition-colors text-sm no-underline">
                    <?= htmlspecialchars(cfg('footer.terminos_texto', 'Términos de Servicio'))?>
                </a>
            </div>
        </div>
    </div>
</footer>

</body>

</html>