<?php
$pageTitle = 'Configurador de Servidor';
$pageDescription = 'Configura tu servidor Cloud o VPS a medida. Elige CPU, RAM, almacenamiento y servicios adicionales con Huawei Cloud.';
include 'includes/header.php';

$configurador = cfg('configurador', []);
$preciosBase = $configurador['precios_base'] ?? [];
$opciones = $configurador['opciones'] ?? [];
?>

<!-- Page Header -->
<section class="relative py-20 overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-b from-hw-surface/50 to-hw-dark"></div>
    <div class="absolute top-0 left-0 w-96 h-96 bg-hw-red/5 rounded-full blur-3xl"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="text-hw-red font-semibold text-sm uppercase tracking-widest">Configuración a medida</span>
        <h1 class="font-heading font-bold text-4xl sm:text-5xl lg:text-6xl text-white mt-3 mb-5">Configura tu Servidor
        </h1>
        <p class="text-hw-text-secondary text-lg max-w-2xl mx-auto">Selecciona los recursos exactos que tu proyecto
            necesita. Sin límites, sin excedentes.</p>
    </div>
</section>

<!-- Configurator Content -->
<section class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

            <!-- Left: Configuration Sliders -->
            <div class="lg:col-span-2 space-y-8">

                <!-- CPU, RAM, Storage -->
                <div class="card !p-8">
                    <h2 class="font-heading font-bold text-2xl text-white mb-8 flex items-center gap-3">
                        <i class="fas fa-microchip text-hw-red"></i> Recursos Principales
                    </h2>

                    <div class="space-y-12">
                        <!-- CPU Slider -->
                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <label class="text-white font-medium">Procesador (vCPU)</label>
                                <span class="text-hw-red font-heading font-bold text-xl" id="display-cpu">2 Cores</span>
                            </div>
                            <input type="range" min="1" max="128" value="2" step="1" class="hw-slider w-full"
                                id="slider-cpu" oninput="updatePrice()">
                            <div class="flex justify-between text-xs text-hw-text-muted">
                                <span>1 Core</span>
                                <span>128 Cores</span>
                            </div>
                        </div>

                        <!-- RAM Slider -->
                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <label class="text-white font-medium">Memoria RAM</label>
                                <span class="text-hw-red font-heading font-bold text-xl" id="display-ram">4 GB</span>
                            </div>
                            <input type="range" min="1" max="512" value="4" step="1" class="hw-slider w-full"
                                id="slider-ram" oninput="updatePrice()">
                            <div class="flex justify-between text-xs text-hw-text-muted">
                                <span>1 GB</span>
                                <span>512 GB</span>
                            </div>
                        </div>

                        <!-- Storage Slider -->
                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <label class="text-white font-medium">Almacenamiento (SSD NVMe)</label>
                                <span class="text-hw-red font-heading font-bold text-xl" id="display-disco">40 GB</span>
                            </div>
                            <input type="range" min="20" max="2000" value="40" step="10" class="hw-slider w-full"
                                id="slider-disco" oninput="updatePrice()">
                            <div class="flex justify-between text-xs text-hw-text-muted">
                                <span>20 GB</span>
                                <span>2 TB</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Software & Services -->
                <div class="card !p-8">
                    <h2 class="font-heading font-bold text-2xl text-white mb-6 flex items-center gap-3">
                        <i class="fas fa-layer-group text-hw-red"></i> Software y Servicios
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- OS -->
                        <div>
                            <label class="block text-hw-text-secondary text-sm font-medium mb-2">Sistema
                                Operativo</label>
                            <select id="select-os" class="form-input" onchange="updatePrice()">
                                <?php foreach ($opciones['sistemas_operativos'] as $os): ?>
                                <option value="<?= $os['id']?>" data-price="<?= $os['precio']?>">
                                    <?= $os['nombre']?> (+$
                                    <?= number_format($os['precio'], 0)?>)
                                </option>
                                <?php
