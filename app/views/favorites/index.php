<?php /** @var array $data */ ?>
<div class="min-h-screen" style="background-color: #FDF9F8;">
    <!-- Page Header -->
    <section class="py-16 px-6 text-center border-b" style="background-color: #FFF5F0; border-color: #FDECE8;">
        <div class="max-w-4xl mx-auto">
            <span class="font-script text-coral text-3xl block mb-2">Wishlist</span>
            <h1 class="text-4xl md:text-5xl font-serif text-charcoal mb-6">Mis Favoritos</h1>
            <div class="flex justify-center gap-4 mt-8">
                <a href="<?php echo e(app_url('user/profile')); ?>" class="bg-transparent border border-transparent text-charcoal-light hover:text-coral px-6 py-2 rounded-full text-xs font-bold uppercase tracking-wider transition-colors">Mi Perfil</a>
                <a href="<?php echo e(app_url('orders')); ?>" class="bg-transparent border border-transparent text-charcoal-light hover:text-coral px-6 py-2 rounded-full text-xs font-bold uppercase tracking-wider transition-colors">Mis Pedidos</a>
                <a class="bg-white border text-coral px-6 py-2 rounded-full text-xs font-bold uppercase tracking-wider shadow-sm transition-colors" style="border-color: #F2E8E6; cursor: default;">Favoritos</a>
            </div>
        </div>
    </section>

    <!-- Favorites Content -->
    <div class="max-w-7xl mx-auto px-6 py-14">
        <?php if ($data['favorites']): ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <?php foreach ($data['favorites'] as $fav): ?>
                    <div class="group bg-white rounded-2xl shadow-sm hover:shadow-card transition-all overflow-hidden border border-[#F2E8E6] flex flex-col h-full text-center">
                        <a href="<?php echo e(app_url('products/detail/' . $fav['producto_id'])); ?>" class="relative block aspect-square overflow-hidden" style="background-color: #FDF5F3;">
                            <img src="<?php echo e(product_image($fav['imagen_principal'])); ?>" alt="<?php echo e($fav['nombre']); ?>" class="w-4/5 h-4/5 object-contain mx-auto mt-[10%] transition-transform duration-500 group-hover:scale-110">
                            
                            <a href="<?php echo e(app_url('favorites/remove/' . $fav['producto_id'])); ?>" class="absolute top-3 right-3 bg-white/80 backdrop-blur-sm text-red-500 p-2 rounded-full shadow-sm hover:bg-red-500 hover:text-white transition-all z-20" title="Quitar de favoritos">
                                <i data-lucide="heart" class="w-4 h-4 fill-current"></i>
                            </a>
                        </a>
                        
                        <div class="p-5 flex flex-col flex-1">
                            <h3 class="text-sm font-serif font-bold text-charcoal group-hover:text-coral transition-colors mb-2 leading-snug">
                                <a href="<?php echo e(app_url('products/detail/' . $fav['producto_id'])); ?>"><?php echo e($fav['nombre']); ?></a>
                            </h3>
                            
                            <div class="flex items-center justify-center gap-2 mt-auto mb-4">
                                <span class="text-coral font-bold text-sm"><?php echo money($fav['precio_actual'] ?? $fav['precio_unitario']); ?></span>
                            </div>

                            <?php if ((int)$fav['stock'] > 0): ?>
                                <form action="<?php echo e(app_url('cart/add/' . $fav['producto_id'])); ?>" method="POST" class="w-full">
                                    <input type="hidden" name="cantidad" value="1">
                                    <button class="w-full bg-charcoal hover:bg-coral text-white py-2.5 text-[10px] font-bold uppercase tracking-widest rounded-lg transition-colors flex items-center justify-center gap-2" type="submit">
                                        <i data-lucide="shopping-bag" class="w-3.5 h-3.5"></i> Añadir al Carrito
                                    </button>
                                </form>
                            <?php else: ?>
                                <span class="w-full bg-gray-100 text-gray-400 py-2.5 text-[10px] font-bold uppercase tracking-widest rounded-lg cursor-not-allowed">Agotado</span>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-24 bg-white rounded-2xl shadow-sm border max-w-2xl mx-auto px-10" style="border-color: #F2E8E6;">
                <div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6" style="background-color: #FDF5F3;">
                    <i data-lucide="heart" class="w-10 h-10 text-coral"></i>
                </div>
                <h2 class="font-serif text-2xl text-charcoal mb-4">Tu wishlist está vacía</h2>
                <p class="text-charcoal-light mb-8 max-w-md mx-auto">Guarda los arreglos que más te gusten para encontrarlos rápidamente más adelante.</p>
                <a href="<?php echo e(app_url('products')); ?>" class="inline-block bg-coral hover:bg-[#D93838] text-white px-10 py-4 rounded-full text-xs font-bold uppercase tracking-widest transition-all shadow-sm">
                    Explorar Productos
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
