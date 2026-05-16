<?php /** @var array $data */ ?>
<?php 
    $heroImg = $data['campaign']['hero_image_url'] ?? asset_url('img/tulips.jpg');
    $heroBg = $data['campaign']['hero_bg_color'] ?? '#F5E6EB';

    // Función simple para convertir HEX a RGBA para el overlay móvil
    function hexToRgba($hex, $alpha = 0.85) {
        $hex = str_replace('#', '', $hex);
        if (strlen($hex) == 3) {
            $r = hexdec(str_repeat(substr($hex, 0, 1), 2));
            $g = hexdec(str_repeat(substr($hex, 1, 1), 2));
            $b = hexdec(str_repeat(substr($hex, 2, 1), 2));
        } else {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        }
        return "rgba($r, $g, $b, $alpha)";
    }
    $rgbaBg = hexToRgba($heroBg, 0.85);
?>
<!-- HERO SECTION -->
<section class="relative overflow-hidden" style="background-color: <?php echo $heroBg; ?>;">
    <div class="max-w-7xl mx-auto flex-safe min-h-[480px] md:min-h-[520px]">
        <!-- Left: Text -->
        <div class="w-1-2-safe flex flex-col justify-center px-8 md:px-16 py-20 relative z-20" id="hero-content-area">
            <div class="relative z-10">
                <div class="flex items-center gap-2 mb-3">
                    <span class="font-script text-coral text-3xl"><?php echo e($data['campaign']['campaign_name'] ?? 'Valentine Day'); ?></span>
                    <i data-lucide="heart" class="w-5 h-5 text-coral fill-current"></i>
                </div>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-serif text-charcoal mb-6 leading-tight">
                    <?php echo e($data['campaign']['hero_title'] ?? 'Refresca Tu Mente & Siente el Amor'); ?>
                </h1>
                <p class="text-charcoal-light text-sm mb-8 max-w-md"><?php echo e($data['campaign']['hero_subtitle'] ?? 'Oferta Exclusiva - 10% de descuento esta semana'); ?></p>
                <div class="flex flex-wrap gap-4">
                    <a href="<?php echo e(app_url('products')); ?>" class="bg-coral hover:bg-[#D93838] text-white px-8 py-3.5 text-sm font-bold transition-colors inline-flex items-center gap-2 shadow-sm">
                        <?php echo e($data['campaign']['hero_button_text'] ?? 'Order Now'); ?>
                    </a>
                    <a href="<?php echo e(app_url('about')); ?>" class="border border-coral text-coral hover:bg-coral hover:text-white px-8 py-3.5 text-sm font-bold transition-all bg-transparent">
                        Learn More
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Right: Image with blend effect (Hidden on Mobile, shown on Desktop) -->
        <div class="w-1-2-safe relative min-h-[350px] mobile-hide">
            <!-- Gradient to blend the image left edge with the background -->
            <div class="absolute inset-0 w-1/3 z-10" style="background: linear-gradient(to right, <?php echo $heroBg; ?>, transparent);"></div>
            <img src="<?php echo e($heroImg); ?>" alt="Flores Frescas" class="absolute inset-0 w-full h-full object-cover" onerror="this.src='https://images.unsplash.com/photo-1520763185298-1b434c919102?q=80&w=1000&auto=format&fit=crop';">
        </div>
    </div>
</section>

<style>
    @media (max-width: 767px) {
        #hero-content-area {
            background-image: linear-gradient(<?php echo $rgbaBg; ?>, <?php echo $rgbaBg; ?>), url('<?php echo $heroImg; ?>');
            background-size: cover;
            background-position: center;
        }
    }
</style>

<!-- TOP PRODUCTS ROW -->
<section class="max-w-7xl mx-auto px-6 py-16">
    <?php if (!empty($data['featured_products'])): ?>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-8">
        <?php foreach (array_slice($data['featured_products'], 0, 4) as $product): ?>
            <?php include __DIR__ . '/_partials/product_card.php'; ?>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</section>