endforeach; ?>
                            </select>
                        </div>

                        <!-- DB -->
                        <div>
                            <label class="block text-hw-text-secondary text-sm font-medium mb-2">Base de Datos</label>
                            <select id="select-db" class="form-input" onchange="updatePrice()">
                                <?php foreach ($opciones['bases_datos'] as $db): ?>
                                <option value="<?= $db['id']?>" data-price="<?= $db['precio']?>">
                                    <?= $db['nombre']?> (+$
                                    <?= number_format($db['precio'], 0)?>)
                                </option>
                                <?php
endforeach; ?>
                            </select>
                        </div>

                        <!-- Backups -->
                        <div>
                            <label class="block text-hw-text-secondary text-sm font-medium mb-2">Plan de
                                Respaldo</label>
                            <select id="select-backup" class="form-input" onchange="updatePrice()">
                                <?php foreach ($opciones['respaldos'] as $bk): ?>
                                <option value="<?= $bk['id']?>" data-price="<?= $bk['precio']?>">
                                    <?= $bk['nombre']?> (+$
                                    <?= number_format($bk['precio'], 0)?>/mes)
                                </option>
                                <?php
endforeach; ?>
                            </select>
                        </div>

                        <!-- Support -->
                        <div>
                            <label class="block text-hw-text-secondary text-sm font-medium mb-2">Nivel de
                                Soporte</label>
                            <select id="select-support" class="form-input" onchange="updatePrice()">
                                <?php foreach ($opciones['soporte'] as $sp): ?>
                                <option value="<?= $sp['id']?>" data-price="<?= $sp['precio']?>">
                                    <?= $sp['nombre']?> (+$
                                    <?= number_format($sp['precio'], 0)?>/mes)
                                </option>
                                <?php
endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Summary & Price -->
            <div class="lg:col-span-1">
                <div class="sticky top-24">
                    <div class="card !p-8 !bg-gradient-to-br !from-hw-surface !to-hw-dark border-hw-red/30">
                        <h3 class="font-heading font-bold text-xl text-white mb-6">Resumen y Cotización</h3>

                        <div class="space-y-4 mb-8">
                            <div class="flex justify-between text-sm">
                                <span class="text-hw-text-muted">Configuración vCPU/RAM</span>
                                <span class="text-white" id="summary-resources">2 Core / 4 GB</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-hw-text-muted">Almacenamiento NVMe</span>
                                <span class="text-white" id="summary-storage">40 GB</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-hw-text-muted">Software Seleccionado</span>
                                <span class="text-white" id="summary-software">Ubuntu / MySQL</span>
                            </div>
                            <div class="flex justify-between text-sm border-t border-hw-border/20 pt-4">
                                <span class="text-hw-text-muted">Soporte y Respaldos</span>
                                <span class="text-white" id="summary-extra">Básico / Sin Respaldo</span>
                            </div>
                        </div>

                        <div class="text-center p-6 bg-hw-red/10 rounded-2xl mb-8">
                            <p class="text-hw-text-muted text-xs uppercase tracking-widest mb-1">Inversión Mensual Est.
                                (CLP)</p>
                            <p class="font-heading font-black text-4xl text-white" id="total-price">$0</p>
                        </div>

                        <button onclick="openRequestModal()" class="btn-primary w-full justify-center !py-4">
                            <i class="fas fa-paper-plane"></i> Solicitar este Servidor
                        </button>
                        <p class="text-hw-text-muted text-[10px] text-center mt-4 italic">Precios sujetos a variaciones
                            según tasa de cambio y promociones vigentes.</p>
                    </div>

                    <div class="mt-6 p-6 rounded-2xl border border-hw-border/20 bg-hw-dark/40">
                        <div class="flex gap-4 items-center">
                            <div
                                class="w-12 h-12 rounded-xl bg-hw-red/10 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-shield-alt text-hw-red text-xl"></i>
                            </div>
                            <div>
                                <h4 class="text-white font-bold text-sm">SLA del 99.9%</h4>
                                <p class="text-hw-text-muted text-xs">Garantizado por infraestructura Huawei Cloud de
                                    clase mundial.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Request Modal -->
