<?php /** @var array $data */ ?>
<!-- Page Header -->
<section class="bg-blush-50 py-16 px-6 text-center border-b border-gray-100">
    <div class="max-w-4xl mx-auto">
        <span class="text-coral text-sm font-semibold tracking-[0.2em] uppercase mb-4 block">Tu Compra</span>
        <h1 class="text-4xl md:text-5xl font-serif text-charcoal mb-6">Mi Carrito</h1>
        <a href="<?php echo e(app_url('products')); ?>" class="inline-flex items-center gap-2 text-charcoal hover:text-coral transition-colors text-sm font-bold uppercase tracking-widest mt-4">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Seguir Comprando
        </a>
    </div>
</section>

<div class="max-w-7xl mx-auto px-6 py-16">
    <?php if (count($data['items']) > 0): ?>
    <div class="flex-safe gap-12">
            
            <!-- Cart Items -->
            <div class="w-2-3-safe">
                <div class="hidden md:grid grid-cols-12 gap-4 border-b border-gray-200 pb-4 mb-6 text-xs font-bold text-gray-500 uppercase tracking-widest">
                    <div class="col-span-6">Producto</div>
                    <div class="col-span-2 text-center">Precio</div>
                    <div class="col-span-2 text-center">Cantidad</div>
                    <div class="col-span-2 text-right">Subtotal</div>
                </div>

                <div class="space-y-6">
                    <?php foreach ($data['items'] as $item): ?>
                        <div class="relative flex flex-col md:grid md:grid-cols-12 gap-4 items-center bg-white border border-gray-100 p-4 shadow-sm hover:border-coral transition-colors">
                            
                            <!-- Product Info -->
                            <div class="col-span-6 flex items-center gap-4 w-full">
                                <a href="<?php echo e(app_url('products/detail/' . $item['producto_id'])); ?>" class="w-24 h-24 bg-gray-50 shrink-0 overflow-hidden flex items-center justify-center">
                                    <img src="<?php echo e(product_image($item['imagen_principal'])); ?>" alt="<?php echo e($item['nombre']); ?>" class="w-full h-full object-cover">
                                </a>
                                <div>
                                    <h3 class="font-serif text-lg text-charcoal mb-1">
                                        <a href="<?php echo e(app_url('products/detail/' . $item['producto_id'])); ?>" class="hover:text-coral transition-colors"><?php echo e($item['nombre']); ?></a>
                                    </h3>
                                    <p class="text-xs text-gray-400 uppercase tracking-widest">Stock: <?php echo (int)$item['stock']; ?></p>
                                </div>
                            </div>
                            
                            <!-- Price (Desktop) -->
                            <div class="col-span-2 text-center hidden md:block">
                                <span class="text-charcoal font-medium"><?php echo money($item['precio_unitario']); ?></span>
                            </div>
                            
                            <!-- Quantity -->
                            <div class="col-span-2 flex justify-center w-full md:w-auto mt-4 md:mt-0">
                                <form action="<?php echo e(app_url('cart/update/' . $item['producto_id'])); ?>" method="POST" class="flex border border-gray-200 w-full max-w-[120px]">
                                    <input type="number" name="cantidad" min="0" max="<?php echo (int)$item['stock']; ?>" value="<?php echo (int)$item['cantidad']; ?>" class="w-full text-center text-charcoal font-bold outline-none border-none py-2 text-sm bg-transparent" onchange="this.form.submit()">
                                </form>
                            </div>
                            
                            <!-- Subtotal & Remove -->
                            <div class="col-span-2 flex justify-between md:justify-end items-center w-full md:w-auto mt-4 md:mt-0 pt-4 md:pt-0 border-t md:border-t-0 border-gray-100">
                                <span class="text-charcoal font-bold block md:hidden">Subtotal: </span>
                                <span class="text-charcoal font-bold md:text-right w-full"><?php echo money($item['cantidad'] * $item['precio_unitario']); ?></span>
                                <a href="<?php echo e(app_url('cart/remove/' . $item['producto_id'])); ?>" onclick="return confirm('¿Eliminar producto del carrito?')" class="absolute top-4 right-4 md:relative md:top-auto md:right-auto md:ml-4 text-gray-400 hover:text-coral transition-colors" title="Eliminar">
                                    <i data-lucide="x" class="w-5 h-5"></i>
                                </a>
                            </div>
                            
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="mt-8">
                    <a href="<?php echo e(app_url('cart/clear')); ?>" onclick="return confirm('¿Vaciar todo el carrito?')" class="text-sm font-bold text-gray-400 hover:text-coral uppercase tracking-widest transition-colors flex items-center gap-2">
                        <i data-lucide="trash-2" class="w-4 h-4"></i> Vaciar carrito completo
                    </a>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="w-sidebar-safe">
                <div class="bg-gray-50 border border-gray-200 p-8">
                    <h2 class="font-serif text-2xl text-charcoal mb-6 border-b border-gray-200 pb-4">Resumen</h2>
                    
                    <div class="space-y-4 mb-6">
                        <div class="flex justify-between items-center text-charcoal-light">
                            <span>Subtotal</span>
                            <span class="font-medium text-charcoal"><?php echo money($data['total']); ?></span>
                        </div>
                        <div class="flex justify-between items-center text-charcoal-light">
                            <span>Envío</span>
                            <span class="text-sm italic">Se calcula en checkout</span>
                        </div>
                    </div>
                    
                    <div class="border-t border-gray-200 pt-4 mb-8">
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-bold text-charcoal">Total Parcial</span>
                            <span class="text-2xl font-bold text-coral"><?php echo money($data['total']); ?></span>
                        </div>
                    </div>
                    
                    <a href="<?php echo e(app_url('cart/checkout')); ?>" class="block w-full bg-charcoal hover:bg-coral text-white text-center font-bold uppercase tracking-widest text-sm py-4 transition-colors mb-4">
                        Proceder al Checkout
                    </a>
                    
                    <div class="flex items-center justify-center gap-3 text-gray-400 mt-6">
                        <i data-lucide="shield-check" class="w-5 h-5"></i>
                        <span class="text-xs uppercase tracking-widest">Pago Seguro y Cifrado</span>
                    </div>
                </div>
            </div>

        </div>
    <?php else: ?>
        <div class="text-center py-24 bg-gray-50 border border-gray-100 max-w-3xl mx-auto">
            <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center mx-auto mb-6 shadow-sm border border-gray-100">
                <i data-lucide="shopping-bag" class="w-10 h-10 text-gray-300"></i>
            </div>
            <h2 class="font-serif text-3xl text-charcoal mb-4">Tu carrito está vacío</h2>
            <p class="text-charcoal-light mb-8 max-w-md mx-auto">Agrega nuestros hermosos ramos, arreglos o flores individuales para empezar a llenar tu carrito de alegría.</p>
            <a href="<?php echo e(app_url('products')); ?>" class="bg-coral hover:bg-coral-hover text-white font-bold uppercase tracking-widest text-sm px-8 py-4 transition-colors inline-block">
                Explorar Catálogo
            </a>
        </div>
    <?php endif; ?>
</div>
