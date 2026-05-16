<?php $aboutHeroImg = 'https://images.unsplash.com/photo-1490750967868-88aa4486c946?q=80&w=1000&auto=format&fit=crop'; ?>
<!-- HERO -->
<section class="relative bg-blush-50 overflow-hidden">
    <div class="max-w-7xl mx-auto flex-safe min-h-[420px]">
        <div class="w-1-2-safe flex flex-col justify-center px-8 md:px-16 py-20 relative z-10" id="about-hero-content">
            <div class="relative z-10">
                <span class="font-script text-coral text-3xl mb-2">Nuestra Historia</span>
                <h1 class="text-4xl md:text-5xl font-serif text-charcoal mb-6 leading-tight">
                    Cultivando <span class="italic text-coral">Arte</span> y Emociones
                </h1>
                <p class="text-charcoal-light text-sm mb-8 max-w-md leading-relaxed">
                    Desde 2010, transformamos la naturaleza en mensajes inolvidables, cuidando cada detalle con la delicadeza que solo un pétalo merece.
                </p>
                <a href="<?php echo e(app_url('products')); ?>" class="bg-coral hover:bg-coral-hover text-white px-8 py-3.5 text-xs font-bold uppercase tracking-widest transition-colors inline-flex items-center gap-2 self-start">
                    <i data-lucide="shopping-bag" class="w-4 h-4"></i> Ver Catálogo
                </a>
            </div>
        </div>
        <div class="w-1-2-safe relative min-h-[350px] mobile-hide">
            <img src="<?php echo $aboutHeroImg; ?>" alt="Flores" class="absolute inset-0 w-full h-full object-cover">
        </div>
    </div>
</section>

<style>
    @media (max-width: 767px) {
        #about-hero-content {
            background-image: linear-gradient(rgba(255, 245, 240, 0.85), rgba(255, 245, 240, 0.85)), url('<?php echo $aboutHeroImg; ?>');
            background-size: cover;
            background-position: center;
        }
    }
</style>

<!-- TRUST BADGES -->
<section class="border-y border-gray-100 py-10">
    <div class="max-w-7xl mx-auto px-6 grid grid-cols-2 md:grid-cols-4 gap-8">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 bg-blush-50 rounded-full flex items-center justify-center shrink-0">
                <i data-lucide="leaf" class="w-6 h-6 text-coral"></i>
            </div>
            <div>
                <h4 class="font-bold text-sm text-charcoal">100% Frescas</h4>
                <p class="text-xs text-charcoal-light">Directo del campo</p>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 bg-blush-50 rounded-full flex items-center justify-center shrink-0">
                <i data-lucide="award" class="w-6 h-6 text-coral"></i>
            </div>
            <div>
                <h4 class="font-bold text-sm text-charcoal">15 Años</h4>
                <p class="text-xs text-charcoal-light">De trayectoria</p>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 bg-blush-50 rounded-full flex items-center justify-center shrink-0">
                <i data-lucide="heart" class="w-6 h-6 text-coral"></i>
            </div>
            <div>
                <h4 class="font-bold text-sm text-charcoal">Hecho con Amor</h4>
                <p class="text-xs text-charcoal-light">Diseño artesanal</p>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 bg-blush-50 rounded-full flex items-center justify-center shrink-0">
                <i data-lucide="truck" class="w-6 h-6 text-coral"></i>
            </div>
            <div>
                <h4 class="font-bold text-sm text-charcoal">Envío Rápido</h4>
                <p class="text-xs text-charcoal-light">En el mismo día</p>
            </div>
        </div>
    </div>
</section>