<!-- CATEGORY BANNERS -->
<section class="py-20 border-y" style="background-color: #FFF5F0; border-color: #FDECE8;">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-10">
        <?php if (!empty($data['categories'])): ?>
        <?php $bannerCats = array_slice($data['categories'], 0, 2); ?>
        <?php foreach ($bannerCats as $cat): ?>
            <?php 
                $imgSrc = !empty($cat['imagen']) ? $cat['imagen'] : 'https://images.unsplash.com/photo-1563241527-3004b7be0ffd?w=400&q=80';
                if (!str_starts_with($imgSrc, 'http')) {
                    $imgSrc = asset_url('images/' . $imgSrc);
                }
            ?>
            <a href="<?php echo e(app_url('products', ['category' => $cat['id']])); ?>" class="relative group overflow-hidden flex items-center h-56 rounded-2xl shadow-sm hover:shadow-md transition-all" style="background-color: #FDF5F3;">
                <div class="relative z-10 p-10 w-full md:w-2/3">
                    <span class="block text-[10px] text-coral uppercase tracking-widest font-bold mb-2">Colección</span>
                    <h3 class="font-serif text-3xl text-charcoal mb-4"><?php echo e($cat['nombre']); ?></h3>
                    <span class="inline-flex items-center gap-2 bg-white text-coral text-xs font-bold uppercase tracking-wider px-6 py-3 rounded-full shadow-sm group-hover:bg-coral group-hover:text-white transition-colors">
                        Comprar Ahora <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                    </span>
                </div>
                <div class="absolute right-0 top-0 w-1/2 md:w-2/5 h-full opacity-60 group-hover:opacity-100 transition-opacity duration-500 mix-blend-multiply">
                    <img src="<?php echo e($imgSrc); ?>" onerror="this.src='https://images.unsplash.com/photo-1563241527-3004b7be0ffd?w=400&q=80';" class="w-full h-full object-cover">
                </div>
            </a>
        <?php endforeach; ?>
        <?php endif; ?>
        </div>
    </div>
</section>

<!-- TRUST BADGES -->
<section class="bg-white py-16">
    <div class="max-w-7xl mx-auto px-6 grid grid-cols-2 md:grid-cols-4 gap-8">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-full flex items-center justify-center shrink-0" style="background-color: #FFF5F0;">
                <i data-lucide="truck" class="w-6 h-6 text-coral"></i>
            </div>
            <div>
                <h4 class="font-bold text-sm text-charcoal">Envío Gratis</h4>
                <p class="text-xs text-charcoal-light">En pedidos +S/150</p>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-full flex items-center justify-center shrink-0" style="background-color: #FFF5F0;">
                <i data-lucide="headphones" class="w-6 h-6 text-coral"></i>
            </div>
            <div>
                <h4 class="font-bold text-sm text-charcoal">Soporte 24/7</h4>
                <p class="text-xs text-charcoal-light">Atención permanente</p>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-full flex items-center justify-center shrink-0" style="background-color: #FFF5F0;">
                <i data-lucide="refresh-cw" class="w-6 h-6 text-coral"></i>
            </div>
            <div>
                <h4 class="font-bold text-sm text-charcoal">Garantía Fresca</h4>
                <p class="text-xs text-charcoal-light">Flores siempre frescas</p>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-full flex items-center justify-center shrink-0" style="background-color: #FFF5F0;">
                <i data-lucide="percent" class="w-6 h-6 text-coral"></i>
            </div>
            <div>
                <h4 class="font-bold text-sm text-charcoal">Descuentos</h4>
                <p class="text-xs text-charcoal-light">Ofertas cada semana</p>
            </div>
        </div>
    </div>
</section>

