<?php /** @var array $product */ ?>
<div class="group bg-white rounded-2xl shadow-sm hover:shadow-card transition-all overflow-hidden border border-[#F2E8E6] flex flex-col h-full text-center">
    <a href="<?php echo e(app_url('products/detail/' . $product['id'])); ?>" class="relative block aspect-square overflow-hidden" style="background-color: #FDF5F3;">
        <?php if (!empty($product['descuento_porcentaje']) && (float)$product['descuento_porcentaje'] > 0): ?>
            <span class="absolute top-3 left-3 bg-coral text-white text-[10px] font-bold uppercase px-2 py-1 z-10 rounded-sm shadow-sm">
                -<?php echo (int)$product['descuento_porcentaje']; ?>%
            </span>
        <?php endif; ?>
        
        <img src="<?php echo e(product_image($product['imagen_principal'])); ?>" alt="<?php echo e($product['nombre']); ?>" class="w-4/5 h-4/5 object-contain mx-auto mt-[10%] transition-transform duration-500 group-hover:scale-110">
        
        <!-- Hover Add to Cart Button -->
        <?php if ((int)$product['stock'] > 0): ?>
        <div class="absolute bottom-4 left-0 w-full px-4 flex justify-center opacity-0 group-hover:opacity-100 translate-y-4 group-hover:translate-y-0 transition-all duration-300">
            <form action="<?php echo e(app_url('cart/add/' . $product['id'])); ?>" method="POST" class="w-full">
                <input type="hidden" name="cantidad" value="1">
                <button class="w-full bg-white/90 backdrop-blur-sm text-coral text-xs font-bold uppercase tracking-widest py-3 rounded-lg hover:bg-coral hover:text-white shadow-soft transition-colors flex items-center justify-center gap-2" type="submit" title="Añadir al carrito">
                    <i data-lucide="shopping-bag" class="w-3.5 h-3.5"></i> Añadir
                </button>
            </form>
        </div>
        <?php else: ?>
        <div class="absolute bottom-4 left-0 w-full flex justify-center">
            <span class="bg-gray-200/90 backdrop-blur-sm text-gray-500 px-4 py-2 text-[10px] font-bold uppercase tracking-wider rounded-sm shadow-sm">Agotado</span>
        </div>
        <?php endif; ?>
    </a>
    
    <div class="p-5 flex flex-col flex-1">
        <?php if (!empty($product['categoria_nombre'])): ?>
            <span class="text-[9px] text-coral font-bold uppercase tracking-widest mb-1.5"><?php echo e($product['categoria_nombre']); ?></span>
        <?php endif; ?>
        
        <h3 class="text-sm font-serif font-bold text-charcoal group-hover:text-coral transition-colors mb-2 leading-snug">
            <a href="<?php echo e(app_url('products/detail/' . $product['id'])); ?>"><?php echo e($product['nombre']); ?></a>
        </h3>
        
        <div class="flex items-center justify-center gap-2 mt-auto">
            <?php if (!empty($product['descuento_porcentaje']) && (float)$product['descuento_porcentaje'] > 0): ?>
                <span class="text-gray-400 line-through text-xs"><?php echo money($product['precio_unitario']); ?></span>
                <span class="text-coral font-bold text-sm"><?php echo money($product['precio_actual']); ?></span>
            <?php else: ?>
                <span class="text-coral font-bold text-sm"><?php echo money($product['precio_unitario']); ?></span>
            <?php endif; ?>
        </div>
    </div>
</div>