<!-- OUR STORY -->
<section class="py-24 border-y" style="background-color: #FDF9F8; border-color: #F2E8E6;">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex-safe items-center gap-16">
            <!-- Image -->
            <div class="w-1-2-safe relative group">
                <div class="absolute -inset-4 bg-white/50 blur-xl opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1520763185298-1b434c919102?q=80&w=800&auto=format&fit=crop" alt="Florista trabajando" class="w-full h-auto object-cover aspect-[4/5] rounded-xl shadow-sm">
                    <!-- Stats overlay -->
                    <div class="absolute -bottom-6 -right-6 bg-white p-6 shadow-card rounded-2xl">
                        <div class="flex items-center gap-8">
                            <div class="text-center">
                                <span class="text-4xl font-serif font-bold text-coral block mb-1">15</span>
                                <span class="text-[10px] uppercase tracking-widest text-charcoal-light font-bold">Años</span>
                            </div>
                            <div class="w-px h-12 bg-gray-100"></div>
                            <div class="text-center">
                                <span class="text-4xl font-serif font-bold text-coral block mb-1">10k+</span>
                                <span class="text-[10px] uppercase tracking-widest text-charcoal-light font-bold">Clientes</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Content -->
            <div class="w-1-2-safe lg:pl-8">
                <span class="text-coral font-bold text-[10px] uppercase tracking-[0.3em] mb-4 block">Legado & Pasión</span>
                <h2 class="text-3xl md:text-5xl font-serif text-charcoal mb-8 leading-tight">Más de una década creando <span class="italic">momentos mágicos</span></h2>
                
                <div class="space-y-6 text-charcoal-light leading-relaxed text-sm mb-10">
                    <p>
                        En <strong class="text-charcoal"><?php echo e(APP_NAME); ?></strong>, entendemos que cada flor cuenta una historia. Lo que comenzó como un sueño en un pequeño taller, hoy es una florería boutique reconocida por su excelencia y diseño vanguardista.
                    </p>
                    <p>
                        No solo vendemos flores, diseñamos experiencias. Nuestra filosofía se basa en el respeto por la naturaleza y la búsqueda constante de la perfección estética para cada uno de nuestros clientes.
                    </p>
                </div>
                
                <a href="<?php echo e(app_url('contact')); ?>" class="bg-charcoal hover:bg-coral text-white px-8 py-4 text-xs font-bold uppercase tracking-widest transition-all inline-flex items-center gap-3 rounded-full shadow-sm">
                    Contáctanos <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- VALUES -->
<section class="bg-blush-50 py-20">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-14">
            <span class="font-script text-coral text-3xl block mb-2">Filosofía</span>
            <h2 class="text-3xl font-serif text-charcoal">Valores que nos definen</h2>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 md:gap-8">
            <div class="bg-white p-8 group hover:shadow-card transition-all flex items-start text-left gap-6 border border-gray-100 rounded-2xl">
                <div class="w-14 h-14 shrink-0 bg-blush-50 rounded-full flex items-center justify-center group-hover:bg-coral group-hover:text-white transition-colors text-coral shadow-sm">
                    <i data-lucide="sparkles" class="w-6 h-6"></i>
                </div>
                <div>
                    <h3 class="font-serif text-xl text-charcoal mb-2">Frescura Absoluta</h3>
                    <p class="text-charcoal-light text-sm leading-relaxed">Seleccionamos flores locales, garantizando vitalidad y esplendor natural en cada entrega.</p>
                </div>
            </div>

            <div class="bg-white p-8 group hover:shadow-card transition-all flex items-start text-left gap-6 border border-gray-100 rounded-2xl">
                <div class="w-14 h-14 shrink-0 bg-blush-50 rounded-full flex items-center justify-center group-hover:bg-coral group-hover:text-white transition-colors text-coral shadow-sm">
                    <i data-lucide="palette" class="w-6 h-6"></i>
                </div>
                <div>
                    <h3 class="font-serif text-xl text-charcoal mb-2">Artesanía Pura</h3>
                    <p class="text-charcoal-light text-sm leading-relaxed">Cada florista es un maestro, convirtiendo tallos en poemas visuales inolvidables.</p>
                </div>
            </div>

            <div class="bg-white p-8 group hover:shadow-card transition-all flex items-start text-left gap-6 border border-gray-100 rounded-2xl">
                <div class="w-14 h-14 shrink-0 bg-blush-50 rounded-full flex items-center justify-center group-hover:bg-coral group-hover:text-white transition-colors text-coral shadow-sm">
                    <i data-lucide="heart" class="w-6 h-6"></i>
                </div>
                <div>
                    <h3 class="font-serif text-xl text-charcoal mb-2">Alma & Pasión</h3>
                    <p class="text-charcoal-light text-sm leading-relaxed">Ponemos el corazón en cada detalle. Tu satisfacción es nuestra principal razón de ser.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-20 bg-white text-center px-6">
    <div class="max-w-3xl mx-auto">
        <span class="font-script text-coral text-4xl block mb-4">¿Listo?</span>
        <h2 class="text-3xl md:text-4xl font-serif text-charcoal mb-8">Crea tu propia historia floral</h2>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="<?php echo e(app_url('products')); ?>" class="bg-coral hover:bg-coral-hover text-white px-10 py-4 text-xs font-bold uppercase tracking-widest transition-colors">Explorar Catálogo</a>
            <a href="<?php echo e(app_url('contact')); ?>" class="border-2 border-charcoal text-charcoal hover:bg-charcoal hover:text-white px-10 py-4 text-xs font-bold uppercase tracking-widest transition-all">Contáctanos</a>
        </div>
    </div>
</section>