<!-- PRODUCT TABS -->
<section class="py-20 border-t" style="background-color: #FDF5F3; border-color: #FCE1D8;">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-12">
            <span class="font-script text-coral text-3xl block mb-2">Colección</span>
            <h2 class="font-serif text-3xl text-charcoal mb-8">Nuestros Favoritos</h2>
            <div class="flex items-center justify-center gap-8 text-sm font-bold uppercase tracking-widest">
                <button class="product-tab active text-coral border-b-2 border-coral pb-2 transition-colors" data-tab="latest">Últimos Productos</button>
                <button class="product-tab text-charcoal-light hover:text-coral pb-2 border-b-2 border-transparent transition-colors" data-tab="bestselling">Más Vendidos</button>
                <button class="product-tab text-charcoal-light hover:text-coral pb-2 border-b-2 border-transparent transition-colors" data-tab="featured">Destacados</button>
            </div>
        </div>

        <!-- Latest -->
        <div id="tab-latest" class="tab-content">
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
                <?php foreach (array_slice($data['featured_products'], 0, 8) as $product): ?>
                    <?php include __DIR__ . '/_partials/product_card.php'; ?>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Best Selling -->
        <div id="tab-bestselling" class="tab-content hidden">
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
                <?php foreach (array_slice($data['best_selling'] ?? [], 0, 8) as $product): ?>
                    <?php include __DIR__ . '/_partials/product_card.php'; ?>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Featured -->
        <div id="tab-featured" class="tab-content hidden">
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
                <?php foreach (array_slice($data['on_sale'] ?? [], 0, 8) as $product): ?>
                    <?php include __DIR__ . '/_partials/product_card.php'; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<!-- BLOSSOM BOUQUET SHOWCASE -->
<section class="bg-blush-50">
    <div class="max-w-7xl mx-auto flex flex-col lg:flex-row min-h-[450px]">
        <div class="w-full lg:w-1/2 relative min-h-[300px]">
            <?php $showcaseProduct = $data['featured_products'][0] ?? null; ?>
            <?php if ($showcaseProduct): ?>
                <img src="<?php echo e(product_image($showcaseProduct['imagen_principal'])); ?>" alt="Bouquet Destacado" class="absolute inset-0 w-full h-full object-cover">
            <?php endif; ?>
        </div>
        <div class="w-full lg:w-1/2 flex flex-col justify-center px-8 lg:px-16 py-12">
            <span class="text-xs text-coral uppercase tracking-widest font-bold mb-2">Colección Especial</span>
            <h2 class="font-serif text-3xl md:text-4xl text-charcoal mb-4 leading-tight">Bouquet de Flores Frescas</h2>
            <p class="text-charcoal-light text-sm leading-relaxed mb-8 max-w-md">
                Descubre nuestra colección exclusiva de bouquets artesanales. Cada arreglo está diseñado con amor, usando las flores más frescas y de la mejor calidad para hacer de cada momento algo inolvidable.
            </p>
            <a href="<?php echo e(app_url('products')); ?>" class="bg-coral hover:bg-coral-hover text-white px-8 py-3.5 text-xs font-bold uppercase tracking-widest transition-colors inline-flex items-center gap-2 self-start">
                <i data-lucide="eye" class="w-4 h-4"></i> Ver Colección
            </a>
        </div>
    </div>
</section>

<!-- SMALL PRODUCT CARDS ROW -->
<?php if (!empty($data['best_selling'])): ?>
<section class="max-w-7xl mx-auto px-6 py-12">
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        <?php foreach (array_slice($data['best_selling'], 0, 3) as $i => $prod): ?>
            <a href="<?php echo e(app_url('products/detail/' . $prod['id'])); ?>" class="group flex items-center gap-4 bg-blush-50 p-5 hover:shadow-card transition-all">
                <div class="w-24 h-24 bg-white rounded shrink-0 overflow-hidden flex items-center justify-center">
                    <img src="<?php echo e(product_image($prod['imagen_principal'])); ?>" alt="<?php echo e($prod['nombre']); ?>" class="w-20 h-20 object-contain group-hover:scale-110 transition-transform duration-500">
                </div>
                <div>
                    <span class="text-xs text-coral font-bold uppercase tracking-wider"><?php echo e($prod['categoria_nombre']); ?></span>
                    <h4 class="font-serif text-charcoal group-hover:text-coral transition-colors"><?php echo e($prod['nombre']); ?></h4>
                    <p class="text-coral font-bold text-sm mt-1"><?php echo money($prod['precio_actual']); ?></p>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<!-- HOT DEAL BANNER -->