<div id="requestModal"
    class="hidden fixed inset-0 z-[100] bg-hw-dark/95 backdrop-blur-xl flex items-center justify-center p-4">
    <div class="card !p-8 max-w-xl w-full translate-y-0 opacity-100 transition-all">
        <div class="flex justify-between items-center mb-6">
            <h3 class="font-heading font-bold text-2xl text-white">Solicitar Cotización</h3>
            <button onclick="closeRequestModal()" class="text-hw-text-muted hover:text-white transition-colors">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <form onsubmit="handleConfiguratorSubmit(event)" class="space-y-4">
            <input type="hidden" name="config_resumen" id="input-config-resumen">
            <input type="hidden" name="config_precio" id="input-config-precio">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-hw-text-secondary text-sm font-medium mb-1">Nombre</label>
                    <input type="text" name="nombre" class="form-input" required>
                </div>
                <div>
                    <label class="block text-hw-text-secondary text-sm font-medium mb-1">Email</label>
                    <input type="email" name="email" class="form-input" required>
                </div>
            </div>
            <div>
                <label class="block text-hw-text-secondary text-sm font-medium mb-1">Empresa</label>
                <input type="text" name="empresa" class="form-input">
            </div>
            <div>
                <label class="block text-hw-text-secondary text-sm font-medium mb-1">Mensaje Adicional</label>
                <textarea name="mensaje" class="form-input !h-24"
                    placeholder="Algún requerimiento especial..."></textarea>
            </div>

            <div
                class="bg-hw-surface-light/50 p-4 rounded-xl border border-hw-border/20 text-xs text-hw-text-secondary mb-4">
                <p class="font-bold mb-1">Configuración solicitada:</p>
                <p id="modal-summary-text"></p>
            </div>

            <button type="submit" class="btn-primary w-full justify-center !py-4">
                <i class="fas fa-check-circle"></i> Enviar Solicitud de Cotización
            </button>
        </form>
    </div>
</div>

