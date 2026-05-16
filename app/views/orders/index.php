<?php /** @var array $data */ ?>
<div class="min-h-screen" style="background-color: #FDF9F8;">
    <!-- Page Header -->
    <section class="py-16 px-6 text-center border-b" style="background-color: #FFF5F0; border-color: #FDECE8;">
        <div class="max-w-4xl mx-auto">
            <span class="font-script text-coral text-3xl block mb-2">Historial</span>
            <h1 class="text-4xl md:text-5xl font-serif text-charcoal mb-6">Mis Pedidos</h1>
            <div class="flex justify-center gap-4 mt-8">
                <a href="<?php echo e(app_url('user/profile')); ?>" class="bg-transparent border border-transparent text-charcoal-light hover:text-coral px-6 py-2 rounded-full text-xs font-bold uppercase tracking-wider transition-colors">Mi Perfil</a>
                <a class="bg-white border text-coral px-6 py-2 rounded-full text-xs font-bold uppercase tracking-wider shadow-sm transition-colors" style="border-color: #F2E8E6; cursor: default;">Mis Pedidos</a>
                <a href="<?php echo e(app_url('favorites')); ?>" class="bg-transparent border border-transparent text-charcoal-light hover:text-coral px-6 py-2 rounded-full text-xs font-bold uppercase tracking-wider transition-colors">Favoritos</a>
            </div>
        </div>
    </section>

    <!-- Orders Content -->
    <div class="max-w-5xl mx-auto px-6 py-14">
        <?php if (count($data['orders']) > 0): ?>
            <div class="bg-white rounded-2xl shadow-sm border overflow-hidden" style="border-color: #F2E8E6;">
                <!-- Desktop Table View -->
                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b" style="border-color: #F2E8E6;">
                                <th class="px-6 py-4 text-[10px] font-bold text-charcoal uppercase tracking-widest">Número</th>
                                <th class="px-6 py-4 text-[10px] font-bold text-charcoal uppercase tracking-widest">Fecha</th>
                                <th class="px-6 py-4 text-[10px] font-bold text-charcoal uppercase tracking-widest">Total</th>
                                <th class="px-6 py-4 text-[10px] font-bold text-charcoal uppercase tracking-widest">Estado</th>
                                <th class="px-6 py-4 text-[10px] font-bold text-charcoal uppercase tracking-widest">Pago</th>
                                <th class="px-6 py-4 text-[10px] font-bold text-charcoal uppercase tracking-widest text-right">Acción</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php foreach ($data['orders'] as $order): ?>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-5">
                                        <span class="text-sm font-bold text-charcoal">#<?php echo e($order['numero_orden']); ?></span>
                                    </td>
                                    <td class="px-6 py-5">
                                        <span class="text-xs text-charcoal-light"><?php echo date('d/m/Y', strtotime($order['created_at'])); ?></span>
                                    </td>
                                    <td class="px-6 py-5">
                                        <span class="text-sm font-bold text-coral"><?php echo money($order['total']); ?></span>
                                    </td>
                                    <td class="px-6 py-5">
                                        <?php 
                                            $statusMap = [
                                                'pendiente' => ['label' => 'Recibido', 'class' => 'bg-amber-50 text-amber-600 border-amber-100'],
                                                'confirmada' => ['label' => 'Confirmado', 'class' => 'bg-blue-50 text-blue-600 border-blue-100'],
                                                'preparando' => ['label' => 'Preparando', 'class' => 'bg-purple-50 text-purple-600 border-purple-100'],
                                                'listo_envio' => ['label' => 'Listo', 'class' => 'bg-indigo-50 text-indigo-600 border-indigo-100'],
                                                'enviada' => ['label' => 'En Camino', 'class' => 'bg-orange-50 text-orange-600 border-orange-100'],
                                                'entregada' => ['label' => 'Entregado', 'class' => 'bg-emerald-50 text-emerald-600 border-emerald-100'],
                                                'cancelada' => ['label' => 'Cancelado', 'class' => 'bg-red-50 text-red-600 border-red-100'],
                                                'devuelto' => ['label' => 'Devuelto', 'class' => 'bg-gray-50 text-gray-600 border-gray-100']
                                            ];
                                            $s = $statusMap[$order['estado_orden']] ?? ['label' => $order['estado_orden'], 'class' => 'bg-gray-50 text-gray-600 border-gray-100'];
                                        ?>
                                        <span class="inline-block px-3 py-1 text-[9px] font-bold uppercase tracking-wider rounded-full border <?php echo $s['class']; ?>">
                                            <?php echo $s['label']; ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-5">
                                        <span class="text-[10px] font-medium text-gray-500 uppercase"><?php echo e($order['estado_pago']); ?></span>
                                    </td>
                                    <td class="px-6 py-5 text-right">
                                        <a href="<?php echo e(app_url('orders/detail/' . $order['id'])); ?>" class="inline-flex items-center gap-2 text-[10px] font-bold uppercase tracking-widest text-charcoal hover:text-coral transition-colors">
                                            Detalles <i data-lucide="chevron-right" class="w-3 h-3"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Card View -->
                <div class="block md:hidden divide-y divide-gray-100">
                    <?php foreach ($data['orders'] as $order): ?>
                        <div class="p-6 space-y-4">
                            <div class="flex justify-between items-start">
                                <div>
                                    <span class="text-xs text-charcoal-light block mb-1"><?php echo date('d/m/Y', strtotime($order['created_at'])); ?></span>
                                    <span class="text-sm font-bold text-charcoal">#<?php echo e($order['numero_orden']); ?></span>
                                </div>
                                <span class="text-base font-bold text-coral"><?php echo money($order['total']); ?></span>
                            </div>
                            <div class="flex items-center justify-between">
                                <?php 
                                    $s = $statusMap[$order['estado_orden']] ?? ['label' => $order['estado_orden'], 'class' => 'bg-gray-50 text-gray-600 border-gray-100'];
                                ?>
                                <span class="inline-block px-3 py-1 text-[9px] font-bold uppercase tracking-wider rounded-full border <?php echo $s['class']; ?>">
                                    <?php echo $s['label']; ?>
                                </span>
                                <a href="<?php echo e(app_url('orders/detail/' . $order['id'])); ?>" class="text-[10px] font-bold uppercase tracking-widest text-charcoal flex items-center gap-1">
                                    Ver Detalle <i data-lucide="chevron-right" class="w-3 h-3"></i>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php else: ?>
            <div class="text-center py-24 bg-white rounded-2xl shadow-sm border max-w-2xl mx-auto px-10" style="border-color: #F2E8E6;">
                <div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6" style="background-color: #FDF5F3;">
                    <i data-lucide="shopping-bag" class="w-10 h-10 text-coral"></i>
                </div>
                <h2 class="font-serif text-2xl text-charcoal mb-4">Aún no tienes pedidos</h2>
                <p class="text-charcoal-light mb-8 max-w-md mx-auto">Cuando completes una compra, aparecerá aquí para que puedas hacerle seguimiento.</p>
                <a href="<?php echo e(app_url('products')); ?>" class="inline-block bg-coral hover:bg-[#D93838] text-white px-10 py-4 rounded-full text-xs font-bold uppercase tracking-widest transition-all shadow-sm">
                    Empezar a comprar
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