<section class="bg-white border-y border-gray-100 py-16">
    <div class="max-w-7xl mx-auto px-6">
        <div class="bg-blush-50 p-8 md:p-12 flex flex-col md:flex-row items-center gap-8">
            <div class="flex-1 text-center md:text-left">
                <span class="font-script text-coral text-4xl block mb-2">¡Date Prisa!</span>
                <h2 class="font-serif text-3xl md:text-4xl text-charcoal mb-4">Oferta Especial <span class="text-coral">Hasta 20% Off</span></h2>
                <p class="text-charcoal-light text-sm mb-6 max-w-lg">
                    Aprovecha nuestras ofertas de temporada. Arreglos florales seleccionados con descuento exclusivo por tiempo limitado.
                </p>
                <!-- Countdown -->
                <div class="flex items-center justify-center md:justify-start gap-4 mb-8">
                    <div class="w-16 h-16 bg-white shadow-sm flex flex-col items-center justify-center">
                        <span id="countdown-days" class="text-xl font-serif font-bold text-charcoal">12</span>
                        <span class="text-[9px] uppercase tracking-widest text-charcoal-light">Días</span>
                    </div>
                    <div class="w-16 h-16 bg-white shadow-sm flex flex-col items-center justify-center">
                        <span id="countdown-hours" class="text-xl font-serif font-bold text-charcoal">08</span>
                        <span class="text-[9px] uppercase tracking-widest text-charcoal-light">Horas</span>
                    </div>
                    <div class="w-16 h-16 bg-white shadow-sm flex flex-col items-center justify-center">
                        <span id="countdown-mins" class="text-xl font-serif font-bold text-charcoal">45</span>
                        <span class="text-[9px] uppercase tracking-widest text-charcoal-light">Min</span>
                    </div>
                    <div class="w-16 h-16 bg-white shadow-sm flex flex-col items-center justify-center">
                        <span id="countdown-secs" class="text-xl font-serif font-bold text-charcoal">30</span>
                        <span class="text-[9px] uppercase tracking-widest text-charcoal-light">Seg</span>
                    </div>
                </div>
                <a href="<?php echo e(app_url('promotions')); ?>" class="bg-coral hover:bg-coral-hover text-white px-8 py-3.5 text-xs font-bold uppercase tracking-widest transition-colors inline-flex items-center gap-2">
                    Comprar Ahora <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>
            <!-- Hot Deal Product -->
            <div class="shrink-0">
                <?php if (!empty($data['featured_products'])): ?>
                <?php $hotProduct = $data['featured_products'][0]; ?>
                <div class="relative w-64 h-64 bg-white rounded-full flex items-center justify-center shadow-soft">
                    <div class="absolute inset-3 border-2 border-dashed border-coral/20 rounded-full"></div>
                    <img src="<?php echo e(product_image($hotProduct['imagen_principal'])); ?>" alt="<?php echo e($hotProduct['nombre']); ?>" class="w-3/4 h-3/4 object-contain relative z-10">
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- TESTIMONIALS -->
<section class="max-w-7xl mx-auto px-6 py-24 border-t border-gray-100">
    <div class="text-center mb-16">
        <span class="font-script text-coral text-4xl block mb-3">Testimonios</span>
        <h2 class="font-serif text-3xl md:text-4xl text-charcoal mb-4">Historias de nuestros clientes</h2>
        <p class="text-charcoal-light text-sm max-w-lg mx-auto leading-relaxed">
            Descubre cómo hemos ayudado a crear momentos mágicos e inolvidables a través de nuestras flores.
        </p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8">
        <!-- Review 1 -->
        <div class="bg-white p-8 border border-gray-100 rounded-2xl shadow-sm hover:shadow-card transition-all flex items-start gap-5 relative group">
            <div class="w-12 h-12 shrink-0 bg-blush-50 rounded-full flex items-center justify-center text-coral font-serif font-bold text-xl shadow-sm group-hover:bg-coral group-hover:text-white transition-colors">M</div>
            <div class="flex-1">
                <div class="flex justify-between items-start mb-2">
                    <div>
                        <h4 class="font-bold text-xs uppercase tracking-wider text-charcoal mb-1">María Fernández</h4>
                        <div class="flex items-center gap-1 text-coral mb-3">
                            <i data-lucide="star" class="w-3.5 h-3.5 fill-current"></i>
                            <i data-lucide="star" class="w-3.5 h-3.5 fill-current"></i>
                            <i data-lucide="star" class="w-3.5 h-3.5 fill-current"></i>
                            <i data-lucide="star" class="w-3.5 h-3.5 fill-current"></i>
                            <i data-lucide="star" class="w-3.5 h-3.5 fill-current"></i>
                        </div>
                    </div>
                    <i data-lucide="quote" class="w-6 h-6 text-coral/10 group-hover:text-coral/30 transition-colors"></i>
                </div>
                <p class="text-charcoal-light text-sm italic leading-relaxed mb-3">
                    "¡Increíble servicio! Pedí un arreglo para mi aniversario y llegó exactamente como en la foto. Las flores súper frescas y el diseño hermoso."
                </p>
                <span class="text-[10px] text-gray-400 font-medium uppercase tracking-wider">Cliente Verificado</span>
            </div>
        </div>
        
        <!-- Review 2 -->
        <div class="bg-white p-8 border border-gray-100 rounded-2xl shadow-sm hover:shadow-card transition-all flex items-start gap-5 relative group">
            <div class="w-12 h-12 shrink-0 bg-blush-50 rounded-full flex items-center justify-center text-coral font-serif font-bold text-xl shadow-sm group-hover:bg-coral group-hover:text-white transition-colors">C</div>
            <div class="flex-1">
                <div class="flex justify-between items-start mb-2">
                    <div>
                        <h4 class="font-bold text-xs uppercase tracking-wider text-charcoal mb-1">Carlos Gómez</h4>
                        <div class="flex items-center gap-1 text-coral mb-3">
                            <i data-lucide="star" class="w-3.5 h-3.5 fill-current"></i>
                            <i data-lucide="star" class="w-3.5 h-3.5 fill-current"></i>
                            <i data-lucide="star" class="w-3.5 h-3.5 fill-current"></i>
                            <i data-lucide="star" class="w-3.5 h-3.5 fill-current"></i>
                            <i data-lucide="star" class="w-3.5 h-3.5 fill-current"></i>
                        </div>
                    </div>
                    <i data-lucide="quote" class="w-6 h-6 text-coral/10 group-hover:text-coral/30 transition-colors"></i>
                </div>
                <p class="text-charcoal-light text-sm italic leading-relaxed mb-3">
                    "La calidad de los tulipanes es excepcional. Compré un ramo para el Día de la Madre y le duraron muchísimo. El detalle de la tarjeta fue perfecto."
                </p>
                <span class="text-[10px] text-gray-400 font-medium uppercase tracking-wider">Cliente Verificado</span>
            </div>
        </div>

        <!-- Review 3 -->
        <div class="bg-white p-8 border border-gray-100 rounded-2xl shadow-sm hover:shadow-card transition-all flex items-start gap-5 relative group">
            <div class="w-12 h-12 shrink-0 bg-blush-50 rounded-full flex items-center justify-center text-coral font-serif font-bold text-xl shadow-sm group-hover:bg-coral group-hover:text-white transition-colors">L</div>
            <div class="flex-1">
                <div class="flex justify-between items-start mb-2">
                    <div>
                        <h4 class="font-bold text-xs uppercase tracking-wider text-charcoal mb-1">Lucía Silva</h4>
                        <div class="flex items-center gap-1 text-coral mb-3">
                            <i data-lucide="star" class="w-3.5 h-3.5 fill-current"></i>
                            <i data-lucide="star" class="w-3.5 h-3.5 fill-current"></i>
                            <i data-lucide="star" class="w-3.5 h-3.5 fill-current"></i>
                            <i data-lucide="star" class="w-3.5 h-3.5 fill-current"></i>
                            <i data-lucide="star" class="w-3.5 h-3.5"></i>
                        </div>
                    </div>
                    <i data-lucide="quote" class="w-6 h-6 text-coral/10 group-hover:text-coral/30 transition-colors"></i>
                </div>
                <p class="text-charcoal-light text-sm italic leading-relaxed mb-3">
                    "Muy buena atención. Tuvieron un pequeño retraso por el tráfico, pero me avisaron a tiempo. Las orquídeas están preciosas y muy bien cuidadas."
                </p>
                <span class="text-[10px] text-gray-400 font-medium uppercase tracking-wider">Cliente Verificado</span>
            </div>
        </div>
    </div>
