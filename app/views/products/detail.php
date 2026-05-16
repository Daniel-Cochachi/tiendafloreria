<?php /** @var array $data */ ?>
<?php $product = $data['product']; ?>

<!-- Product Breadcrumb -->
<div class="bg-gray-50 border-b border-gray-100 py-4 px-6">
    <div class="max-w-7xl mx-auto text-xs text-charcoal-light uppercase tracking-widest font-semibold">
        <a href="<?php echo e(app_url()); ?>" class="hover:text-coral transition-colors">Inicio</a> 
        <span class="mx-2">/</span> 
        <a href="<?php echo e(app_url('products')); ?>" class="hover:text-coral transition-colors">Catálogo</a>
        <span class="mx-2">/</span>
        <a href="<?php echo e(app_url('products', ['category' => $product['categoria_id']])); ?>" class="hover:text-coral transition-colors"><?php echo e($product['categoria_nombre']); ?></a>
        <span class="mx-2">/</span>
        <span class="text-charcoal"><?php echo e($product['nombre']); ?></span>
    </div>
</div>

<section class="max-w-7xl mx-auto px-6 py-12 md:py-16">
    <div class="flex flex-col md:flex-row gap-12 lg:gap-20">
        
        <!-- Left: Image Gallery -->
        <div class="w-full md:w-[42%] flex flex-col gap-6">
            <div class="bg-gray-50 rounded-2xl overflow-hidden flex items-center justify-center relative border border-gray-100 shadow-sm group" style="aspect-ratio: 1/1; max-height: 520px;">
                <img src="<?php echo e(product_image($product['imagen_principal'])); ?>" alt="<?php echo e($product['nombre']); ?>" class="w-full h-full object-contain p-12 transition-transform duration-700 group-hover:scale-105">
                <?php if (!empty($product['descuento_porcentaje']) && (float)$product['descuento_porcentaje'] > 0): ?>
                    <span class="absolute top-6 left-6 bg-coral text-white text-[9px] font-bold uppercase tracking-widest px-3 py-1.5 z-10 shadow-lg rounded-full">
                        -<?php echo e((float)$product['descuento_porcentaje']); ?>%
                    </span>
                <?php endif; ?>
            </div>
            
            <!-- Secondary Images (Thumbnails if any) -->
            <?php 
                $hasSecondaries = false;
                for($i=1; $i<=3; $i++) if(!empty($product['imagen_secundaria'.$i])) $hasSecondaries = true;
            ?>
            <?php if ($hasSecondaries): ?>
                <div class="flex gap-4 overflow-x-auto pb-2 scrollbar-hide">
                    <div class="w-20 h-20 rounded-xl border-2 border-coral overflow-hidden shrink-0 cursor-pointer">
                        <img src="<?php echo e(product_image($product['imagen_principal'])); ?>" class="w-full h-full object-cover">
                    </div>
                    <?php for($i=1; $i<=3; $i++): ?>
                        <?php if(!empty($product['imagen_secundaria'.$i])): ?>
                            <div class="w-20 h-20 rounded-xl border border-gray-100 overflow-hidden shrink-0 cursor-pointer hover:border-coral transition-colors">
                                <img src="<?php echo e(product_image($product['imagen_secundaria'.$i])); ?>" class="w-full h-full object-cover">
                            </div>
                        <?php endif; ?>
                    <?php endfor; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Right: Product Info -->
        <div class="w-full md:w-[58%] flex flex-col justify-center">
            <span class="text-coral text-sm font-semibold tracking-[0.2em] uppercase mb-4"><?php echo e($product['categoria_nombre']); ?></span>
            <h1 class="text-4xl font-serif text-charcoal mb-4"><?php echo e($product['nombre']); ?></h1>
            
            <div class="flex items-center gap-4 mb-6">
                <div class="flex items-center gap-1">
                    <?php if (!empty($data['rating']['promedio'])): ?>
                        <?php for ($i = 0; $i < 5; $i++): ?>
                            <i data-lucide="star" class="w-4 h-4 <?php echo $i < floor((float)$data['rating']['promedio']) ? 'fill-coral text-coral' : 'text-gray-200'; ?>"></i>
                        <?php endfor; ?>
                        <span class="text-sm font-bold text-charcoal ml-2"><?php echo number_format((float)$data['rating']['promedio'], 1); ?>/5</span>
                        <span class="text-sm text-gray-400 ml-1">(<?php echo (int)$data['rating']['total_resenas']; ?> reseñas)</span>
                    <?php else: ?>
                        <div class="flex items-center gap-1 text-gray-300">
                            <i data-lucide="star" class="w-4 h-4"></i><i data-lucide="star" class="w-4 h-4"></i><i data-lucide="star" class="w-4 h-4"></i><i data-lucide="star" class="w-4 h-4"></i><i data-lucide="star" class="w-4 h-4"></i>
                        </div>
                        <span class="text-sm text-gray-400 ml-2">Sin reseñas aún</span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="flex items-center gap-4 mb-6">
                <?php if (!empty($product['descuento_porcentaje']) && (float)$product['descuento_porcentaje'] > 0): ?>
                    <span class="text-2xl font-medium text-coral"><?php echo money($product['precio_actual']); ?></span>
                    <span class="text-lg text-gray-400 line-through"><?php echo money($product['precio_unitario']); ?></span>
                <?php else: ?>
                    <span class="text-2xl font-medium text-charcoal"><?php echo money($product['precio_unitario']); ?></span>
                <?php endif; ?>
            </div>

            <p class="text-charcoal-light leading-relaxed mb-8">
                <?php echo nl2br(e($product['descripcion'])); ?>
            </p>

            <ul class="space-y-3 text-sm text-charcoal mb-8 border-y border-gray-100 py-6">
                <li class="flex items-center gap-3">
                    <i data-lucide="hash" class="w-4 h-4 text-gray-400"></i>
                    <span class="font-bold w-24">SKU:</span> 
                    <span class="text-gray-500"><?php echo e($product['codigo_sku']); ?></span>
                </li>
                <li class="flex items-center gap-3">
                    <i data-lucide="calendar" class="w-4 h-4 text-gray-400"></i>
                    <span class="font-bold w-24">Duración:</span> 
                    <span class="text-gray-500"><?php echo (int)$product['duracion_dias']; ?> días aprox.</span>
                </li>
                <?php if (!empty($product['cuidados'])): ?>
                    <li class="flex items-start gap-3">
                        <i data-lucide="heart" class="w-4 h-4 text-coral shrink-0 mt-0.5"></i>
                        <span class="font-bold w-24 shrink-0">Cuidados:</span> 
                        <span class="text-gray-500"><?php echo e($product['cuidados']); ?></span>
                    </li>
                <?php endif; ?>
            </ul>

            <div class="flex items-center gap-4 mb-4">
                <?php if ((int)$product['stock'] > 0): ?>
                    <span class="flex items-center gap-1.5 text-sm font-bold text-green-600 bg-green-50 px-3 py-1 rounded-full">
                        <span class="w-2 h-2 rounded-full bg-green-500"></span> En Stock (<?php echo (int)$product['stock']; ?>)
                    </span>
                <?php else: ?>
                    <span class="flex items-center gap-1.5 text-sm font-bold text-red-600 bg-red-50 px-3 py-1 rounded-full">
                        <span class="w-2 h-2 rounded-full bg-red-500"></span> Agotado
                    </span>
                <?php endif; ?>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 mt-4">
                <?php if ((int)$product['stock'] > 0): ?>
                    <form action="<?php echo e(app_url('cart/add/' . $product['id'])); ?>" method="POST" class="flex flex-1 gap-4">
                        <div class="w-24 border border-gray-200 flex items-center justify-center bg-white">
                            <input type="number" name="cantidad" min="1" max="<?php echo (int)$product['stock']; ?>" value="1" class="w-full text-center text-charcoal font-bold outline-none border-none py-3" required>
                        </div>
                        <button type="submit" class="flex-1 bg-charcoal hover:bg-coral text-white font-bold uppercase tracking-widest text-sm py-4 transition-colors flex items-center justify-center gap-2">
                            <i data-lucide="shopping-cart" class="w-4 h-4"></i> Añadir al Carrito
                        </button>
                    </form>
                <?php else: ?>
                    <button disabled class="flex-1 bg-gray-200 text-gray-500 font-bold uppercase tracking-widest text-sm py-4 cursor-not-allowed">
                        Agotado
                    </button>
                <?php endif; ?>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <?php if ($data['is_favorite']): ?>
                        <form action="<?php echo e(app_url('products/removeFavorite/' . $product['id'])); ?>" method="POST">
                            <button type="submit" class="w-14 h-full min-h-[56px] border border-coral text-coral hover:bg-coral hover:text-white flex items-center justify-center transition-colors" title="Quitar de Favoritos">
                                <i data-lucide="heart" class="w-5 h-5 fill-coral hover:fill-white"></i>
                            </button>
                        </form>
                    <?php else: ?>
                        <form action="<?php echo e(app_url('products/addToFavorite/' . $product['id'])); ?>" method="POST">
                            <button type="submit" class="w-14 h-full min-h-[56px] border border-gray-200 text-gray-400 hover:border-coral hover:text-coral flex items-center justify-center transition-colors" title="Añadir a Favoritos">
                                <i data-lucide="heart" class="w-5 h-5"></i>
                            </button>
                        </form>
                    <?php endif; ?>
                <?php else: ?>
                    <a href="<?php echo e(app_url('user/login')); ?>" class="w-14 h-full min-h-[56px] border border-gray-200 text-gray-400 hover:border-coral hover:text-coral flex items-center justify-center transition-colors" title="Inicia sesión para guardar">
                        <i data-lucide="heart" class="w-5 h-5"></i>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- Reviews & Related -->
