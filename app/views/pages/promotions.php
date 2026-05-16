<?php /** @var array $data */ ?>
<?php $promoHeroImg = 'https://images.unsplash.com/photo-1487530811176-3780de880c2d?q=80&w=1000&auto=format&fit=crop'; ?>
<!-- HERO -->
<section class="relative bg-blush-50 overflow-hidden">
    <div class="max-w-7xl mx-auto flex-safe min-h-[420px]">
        <div class="w-1-2-safe flex flex-col justify-center px-8 md:px-16 py-20 relative z-10" id="promo-hero-content">
            <div class="relative z-10">
                <span class="font-script text-coral text-3xl mb-2">Promociones</span>
                <h1 class="text-4xl md:text-5xl font-serif text-charcoal mb-6 leading-tight">
                    Ofertas que <span class="italic">Enamoran</span>
                </h1>
                <p class="text-charcoal-light text-sm mb-8 max-w-md leading-relaxed">
                    Aprovecha nuestros descuentos exclusivos y lleva la frescura de nuestras flores a un precio especial.
                </p>
                <a href="<?php echo e(app_url('products')); ?>" class="bg-coral hover:bg-coral-hover text-white px-8 py-3.5 text-xs font-bold uppercase tracking-widest transition-colors inline-flex items-center gap-2 self-start">
                    <i data-lucide="shopping-bag" class="w-4 h-4"></i> Ver Todo
                </a>
            </div>
        </div>
        <div class="w-1-2-safe relative min-h-[350px] mobile-hide">
            <img src="<?php echo $promoHeroImg; ?>" alt="Ofertas Florales" class="absolute inset-0 w-full h-full object-cover">
        </div>
    </div>
</section>

<style>
    @media (max-width: 767px) {
        #promo-hero-content {
            background-image: linear-gradient(rgba(255, 245, 240, 0.85), rgba(255, 245, 240, 0.85)), url('<?php echo $promoHeroImg; ?>');
            background-size: cover;
            background-position: center;
        }
    }
</style>

<!-- ACTIVE CAMPAIGN BANNER -->
<?php if (!empty($data['campaign'])): ?>
<section class="max-w-7xl mx-auto px-6 py-12">
    <div class="bg-blush-50 flex flex-col md:flex-row items-center overflow-hidden">
        <!-- Text -->
        <div class="w-full md:w-1/2 p-8 md:p-12">
            <span class="font-script text-coral text-4xl block mb-2">¡Date Prisa!</span>
            <h2 class="font-serif text-3xl md:text-4xl text-charcoal mb-4"><?php echo e($data['campaign']['hero_title']); ?></h2>
            <p class="text-charcoal-light text-sm mb-6 max-w-lg leading-relaxed"><?php echo e($data['campaign']['hero_subtitle']); ?></p>
            
            <!-- Coupon code -->
            <div class="inline-flex items-center bg-white border border-gray-100 overflow-hidden self-start">
                <span class="px-5 py-3 text-xs font-bold uppercase tracking-widest text-charcoal-light">Código:</span>
                <span class="bg-coral text-white px-6 py-3 font-bold tracking-[0.2em] text-sm">
                    <?php echo strtoupper(str_replace(' ', '', $data['campaign']['campaign_name'])); ?>
                </span>
            </div>
        </div>
        
        <!-- Image -->
        <div class="w-full md:w-1/2 relative min-h-[300px]">
            <img src="<?php echo e($data['campaign']['hero_image_url'] ?? 'https://images.unsplash.com/photo-1520763185298-1b434c919102?w=800'); ?>" 
                 class="absolute inset-0 w-full h-full object-cover">
        </div>
    </div>
</section>
<?php endif; ?>

<!-- PRODUCTS ON SALE -->
<section class="max-w-7xl mx-auto px-6 py-12">
    <div class="text-center mb-10">
        <span class="font-script text-coral text-3xl block mb-2">Descuentos</span>
        <h2 class="font-serif text-3xl text-charcoal mb-2">Flores con Descuento</h2>
        <p class="text-charcoal-light text-sm"><?php echo count($data['products']); ?> productos en oferta</p>
    </div>

    <?php if (count($data['products']) > 0): ?>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
            <?php foreach ($data['products'] as $product): ?>
                <?php include __DIR__ . '/../_partials/product_card.php'; ?>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="text-center py-20 bg-blush-50 border border-gray-100">
            <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-6 text-coral">
                <i data-lucide="tag" class="w-8 h-8"></i>
            </div>
            <h3 class="font-serif text-2xl text-charcoal mb-2">No hay ofertas activas</h3>
            <p class="text-charcoal-light mb-6 text-sm">Vuelve pronto para descubrir nuevas promociones.</p>
            <a href="<?php echo e(app_url('products')); ?>" class="bg-coral hover:bg-coral-hover text-white px-8 py-3.5 text-xs font-bold uppercase tracking-widest transition-colors inline-flex items-center gap-2">
                Ver Catálogo
            </a>
        </div>
    <?php endif; ?>
</section>