</section>

<!-- INSTAGRAM GALLERY -->
<section class="py-24 bg-white border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex flex-col items-center justify-center mb-16 text-center">
            <i data-lucide="instagram" class="w-8 h-8 text-coral mb-6"></i>
            <h2 class="font-serif text-3xl md:text-4xl text-charcoal mb-4">Síguenos en Instagram</h2>
            <a href="#" class="text-xs font-bold uppercase tracking-widest text-gray-500 hover:text-coral transition-colors border-b border-transparent hover:border-coral pb-1">
                @tienda_floreria
            </a>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-8">
            <!-- Item 1 -->
            <a href="#" class="relative group aspect-square overflow-hidden rounded-xl bg-blush-50 transition-all duration-300">
                <img src="https://images.unsplash.com/photo-1562690868-60bbe7293e94?q=80&w=600&auto=format&fit=crop" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                <div class="absolute inset-0 bg-white/85 backdrop-blur-[2px] opacity-0 group-hover:opacity-100 transition-all duration-400 flex flex-col items-center justify-center text-charcoal">
                    <i data-lucide="instagram" class="w-6 h-6 mb-4 transform translate-y-2 group-hover:translate-y-0 transition-transform duration-400"></i>
                    <div class="flex items-center gap-5 text-xs font-bold tracking-widest transform translate-y-2 group-hover:translate-y-0 transition-transform duration-400 delay-75">
                        <span class="flex items-center gap-1.5"><i data-lucide="heart" class="w-4 h-4 fill-charcoal text-charcoal"></i> 342</span>
                        <span class="flex items-center gap-1.5"><i data-lucide="message-circle" class="w-4 h-4 fill-charcoal text-charcoal"></i> 28</span>
                    </div>
                </div>
            </a>
            
            <!-- Item 2 -->
            <a href="#" class="relative group aspect-square overflow-hidden rounded-xl bg-blush-50 transition-all duration-300">
                <img src="https://images.unsplash.com/photo-1496062031456-07b8f162a322?q=80&w=600&auto=format&fit=crop" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                <div class="absolute inset-0 bg-white/85 backdrop-blur-[2px] opacity-0 group-hover:opacity-100 transition-all duration-400 flex flex-col items-center justify-center text-charcoal">
                    <i data-lucide="instagram" class="w-6 h-6 mb-4 transform translate-y-2 group-hover:translate-y-0 transition-transform duration-400"></i>
                    <div class="flex items-center gap-5 text-xs font-bold tracking-widest transform translate-y-2 group-hover:translate-y-0 transition-transform duration-400 delay-75">
                        <span class="flex items-center gap-1.5"><i data-lucide="heart" class="w-4 h-4 fill-charcoal text-charcoal"></i> 124</span>
                        <span class="flex items-center gap-1.5"><i data-lucide="message-circle" class="w-4 h-4 fill-charcoal text-charcoal"></i> 12</span>
                    </div>
                </div>
            </a>

            <!-- Item 3 -->
            <a href="#" class="relative group aspect-square overflow-hidden rounded-xl bg-blush-50 transition-all duration-300">
                <img src="https://images.unsplash.com/photo-1520763185298-1b434c919102?q=80&w=600&auto=format&fit=crop" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                <div class="absolute inset-0 bg-white/85 backdrop-blur-[2px] opacity-0 group-hover:opacity-100 transition-all duration-400 flex flex-col items-center justify-center text-charcoal">
                    <i data-lucide="instagram" class="w-6 h-6 mb-4 transform translate-y-2 group-hover:translate-y-0 transition-transform duration-400"></i>
                    <div class="flex items-center gap-5 text-xs font-bold tracking-widest transform translate-y-2 group-hover:translate-y-0 transition-transform duration-400 delay-75">
                        <span class="flex items-center gap-1.5"><i data-lucide="heart" class="w-4 h-4 fill-charcoal text-charcoal"></i> 89</span>
                        <span class="flex items-center gap-1.5"><i data-lucide="message-circle" class="w-4 h-4 fill-charcoal text-charcoal"></i> 5</span>
                    </div>
                </div>
            </a>

            <!-- Item 4 -->
            <a href="#" class="relative group aspect-square overflow-hidden rounded-xl bg-blush-50 transition-all duration-300">
                <img src="https://images.unsplash.com/photo-1560790671-b76ca4de55ef?q=80&w=600&auto=format&fit=crop" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                <div class="absolute inset-0 bg-white/85 backdrop-blur-[2px] opacity-0 group-hover:opacity-100 transition-all duration-400 flex flex-col items-center justify-center text-charcoal">
                    <i data-lucide="instagram" class="w-6 h-6 mb-4 transform translate-y-2 group-hover:translate-y-0 transition-transform duration-400"></i>
                    <div class="flex items-center gap-5 text-xs font-bold tracking-widest transform translate-y-2 group-hover:translate-y-0 transition-transform duration-400 delay-75">
                        <span class="flex items-center gap-1.5"><i data-lucide="heart" class="w-4 h-4 fill-charcoal text-charcoal"></i> 215</span>
                        <span class="flex items-center gap-1.5"><i data-lucide="message-circle" class="w-4 h-4 fill-charcoal text-charcoal"></i> 18</span>
                    </div>
                </div>
            </a>
        </div>
    </div>