<div class="bg-gray-50 py-16 border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-6">
        
        <div class="flex-safe gap-10 lg:gap-16">
            <!-- Reviews -->
            <div class="w-2-3-safe">
                <div class="flex items-center justify-between mb-8 pb-4 border-b border-gray-200">
                    <h2 class="font-serif text-2xl text-charcoal">Reseñas de Clientes</h2>
                    <span class="text-sm font-bold text-gray-500 bg-gray-200 px-3 py-1 rounded-full"><?php echo count($data['reviews']); ?></span>
                </div>

                <!-- Add Review -->
                <div class="bg-white p-8 mb-10 border border-gray-100 shadow-sm">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <h3 class="font-serif text-lg text-charcoal mb-4">Deja tu reseña</h3>
                        <form action="<?php echo e(app_url('products/addReview/' . $product['id'])); ?>" method="POST" class="flex flex-col gap-4">
                            <div class="flex flex-col md:flex-row gap-4">
                                <div class="w-full md:w-1/3">
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Calificación</label>
                                    <select name="calificacion" required class="w-full border border-gray-200 py-3 px-4 text-sm outline-none focus:border-coral text-charcoal bg-gray-50">
                                        <option value="">Selecciona...</option>
                                        <option value="5">5 - Excelente</option>
                                        <option value="4">4 - Muy bueno</option>
                                        <option value="3">3 - Bueno</option>
                                        <option value="2">2 - Regular</option>
                                        <option value="1">1 - Malo</option>
                                    </select>
                                </div>
                                <div class="w-full md:w-2/3">
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Título</label>
                                    <input type="text" name="titulo" maxlength="150" class="w-full border border-gray-200 py-3 px-4 text-sm outline-none focus:border-coral text-charcoal bg-gray-50">
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Comentario</label>
                                <textarea name="comentario" rows="3" class="w-full border border-gray-200 py-3 px-4 text-sm outline-none focus:border-coral text-charcoal bg-gray-50 resize-y"></textarea>
                            </div>
                            <div class="mt-2 text-right">
                                <button type="submit" class="bg-charcoal hover:bg-coral text-white font-bold uppercase tracking-widest text-xs px-8 py-3 transition-colors">Enviar Reseña</button>
                            </div>
                        </form>
                    <?php else: ?>
                        <div class="text-center py-6">
                            <p class="text-charcoal-light mb-4">¿Te gustó este arreglo? Inicia sesión para compartir tu experiencia.</p>
                            <a href="<?php echo e(app_url('user/login')); ?>" class="bg-coral text-white px-6 py-2 text-xs font-bold uppercase tracking-widest hover:bg-coral-hover transition-colors inline-block">Iniciar Sesión</a>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Review List -->
                <div class="space-y-6">
                    <?php foreach ($data['reviews'] as $review): ?>
                        <article class="bg-white p-6 border border-gray-100 flex flex-col gap-3">
                            <div class="flex items-center justify-between border-b border-gray-50 pb-3">
                                <div>
                                    <strong class="text-charcoal text-sm font-bold"><?php echo e($review['nombre'] . ' ' . $review['apellido']); ?></strong>
                                    <div class="flex items-center gap-0.5 mt-1">
                                        <?php for ($i = 0; $i < 5; $i++): ?>
                                            <i data-lucide="star" class="w-3.5 h-3.5 <?php echo $i < (int)$review['calificacion'] ? 'fill-coral text-coral' : 'text-gray-200'; ?>"></i>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                                <span class="text-xs text-gray-400 font-medium"><?php echo date('d M Y', strtotime($review['created_at'])); ?></span>
                            </div>
                            <h4 class="font-serif text-charcoal text-lg"><?php echo e($review['titulo']); ?></h4>
                            <p class="text-charcoal-light text-sm leading-relaxed"><?php echo nl2br(e($review['comentario'])); ?></p>
                        </article>
                    <?php endforeach; ?>

                    <?php if (!$data['reviews']): ?>
                        <div class="text-center py-10 bg-white border border-gray-100">
                            <i data-lucide="message-square" class="w-10 h-10 text-gray-200 mx-auto mb-3"></i>
                            <p class="text-gray-400 font-medium text-sm">Todavía no hay reseñas publicadas. ¡Sé el primero!</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Related Products -->
            <?php if (!empty($data['related'])): ?>
                <div class="w-1-3-safe">
                    <h2 class="font-serif text-xl text-charcoal mb-8 border-b border-gray-200 pb-4">Te podría gustar</h2>
                    <div class="flex flex-col gap-6">
                        <?php foreach ($data['related'] as $related): ?>
                            <?php if ((int)$related['id'] === (int)$product['id']) { continue; } ?>
                            <a href="<?php echo e(app_url('products/detail/' . $related['id'])); ?>" class="group flex gap-4 bg-white p-3 border border-gray-100 hover:border-coral transition-colors">
                                <div class="w-20 h-24 bg-gray-50 shrink-0 overflow-hidden">
                                    <img src="<?php echo e(product_image($related['imagen_principal'])); ?>" alt="<?php echo e($related['nombre']); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                </div>
                                <div class="flex flex-col justify-center">
                                    <h4 class="font-serif text-charcoal group-hover:text-coral transition-colors text-sm mb-1"><?php echo e($related['nombre']); ?></h4>
                                    <span class="text-coral font-bold text-sm"><?php echo money($related['precio_actual'] ?? $related['precio_unitario']); ?></span>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
            
        </div>
    </div>
</div>