<script>
    const PRECIOS_BASE = <?= json_encode($preciosBase)?>;

    function updatePrice() {
        const cpu = parseInt(document.getElementById('slider-cpu').value);
        const ram = parseInt(document.getElementById('slider-ram').value);
        const disco = parseInt(document.getElementById('slider-disco').value);

        const osSelect = document.getElementById('select-os');
        const osPrice = parseInt(osSelect.options[osSelect.selectedIndex].getAttribute('data-price') || 0);
        const osName = osSelect.options[osSelect.selectedIndex].text.split('(')[0].trim();

        const dbSelect = document.getElementById('select-db');
        const dbPrice = parseInt(dbSelect.options[dbSelect.selectedIndex].getAttribute('data-price') || 0);
        const dbName = dbSelect.options[dbSelect.selectedIndex].text.split('(')[0].trim();

        const bkSelect = document.getElementById('select-backup');
        const bkPrice = parseInt(bkSelect.options[bkSelect.selectedIndex].getAttribute('data-price') || 0);
        const bkName = bkSelect.options[bkSelect.selectedIndex].text.split('(')[0].trim();

        const spSelect = document.getElementById('select-support');
        const spPrice = parseInt(spSelect.options[spSelect.selectedIndex].getAttribute('data-price') || 0);
        const spName = spSelect.options[spSelect.selectedIndex].text.split('(')[0].trim();

        // Calculate
        const priceCpu = cpu * (PRECIOS_BASE.cpu_core || 0);
        const priceRam = ram * (PRECIOS_BASE.ram_gb || 0);
        const priceDisco = disco * (PRECIOS_BASE.disco_gb || 0);

        const total = priceCpu + priceRam + priceDisco + osPrice + dbPrice + bkPrice + spPrice;

        // Update UI
        document.getElementById('display-cpu').innerText = `${cpu} Core${cpu > 1 ? 's' : ''}`;
        document.getElementById('display-ram').innerText = `${ram} GB`;
        document.getElementById('display-disco').innerText = `${disco} GB`;

        document.getElementById('total-price').innerText = '$' + total.toLocaleString('es-CL');

        document.getElementById('summary-resources').innerText = `${cpu} Core / ${ram} GB`;
        document.getElementById('summary-storage').innerText = `${disco} GB`;
        document.getElementById('summary-software').innerText = `${osName} / ${dbName}`;
        document.getElementById('summary-extra').innerText = `${spName} / ${bkName}`;

        // Prepare hidden inputs
        const summaryStr = `${cpu} vCPU, ${ram}GB RAM, ${disco}GB SSD | OS: ${osName} | DB: ${dbName} | Support: ${spName} | Backup: ${bkName}`;
        document.getElementById('input-config-resumen').value = summaryStr;
        document.getElementById('input-config-precio').value = total;
        document.getElementById('modal-summary-text').innerText = summaryStr + ` (Est. $${total.toLocaleString('es-CL')})`;
    }

    function openRequestModal() {
        document.getElementById('requestModal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeRequestModal() {
        document.getElementById('requestModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    async function handleConfiguratorSubmit(e) {
        e.preventDefault();
        const form = e.target;
        const btn = form.querySelector('button[type="submit"]');
        const origHTML = btn.innerHTML;

        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Enviando...';
        btn.disabled = true;

        try {
            const fd = new FormData(form);
            // We reuse send_mail.php
            // We add the config info to the "mensaje" field for the email
            const fullMessage = `SERVICIO: CONFIGURADOR PERSONALIZADO\n` +
                `CONFIGURACIÓN: ${fd.get('config_resumen')}\n` +
                `PRECIO EST: $${parseInt(fd.get('config_precio')).toLocaleString('es-CL')}\n` +
                `EMPRESA: ${fd.get('empresa')}\n\n` +
                `MENSAJE: ${fd.get('mensaje')}`;

            const mailData = new FormData();
            mailData.append('nombre', fd.get('nombre'));
            mailData.append('email', fd.get('email'));
            mailData.append('servicio', 'Configurador Personalizado');
            mailData.append('mensaje', fullMessage);

            const res = await fetch('api/send_mail.php', {
                method: 'POST',
                body: mailData
            });
            const data = await res.json();

            if (data.success) {
                form.innerHTML = `
                <div class="text-center py-10">
                    <div class="w-20 h-20 rounded-full bg-green-500/20 text-green-400 flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-check text-4xl"></i>
                    </div>
                    <h3 class="font-heading font-bold text-2xl text-white mb-2">¡Solicitud Enviada!</h3>
                    <p class="text-hw-text-secondary mb-8">Hemos recibido tu configuración. Un asesor experto se contactará contigo para validar los detalles y formalizar la cotización.</p>
                    <button onclick="closeRequestModal()" class="btn-secondary">Cerrar</button>
                </div>
            `;
            } else {
                throw new Error(data.message);
            }
        } catch (err) {
            alert('Error: ' + err.message);
            btn.innerHTML = origHTML;
            btn.disabled = false;
        }
    }

    // Initial update
    updatePrice();
</script>

<style>
    .hw-slider {
        -webkit-appearance: none;
        height: 6px;
        background: var(--hw-surface-light);
        border-radius: 5px;
        outline: none;
        opacity: 0.9;
        transition: opacity .2s;
    }

    .hw-slider:hover {
        opacity: 1;
    }

    .hw-slider::-webkit-slider-thumb {
        -webkit-appearance: none;
        appearance: none;
        width: 24px;
        height: 24px;
        background: var(--hw-red);
        cursor: pointer;
        border-radius: 50%;
        border: 4px solid var(--hw-surface);
        box-shadow: 0 0 15px rgba(199, 0, 11, 0.4);
    }
</style>

<?php include 'includes/footer.php'; ?>