</section>

<!-- Product Tabs & Countdown Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tabs
    document.querySelectorAll('.product-tab').forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.product-tab').forEach(function(b) {
                b.classList.remove('active', 'text-coral', 'border-coral');
                b.classList.add('text-charcoal-light', 'border-transparent');
            });
            this.classList.add('active', 'text-coral', 'border-coral');
            this.classList.remove('text-charcoal-light', 'border-transparent');
            document.querySelectorAll('.tab-content').forEach(function(c) { c.classList.add('hidden'); });
            document.getElementById('tab-' + this.dataset.tab).classList.remove('hidden');
        });
    });

    // Countdown (12 days from now)
    var end = new Date();
    end.setDate(end.getDate() + 12);
    function updateCountdown() {
        var now = new Date(), diff = end - now;
        if (diff <= 0) return;
        var d = Math.floor(diff / 86400000);
        var h = Math.floor((diff % 86400000) / 3600000);
        var m = Math.floor((diff % 3600000) / 60000);
        var s = Math.floor((diff % 60000) / 1000);
        var el = document.getElementById('countdown-days'); if(el) el.textContent = d < 10 ? '0'+d : d;
        el = document.getElementById('countdown-hours'); if(el) el.textContent = h < 10 ? '0'+h : h;
        el = document.getElementById('countdown-mins'); if(el) el.textContent = m < 10 ? '0'+m : m;
        el = document.getElementById('countdown-secs'); if(el) el.textContent = s < 10 ? '0'+s : s;
    }
    updateCountdown();
    setInterval(updateCountdown, 1000);
});
</script>
