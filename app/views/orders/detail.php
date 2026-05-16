<?php /** @var array $data */ ?>
<?php /** @var array $order */ ?>
<div class="min-h-screen pb-20" style="background-color: #FDF9F8;">
    <!-- Page Header -->
    <section class="py-16 px-6 text-center border-b" style="background-color: #FFF5F0; border-color: #FDECE8;">
        <div class="max-w-4xl mx-auto">
            <span class="font-script text-coral text-3xl block mb-2">Detalles del Pedido</span>
            <h1 class="text-4xl md:text-5xl font-serif text-charcoal mb-4">#<?php echo e($order['numero_orden']); ?></h1>
            <div class="flex justify-center items-center gap-3">
                <span class="text-[10px] font-bold uppercase tracking-widest text-charcoal-light">Realizado el <?php echo date('d M, Y', strtotime($order['created_at'])); ?></span>
                <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                <a href="<?php echo e(app_url('orders')); ?>" class="text-[10px] font-bold uppercase tracking-widest text-coral hover:underline">Volver al historial</a>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-6 py-14">
        
        <!-- Order Progress Timeline -->
        <div class="bg-white rounded-2xl shadow-sm border p-6 md:p-10 mb-10" style="border-color: #F2E8E6;">
            <?php
                $steps = [
                    ['id' => 'pendiente', 'label' => 'Recibido', 'icon' => 'file-text'],
                    ['id' => 'confirmada', 'label' => 'Confirmado', 'icon' => 'check-circle'],
                    ['id' => 'preparando', 'label' => 'Preparando', 'icon' => 'flower-2'],
                    ['id' => 'listo_envio', 'label' => 'Listo', 'icon' => 'package'],
                    ['id' => 'enviada', 'label' => 'En Camino', 'icon' => 'truck'],
                    ['id' => 'entregada', 'label' => 'Entregado', 'icon' => 'home']
                ];
                $currentStatus = $order['estado_orden'];
                $currentIndex = 0;
                foreach($steps as $i => $s) if($s['id'] === $currentStatus) $currentIndex = $i;
                $progressPercent = ($currentIndex / (count($steps) - 1)) * 100;
            ?>
            <div class="relative flex flex-col md:flex-row justify-between gap-6 md:gap-0">
                <!-- Desktop Line Connector -->
                <div class="absolute top-[23px] left-[8%] right-[8%] h-[2px] bg-gray-100 hidden md:block z-0">
                    <div class="h-full bg-coral transition-all duration-1000" style="width: <?php echo $progressPercent; ?>%"></div>
                </div>

                <!-- Mobile Line Connector -->
                <div class="absolute left-[23px] top-[24px] bottom-[24px] w-[2px] bg-gray-100 md:hidden z-0">
                    <div class="w-full bg-coral transition-all duration-1000" style="height: <?php echo $progressPercent; ?>%"></div>
                </div>

                <?php foreach ($steps as $index => $step): ?>
                    <div class="flex md:flex-col items-center md:items-center relative z-10 flex-1 group gap-5 md:gap-0">
                        <!-- Icon Circle -->
                        <div class="w-12 h-12 rounded-full flex items-center justify-center transition-all duration-500 <?php echo ($index <= $currentIndex) ? 'bg-coral text-white shadow-lg scale-110' : 'bg-gray-50 text-gray-300 border border-gray-100'; ?>">
                            <i data-lucide="<?php echo $step['icon']; ?>" class="w-5 h-5 md:w-6 md:h-6"></i>
                        </div>
                        
                        <!-- Label -->
                        <div class="flex flex-col md:items-center">
                            <span class="md:mt-4 text-[10px] md:text-[11px] font-bold uppercase tracking-widest <?php echo ($index <= $currentIndex) ? 'text-charcoal' : 'text-gray-300'; ?>">
                                <?php echo $step['label']; ?>
                            </span>
                            <!-- Status helper for mobile -->
                            <span class="text-[9px] text-gray-400 md:hidden font-medium">
                                <?php echo ($index < $currentIndex) ? 'Completado' : (($index === $currentIndex) ? 'En proceso' : 'Pendiente'); ?>
                            </span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="flex-safe gap-10">
            <!-- Left Column: Details -->
            <div class="flex-1-safe space-y-8">
                
                <!-- Products Card -->
                <div class="bg-white rounded-2xl shadow-sm border overflow-hidden" style="border-color: #F2E8E6;">
                    <div class="p-6 border-b" style="border-color: #F2E8E6;">
                        <h2 class="font-serif text-xl text-charcoal">Artículos del Pedido</h2>
                    </div>
                    <div class="divide-y" style="border-color: #F2E8E6;">
                        <?php foreach ($data['details'] as $detail): ?>
                            <div class="p-6 flex items-center gap-6 group">
                                <div class="w-20 h-20 rounded-lg overflow-hidden shrink-0" style="background-color: #FDF5F3;">
                                    <img src="<?php echo e(product_image($detail['imagen_principal'] ?? '')); ?>" alt="<?php echo e($detail['nombre']); ?>" class="w-full h-full object-contain group-hover:scale-110 transition-transform">
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-sm font-bold text-charcoal mb-1"><?php echo e($detail['nombre']); ?></h3>
                                    <p class="text-xs text-charcoal-light">Cantidad: <?php echo (int)$detail['cantidad']; ?></p>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs text-gray-400 mb-1"><?php echo money($detail['precio_unitario']); ?> c/u</p>
                                    <p class="text-sm font-bold text-coral"><?php echo money($detail['subtotal']); ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Extras & Services -->
                <?php if (!empty($data['services'])): ?>
                    <div class="bg-white rounded-2xl shadow-sm border p-6" style="border-color: #F2E8E6;">
                        <h2 class="font-serif text-xl text-charcoal mb-6">Servicios Adicionales</h2>
                        <div class="space-y-4">
                            <?php foreach ($data['services'] as $service): ?>
                                <div class="flex justify-between items-center bg-gray-50 p-4 rounded-xl">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center border border-[#F2E8E6]">
                                            <i data-lucide="sparkles" class="w-4 h-4 text-coral"></i>
                                        </div>
                                        <span class="text-xs font-bold text-charcoal uppercase tracking-widest"><?php echo e($service['nombre']); ?></span>
                                    </div>
                                    <span class="text-sm font-bold text-coral"><?php echo money($service['precio']); ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Delivery & Notes -->
                <div class="flex flex-col md:flex-row gap-8">
                    <!-- Shipping Address -->
                    <div class="w-full md:w-1/2 bg-white rounded-2xl shadow-sm border p-6" style="border-color: #F2E8E6;">
                        <h2 class="font-serif text-xl text-charcoal mb-6">Dirección de Entrega</h2>
                        <div class="space-y-2">
                            <strong class="block text-sm font-bold text-charcoal"><?php echo e($order['nombre'] . ' ' . $order['apellido']); ?></strong>
                            <p class="text-xs text-charcoal-light leading-relaxed">
                                <?php echo e($order['calle'] . ' ' . $order['numero']); ?><br>
                                <?php echo e($order['distrito'] . ', ' . $order['provincia']); ?><br>
                                <?php echo e($order['departamento_prov']); ?>
                            </p>
                            <?php if (!empty($order['referencia'])): ?>
                                <p class="text-[10px] text-coral italic mt-4"><i data-lucide="map-pin" class="w-3 h-3 inline"></i> <?php echo e($order['referencia']); ?></p>
                            <?php endif; ?>
                            <div class="mt-6 pt-4 border-t" style="border-color: #F2E8E6;">
                                <p class="text-[10px] font-bold uppercase text-gray-400">Teléfono de contacto</p>
                                <p class="text-xs font-bold text-charcoal"><?php echo e($order['telefono']); ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Delivery Date & Notes -->
                    <div class="w-full md:w-1/2 bg-white rounded-2xl shadow-sm border p-6" style="border-color: #F2E8E6;">
                        <h2 class="font-serif text-xl text-charcoal mb-6">Fecha & Notas</h2>
                        <div class="mb-6">
                            <p class="text-[10px] font-bold uppercase text-gray-400 mb-2">Fecha Programada</p>
                            <div class="flex items-center gap-3 text-charcoal">
                                <i data-lucide="calendar" class="w-6 h-6 text-coral"></i>
                                <span class="text-sm font-bold"><?php echo date('d \d\e F, Y', strtotime($order['fecha_entrega'] ?? $order['created_at'])); ?></span>
                            </div>
                        </div>
                        <?php if (!empty($order['notas_especiales'])): ?>
                            <p class="text-[10px] font-bold uppercase text-gray-400 mb-2">Dedicatoria o Notas</p>
                            <div class="bg-gray-50 p-4 rounded-xl italic text-xs text-charcoal-light leading-relaxed">
                                "<?php echo nl2br(e($order['notas_especiales'])); ?>"
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Right Column: Summary & Actions -->
            <aside class="w-sidebar-safe">
                <div class="bg-white rounded-2xl shadow-card border p-8 sticky top-24" style="border-color: #F2E8E6;">
                    <h2 class="font-serif text-2xl text-charcoal mb-8 border-b pb-4" style="border-color: #F2E8E6;">Resumen</h2>
                    
                    <div class="space-y-4 mb-10">
                        <div class="flex justify-between text-sm">
                            <span class="text-charcoal-light">Subtotal</span>
                            <span class="text-charcoal font-bold"><?php echo money($order['subtotal']); ?></span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-charcoal-light">Envío</span>
                            <span class="text-charcoal font-bold"><?php echo money($order['costo_envio']); ?></span>
                        </div>
                        <?php if ($order['descuento_total'] > 0): ?>
                            <div class="flex justify-between text-sm">
                                <span class="text-emerald-500 font-bold uppercase tracking-widest text-[10px]">Descuento Aplicado</span>
                                <span class="text-emerald-600 font-bold">-<?php echo money($order['descuento_total']); ?></span>
                            </div>
                        <?php endif; ?>
                        
                        <div class="flex justify-between items-center pt-6 mt-4 border-t-2 border-charcoal/5">
                            <span class="font-serif text-xl text-charcoal">Total Pagado</span>
                            <span class="text-2xl font-serif text-coral"><?php echo money($order['total']); ?></span>
                        </div>
                    </div>

                    <div class="space-y-6 pt-6 border-t" style="border-color: #F2E8E6;">
                        <div>
                            <p class="text-[10px] font-bold uppercase text-gray-400 mb-2">Método de Pago</p>
                            <p class="text-sm font-bold text-charcoal"><?php echo e($order['metodo_pago_nombre'] ?? 'Información no disponible'); ?></p>
                            <span class="inline-block mt-2 px-3 py-1 text-[9px] font-bold uppercase tracking-wider rounded-full border bg-gray-50 text-gray-500">
                                <?php echo e($order['estado_pago']); ?>
                            </span>
                        </div>
                    </div>

                    <?php if ($order['estado_orden'] === 'pendiente' && ($_SESSION['user_rol'] ?? '') !== 'admin'): ?>
                        <div class="mt-10">
                            <a href="<?php echo e(app_url('orders/cancel/' . $order['id'])); ?>" onclick="return confirm('¿Estás seguro de que deseas cancelar esta orden? Esta acción no se puede deshacer.')" class="w-full bg-transparent border border-red-200 text-red-500 py-4 rounded-full text-[10px] font-bold uppercase tracking-widest hover:bg-red-50 transition-colors flex items-center justify-center gap-2">
                                <i data-lucide="x-circle" class="w-4 h-4"></i> Cancelar Pedido
                            </a>
                            <p class="text-[9px] text-gray-400 text-center mt-4">Solo puedes cancelar pedidos que aún estén en estado 'Pendiente'.</p>
                        </div>
                    <?php endif; ?>
                    
                    <div class="mt-10 p-4 rounded-xl bg-[#FDF5F3] border border-[#FDECE8]">
                        <p class="text-[10px] text-coral font-bold uppercase tracking-widest mb-1 text-center">¿Necesitas ayuda?</p>
                        <p class="text-[9px] text-charcoal-light text-center leading-relaxed mb-4">Si tienes alguna duda sobre tu pedido, contáctanos por WhatsApp.</p>
                        <a href="https://wa.me/51999999999" target="_blank" class="flex items-center justify-center gap-2 text-xs font-bold text-charcoal hover:text-coral transition-colors">
                             Chat de Soporte <i data-lucide="external-link" class="w-3 h-3"></i>
                        </a>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</div>
