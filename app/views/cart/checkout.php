<?php /** @var array $data */ ?>
<div class="min-h-screen pb-20" style="background-color: #FDF9F8;">
    <!-- Page Header -->
    <section class="py-16 px-6 text-center border-b" style="background-color: #FFF5F0; border-color: #FDECE8;">
        <div class="max-w-4xl mx-auto">
            <span class="font-script text-coral text-3xl block mb-2">Finalizar Compra</span>
            <h1 class="text-4xl md:text-5xl font-serif text-charcoal mb-4">Checkout</h1>
            <p class="text-charcoal-light text-sm uppercase tracking-widest font-bold">Estás a un paso de enviar felicidad</p>
        </div>
    </section>

    <!-- Checkout Layout -->
    <form class="max-w-7xl mx-auto px-6 py-14 flex-safe gap-12" method="POST" action="<?php echo e(app_url('cart/processOrder')); ?>">
        
        <!-- Main Form Column -->
        <div class="flex-1-safe space-y-10">
            <!-- Delivery Address Panel -->
            <div class="bg-white rounded-2xl shadow-sm border p-8" style="border-color: #F2E8E6;">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center bg-coral text-white text-sm font-bold">1</div>
                    <h2 class="font-serif text-2xl text-charcoal">Dirección de Entrega</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <?php if (count($data['addresses']) > 0): ?>
                        <?php foreach ($data['addresses'] as $addr): ?>
                            <label class="relative border rounded-xl p-5 cursor-pointer transition-all hover:border-coral group has-[:checked]:border-coral has-[:checked]:bg-[#FDF5F3]">
                                <input type="radio" name="direccion_id" value="<?php echo (int)$addr['id']; ?>" <?php echo $addr['es_principal'] ? 'checked' : ''; ?> required class="absolute top-5 right-5 w-4 h-4 text-coral focus:ring-coral border-gray-300">
                                <div class="pr-8">
                                    <strong class="block text-sm font-bold text-charcoal mb-1"><?php echo e($addr['calle'] . ' ' . $addr['numero']); ?></strong>
                                    <?php if (!empty($addr['departamento'])): ?>
                                        <span class="block text-xs text-charcoal-light mb-1">Depto. <?php echo e($addr['departamento']); ?></span>
                                    <?php endif; ?>
                                    <span class="block text-[11px] text-gray-500 mb-1 uppercase tracking-wider"><?php echo e($addr['distrito'] . ', ' . $addr['provincia']); ?></span>
                                    <?php if (!empty($addr['referencia'])): ?>
                                        <span class="block text-[10px] text-coral italic mt-2"><i data-lucide="map-pin" class="w-3 h-3 inline"></i> <?php echo e($addr['referencia']); ?></span>
                                    <?php endif; ?>
                                </div>
                            </label>
                        <?php endforeach; ?>
                    <?php endif; ?>

                    <!-- Add New Address Button (Always Visible) -->
                    <a href="<?php echo e(app_url('user/profile')); ?>" class="relative border-2 border-dashed rounded-xl p-5 cursor-pointer transition-all hover:border-coral hover:bg-[#FDF5F3] group flex flex-col items-center justify-center text-center gap-2 min-h-[100px]" style="border-color: #E5E7EB;">
                        <div class="w-8 h-8 rounded-full bg-gray-50 group-hover:bg-coral/10 flex items-center justify-center transition-colors">
                            <i data-lucide="plus" class="w-5 h-5 text-gray-400 group-hover:text-coral"></i>
                        </div>
                        <span class="text-xs font-bold text-gray-500 group-hover:text-coral uppercase tracking-widest">Agregar Dirección</span>
                    </a>
                </div>
            </div>

            <!-- Delivery Date & Notes -->
            <div class="bg-white rounded-2xl shadow-sm border p-8" style="border-color: #F2E8E6;">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center bg-coral text-white text-sm font-bold">2</div>
                    <h2 class="font-serif text-2xl text-charcoal">Detalles de la Entrega</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label class="block text-xs font-bold text-charcoal uppercase tracking-wider mb-3">Fecha de Entrega *</label>
                        <input type="date" name="fecha_entrega" min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" required class="w-full bg-gray-50 border py-3 px-4 text-sm outline-none focus:border-coral transition-colors rounded-lg appearance-none" style="border-color: #E5E7EB;">
                        <p class="text-[10px] text-gray-500 mt-2">Los pedidos deben realizarse con al menos 24h de anticipación.</p>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-charcoal uppercase tracking-wider mb-3">Notas o Dedicatoria</label>
                        <textarea name="notas" rows="4" placeholder="Ej: Entregar a portería, o el mensaje para la tarjeta de regalo..." class="w-full bg-gray-50 border py-3 px-4 text-sm outline-none focus:border-coral transition-colors rounded-lg resize-none" style="border-color: #E5E7EB;"></textarea>
                    </div>
                </div>
            </div>

            <!-- Payment Method Panel -->
            <div class="bg-white rounded-2xl shadow-sm border p-8" style="border-color: #F2E8E6;">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center bg-coral text-white text-sm font-bold">3</div>
                    <h2 class="font-serif text-2xl text-charcoal">Método de Pago</h2>
                </div>

                <?php if (count($data['payment_methods']) > 0): ?>
                    <div class="space-y-4">
                        <?php foreach ($data['payment_methods'] as $index => $method): ?>
                            <label class="relative border rounded-xl p-5 cursor-pointer transition-all hover:border-coral flex items-center gap-4 has-[:checked]:border-coral has-[:checked]:bg-[#FDF5F3]">
                                <input type="radio" name="metodo_pago_id" value="<?php echo (int)$method['id']; ?>" <?php echo $index === 0 ? 'checked' : ''; ?> required class="w-4 h-4 text-coral focus:ring-coral border-gray-300">
                                <div class="flex-1">
                                    <strong class="block text-sm font-bold text-charcoal"><?php echo e($method['nombre']); ?></strong>
                                    <p class="text-xs text-charcoal-light"><?php echo e($method['descripcion']); ?></p>
                                </div>
                            </label>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-6 text-red-500 text-sm font-bold">No hay métodos de pago activos.</div>
                <?php endif; ?>
            </div>

            <!-- Services & Coupon -->
            <div class="bg-white rounded-2xl shadow-sm border p-8" style="border-color: #F2E8E6;">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center bg-coral text-white text-sm font-bold">4</div>
                    <h2 class="font-serif text-2xl text-charcoal">Extras & Cupón</h2>
                </div>

                <?php if (count($data['services']) > 0): ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                        <?php foreach ($data['services'] as $service): ?>
                            <label class="relative border rounded-xl p-4 cursor-pointer transition-all hover:border-coral flex items-center gap-3 has-[:checked]:border-coral has-[:checked]:bg-[#FDF5F3]">
                                <input type="checkbox" name="servicios[]" value="<?php echo (int)$service['id']; ?>" data-price="<?php echo (float)$service['precio']; ?>" class="service-checkbox w-4 h-4 text-coral focus:ring-coral border-gray-300 rounded">
                                <div class="flex-1">
                                    <div class="flex justify-between items-start">
                                        <strong class="text-xs font-bold text-charcoal"><?php echo e($service['nombre']); ?></strong>
                                        <span class="text-xs font-bold text-coral">+<?php echo money($service['precio']); ?></span>
                                    </div>
                                    <p class="text-[10px] text-gray-500"><?php echo e($service['descripcion']); ?></p>
                                </div>
                            </label>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <div class="max-w-md">
                    <label class="block text-xs font-bold text-charcoal uppercase tracking-wider mb-3">Código de Cupón</label>
                    <div class="flex gap-2">
                        <input type="text" name="cupon" placeholder="Ej: FLORES20" class="flex-1 bg-gray-50 border py-3 px-4 text-sm outline-none focus:border-coral transition-colors rounded-lg uppercase" style="border-color: #E5E7EB;">
                        <button type="button" class="bg-charcoal text-white px-6 py-2 rounded-lg text-[10px] font-bold uppercase tracking-widest hover:opacity-90">Validar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Summary Column -->
        <aside class="w-sidebar-safe">
            <div class="bg-white rounded-2xl shadow-card border p-8 sticky top-24" style="border-color: #F2E8E6;">
                <h2 class="font-serif text-2xl text-charcoal mb-8 border-b pb-4" style="border-color: #F2E8E6;">Resumen</h2>
                
                <!-- Items List -->
                <div class="space-y-4 mb-8 max-h-80 overflow-y-auto pr-2 custom-scrollbar">
                    <?php foreach ($data['items'] as $item): ?>
                        <div class="flex gap-4">
                            <div class="w-16 h-16 rounded-lg overflow-hidden shrink-0" style="background-color: #FDF5F3;">
                                <img src="<?php echo e(product_image($item['imagen_principal'])); ?>" alt="<?php echo e($item['nombre']); ?>" class="w-full h-full object-contain">
                            </div>
                            <div class="flex-1">
                                <h4 class="text-xs font-bold text-charcoal mb-1"><?php echo e($item['nombre']); ?></h4>
                                <div class="flex justify-between items-center">
                                    <span class="text-[11px] text-gray-500"><?php echo (int)$item['cantidad']; ?> x <?php echo money($item['precio_unitario']); ?></span>
                                    <span class="text-xs font-bold text-charcoal"><?php echo money($item['precio_unitario'] * $item['cantidad']); ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Totals -->
                <div class="space-y-4 pt-6 border-t" style="border-color: #F2E8E6;">
                    <div class="flex justify-between text-sm">
                        <span class="text-charcoal-light">Subtotal</span>
                        <span class="text-charcoal font-bold"><?php echo money($data['subtotal']); ?></span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-charcoal-light">Envío</span>
                        <span class="text-charcoal font-bold"><?php echo money($data['shipping']); ?></span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-charcoal-light">Servicios Extra</span>
                        <span class="text-coral font-bold" id="services-total">S/. 0.00</span>
                    </div>
                    
                    <div class="flex justify-between items-center pt-6 mt-4 border-t-2 border-charcoal/5">
                        <span class="font-serif text-xl text-charcoal">Total</span>
                        <span class="text-2xl font-serif text-coral" id="checkout-total" data-base="<?php echo (float)$data['total']; ?>"><?php echo money($data['total']); ?></span>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full bg-coral hover:bg-[#D93838] text-white py-5 rounded-full text-sm font-bold uppercase tracking-widest transition-all shadow-lg mt-10 flex items-center justify-center gap-3" <?php echo (!$data['addresses'] || !$data['payment_methods']) ? 'disabled' : ''; ?>>
                    Confirmar Pedido <i data-lucide="check-circle" class="w-5 h-5"></i>
                </button>
                <p class="text-[10px] text-gray-400 text-center mt-6 uppercase tracking-wider font-medium">Compra 100% segura y garantizada</p>
            </div>
        </aside>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const serviceCheckboxes = document.querySelectorAll('.service-checkbox');
    const servicesTotalElement = document.getElementById('services-total');
    const checkoutTotalElement = document.getElementById('checkout-total');
    
    function updateTotals() {
        let servicesTotal = 0;
        const baseTotal = parseFloat(checkoutTotalElement.dataset.base);
        
        serviceCheckboxes.forEach(cb => {
            if (cb.checked) {
                servicesTotal += parseFloat(cb.dataset.price);
            }
        });
        
        const finalTotal = baseTotal + servicesTotal;
        
        servicesTotalElement.textContent = 'S/. ' + servicesTotal.toFixed(2);
        checkoutTotalElement.textContent = 'S/. ' + finalTotal.toFixed(2);
    }
    
    serviceCheckboxes.forEach(cb => {
        cb.addEventListener('change', updateTotals);
    });
});
</script>
