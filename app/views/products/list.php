<?php /** @var array $data */ ?>
<div class="min-h-screen" style="background-color: #FDF9F8;">
    <!-- Page Header -->
    <section class="py-16 px-6 text-center border-b" style="background-color: #FFF5F0; border-color: #FDECE8;">
        <div class="max-w-4xl mx-auto">
            <span class="font-script text-coral text-3xl block mb-2">Descubre nuestra</span>
            <h1 class="text-4xl md:text-5xl font-serif text-charcoal mb-8">Colección de Temporada</h1>
            <form id="live-search-form" class="max-w-lg mx-auto relative mt-6" action="<?php echo e(app_url()); ?>" method="GET">
                <input type="hidden" name="url" value="products/search">
                <input id="live-search-input" type="search" name="q" placeholder="Buscar flores, ramos o regalos..." class="w-full bg-white border border-gray-200 py-4 px-8 text-sm outline-none focus:border-coral transition-colors text-charcoal shadow-sm rounded-full" style="border-color: #F2E8E6;">
                <i data-lucide="search" class="absolute right-6 top-1/2 -translate-y-1/2 text-gray-400 w-5 h-5 pointer-events-none" style="top: 50%; transform: translateY(-50%);"></i>
            </form>
        </div>
    </section>

    <!-- Quiz Assistant Widget -->
    <div class="max-w-7xl mx-auto px-6 pt-10 pb-2">
        <div id="quiz-banner" class="bg-white rounded-2xl shadow-sm border border-[#F2E8E6] p-8 flex flex-col md:flex-row items-center justify-between gap-6 transition-all duration-500 relative overflow-hidden">
            <div class="absolute -right-10 -top-10 w-40 h-40 rounded-full opacity-50" style="background-color: #FFF5F0;"></div>
            <div class="relative z-10 flex-1">
                <span class="inline-flex items-center gap-2 text-coral text-[10px] font-bold uppercase tracking-widest px-3 py-1 rounded-full mb-3" style="background-color: #FDF5F3;">
                    <i data-lucide="sparkles" class="w-3 h-3"></i> Asistente de Regalos
                </span>
                <h2 class="font-serif text-2xl text-charcoal mb-2">¿No sabes qué arreglo elegir?</h2>
                <p class="text-charcoal-light text-sm max-w-lg">Déjanos ayudarte. Responde 3 rápidas preguntas y te recomendaremos la flor perfecta para esa persona especial.</p>
            </div>
            <div class="relative z-10">
                <button onclick="startQuiz()" class="bg-charcoal hover:bg-coral text-white px-8 py-4 text-xs font-bold uppercase tracking-widest transition-colors rounded-full shadow-sm whitespace-nowrap">
                    Encontrar Flor Perfecta
                </button>
            </div>
        </div>

        <!-- Quiz Interface (Hidden by default) -->
        <div id="quiz-interface" class="hidden bg-white rounded-2xl shadow-sm border border-[#F2E8E6] p-8 transition-all duration-500">
            <div class="flex justify-between items-center mb-8 pb-4 border-b border-gray-100">
                <h3 class="font-serif text-xl text-charcoal flex items-center gap-2">
                    <i data-lucide="sparkles" class="w-5 h-5 text-coral"></i> Asesor Floral Virtual
                </h3>
                <button onclick="closeQuiz()" class="text-gray-400 hover:text-coral transition-colors">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <!-- Step 1 -->
            <div id="quiz-step-1" class="quiz-step">
                <p class="text-sm font-bold text-coral uppercase tracking-widest mb-4">Paso 1 de 3</p>
                <h4 class="text-2xl font-serif text-charcoal mb-6">¿Para quién es el detalle?</h4>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <button onclick="nextStep(2, 'amor')" class="quiz-option border border-gray-200 hover:border-coral p-6 rounded-xl transition-all text-center group bg-white">
                        <i data-lucide="heart" class="w-8 h-8 text-gray-400 group-hover:text-coral mx-auto mb-3 transition-colors"></i>
                        <span class="block text-sm font-bold text-charcoal">Mi Pareja</span>
                    </button>
                    <button onclick="nextStep(2, 'familia')" class="quiz-option border border-gray-200 hover:border-coral p-6 rounded-xl transition-all text-center group bg-white">
                        <i data-lucide="users" class="w-8 h-8 text-gray-400 group-hover:text-coral mx-auto mb-3 transition-colors"></i>
                        <span class="block text-sm font-bold text-charcoal">Familiar</span>
                    </button>
                    <button onclick="nextStep(2, 'amigo')" class="quiz-option border border-gray-200 hover:border-coral p-6 rounded-xl transition-all text-center group bg-white">
                        <i data-lucide="smile" class="w-8 h-8 text-gray-400 group-hover:text-coral mx-auto mb-3 transition-colors"></i>
                        <span class="block text-sm font-bold text-charcoal">Amistad</span>
                    </button>
                    <button onclick="nextStep(2, 'yo')" class="quiz-option border border-gray-200 hover:border-coral p-6 rounded-xl transition-all text-center group bg-white">
                        <i data-lucide="user" class="w-8 h-8 text-gray-400 group-hover:text-coral mx-auto mb-3 transition-colors"></i>
                        <span class="block text-sm font-bold text-charcoal">Para Mí</span>
                    </button>
                </div>
            </div>

            <!-- Step 2 -->
            <div id="quiz-step-2" class="quiz-step hidden">
                <p class="text-sm font-bold text-coral uppercase tracking-widest mb-4">Paso 2 de 3</p>
                <h4 class="text-2xl font-serif text-charcoal mb-6">¿Cuál es el motivo?</h4>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <button onclick="nextStep(3, 'romance')" class="quiz-option border border-gray-200 hover:border-coral p-4 rounded-xl transition-all text-center text-sm font-bold text-charcoal bg-white">Aniversario / Amor</button>
                    <button onclick="nextStep(3, 'cumpleanos')" class="quiz-option border border-gray-200 hover:border-coral p-4 rounded-xl transition-all text-center text-sm font-bold text-charcoal bg-white">Cumpleaños</button>
                    <button onclick="nextStep(3, 'perdon')" class="quiz-option border border-gray-200 hover:border-coral p-4 rounded-xl transition-all text-center text-sm font-bold text-charcoal bg-white">Pedir Perdón</button>
                    <button onclick="nextStep(3, 'decorar')" class="quiz-option border border-gray-200 hover:border-coral p-4 rounded-xl transition-all text-center text-sm font-bold text-charcoal bg-white">Decorar Casa</button>
                </div>
            </div>

            <!-- Step 3 -->
            <div id="quiz-step-3" class="quiz-step hidden">
                <p class="text-sm font-bold text-coral uppercase tracking-widest mb-4">Último Paso</p>
                <h4 class="text-2xl font-serif text-charcoal mb-6">¿Qué impacto buscas?</h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <button onclick="finishQuiz('tulipanes')" class="quiz-option border border-gray-200 hover:border-coral p-6 rounded-xl transition-all text-center bg-white">
                        <span class="block text-lg font-bold text-charcoal mb-1">Detalle Sutil</span>
                        <span class="text-xs text-charcoal-light">Algo pequeño y elegante</span>
                    </button>
                    <button onclick="finishQuiz('rosas')" class="quiz-option border border-gray-200 hover:border-coral p-6 rounded-xl transition-all text-center bg-white">
                        <span class="block text-lg font-bold text-charcoal mb-1">Clásico Romántico</span>
                        <span class="text-xs text-charcoal-light">Flores tradicionales que no fallan</span>
                    </button>
                    <button onclick="finishQuiz('premium')" class="quiz-option border border-gray-200 hover:border-coral p-6 rounded-xl transition-all text-center bg-white">
                        <span class="block text-lg font-bold text-charcoal mb-1">Extraordinario</span>
                        <span class="text-xs text-charcoal-light">Arreglos gigantes e inolvidables</span>
                    </button>
                </div>
            </div>
            
            <!-- Loading -->
            <div id="quiz-loading" class="hidden text-center py-10">
                <i data-lucide="loader-2" class="w-10 h-10 text-coral animate-spin mx-auto mb-4"></i>
                <h4 class="text-lg font-serif text-charcoal">Analizando las mejores opciones...</h4>
            </div>
        </div>
    </div>

    <!-- Shop Content -->
    <div class="max-w-7xl mx-auto px-6 pb-14 flex flex-col md:flex-row gap-10">
        
        <!-- Sidebar -->
        <aside class="w-full shrink-0" style="width: 256px;">
            <div class="bg-white rounded-2xl shadow-sm border p-6 sticky top-24" style="border-color: #F2E8E6;">
                <h2 class="font-serif font-bold text-xl text-charcoal mb-6 pb-4 border-b" style="border-color: #F2E8E6;">Categorías</h2>
                <nav class="flex flex-col gap-1.5">
                    <a href="<?php echo e(app_url('products')); ?>" class="px-3 py-2 rounded-lg text-sm font-medium transition-colors flex items-center gap-3 <?php echo empty($data['current_category']) ? 'text-coral font-bold' : 'text-charcoal-light hover:text-coral'; ?>" <?php echo empty($data['current_category']) ? 'style="background-color: #FDF5F3;"' : ''; ?>>
                        <i data-lucide="grid-3x3" class="w-4 h-4"></i> Todas las Flores
                    </a>
                    <?php foreach ($data['categories'] as $cat): ?>
                        <a href="<?php echo e(app_url('products', ['category' => $cat['id']])); ?>" class="px-3 py-2 rounded-lg text-sm font-medium transition-colors flex items-center gap-3 <?php echo ((int)$data['current_category'] === (int)$cat['id']) ? 'text-coral font-bold' : 'text-charcoal-light hover:text-coral'; ?>" <?php echo ((int)$data['current_category'] === (int)$cat['id']) ? 'style="background-color: #FDF5F3;"' : ''; ?>>
                            <i data-lucide="flower" class="w-4 h-4"></i> <?php echo e($cat['nombre']); ?>
                        </a>
                    <?php endforeach; ?>
                </nav>
            </div>
        </aside>

        <!-- Product Grid -->
        <div class="flex-1" id="product-results">
            <?php if (count($data['products']) > 0): ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($data['products'] as $product): ?>
                        <?php include __DIR__ . '/../_partials/product_card.php'; ?>
                    <?php endforeach; ?>
                </div>
                
                <!-- Pagination -->
                <div class="mt-16 flex justify-center items-center gap-4">
                    <?php if ((int)$data['page'] > 1): ?>
                        <a href="<?php echo e(app_url('products', ['page' => $data['page'] - 1, 'category' => $data['current_category']])); ?>" class="w-12 h-12 bg-white rounded-full shadow-sm border border-[#F2E8E6] flex items-center justify-center text-charcoal hover:border-coral hover:text-coral transition-colors">
                            <i data-lucide="chevron-left" class="w-5 h-5"></i>
                        </a>
                    <?php endif; ?>
                    
                    <span class="text-xs text-charcoal-light font-bold tracking-widest uppercase bg-white px-6 py-3 rounded-full shadow-sm border border-[#F2E8E6]">
                        Página <?php echo (int)$data['page']; ?>
                    </span>
                    
                    <?php if (count($data['products']) === 12): ?>
                        <a href="<?php echo e(app_url('products', ['page' => $data['page'] + 1, 'category' => $data['current_category']])); ?>" class="w-12 h-12 bg-white rounded-full shadow-sm border border-[#F2E8E6] flex items-center justify-center text-charcoal hover:border-coral hover:text-coral transition-colors">
                            <i data-lucide="chevron-right" class="w-5 h-5"></i>
                        </a>
                    <?php endif; ?>
                </div>
                
            <?php else: ?>
                <div class="text-center py-24 bg-white rounded-2xl shadow-sm border border-[#F2E8E6]">
                    <div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6" style="background-color: #FDF5F3;">
                        <i data-lucide="flower" class="w-10 h-10 text-coral"></i>
                    </div>
                    <h2 class="font-serif text-3xl text-charcoal mb-3">No hay flores disponibles</h2>
                    <p class="text-charcoal-light mb-8 max-w-md mx-auto">No pudimos encontrar arreglos en esta categoría en este momento. Prueba con otra o revisa nuestro catálogo completo.</p>
                    <a href="<?php echo e(app_url('products')); ?>" class="inline-block bg-coral hover:bg-[#D93838] text-white px-8 py-3.5 text-xs font-bold uppercase tracking-widest transition-colors rounded-full shadow-sm">
                        Ver Catálogo Completo
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    let currentQuizAnswers = [];
    
    function startQuiz() {
        document.getElementById('quiz-banner').classList.add('hidden');
        document.getElementById('quiz-interface').classList.remove('hidden');
        document.getElementById('quiz-step-1').classList.remove('hidden');
        document.getElementById('quiz-step-2').classList.add('hidden');
        document.getElementById('quiz-step-3').classList.add('hidden');
        currentQuizAnswers = [];
    }

    function closeQuiz() {
        document.getElementById('quiz-interface').classList.add('hidden');
        document.getElementById('quiz-banner').classList.remove('hidden');
    }

    function nextStep(step, answer) {
        currentQuizAnswers.push(answer);
        
        // Hide all steps
        document.querySelectorAll('.quiz-step').forEach(el => el.classList.add('hidden'));
        
        // Show next step
        const nextEl = document.getElementById('quiz-step-' + step);
        if(nextEl) {
            nextEl.classList.remove('hidden');
        }
    }

    function finishQuiz(answer) {
        currentQuizAnswers.push(answer);
        
        // Hide steps, show loading
        document.querySelectorAll('.quiz-step').forEach(el => el.classList.add('hidden'));
        document.getElementById('quiz-loading').classList.remove('hidden');
        
        // Simulate API delay for UX
        setTimeout(() => {
            // Determine search term based on answers
            let searchTerm = "rosas"; // default
            if(answer === "tulipanes") searchTerm = "tulipanes";
            if(answer === "premium") searchTerm = "premium";
            
            // Trigger dynamic AJAX search instead of reloading!
            const searchInput = document.getElementById('live-search-input');
            if (searchInput) {
                searchInput.value = searchTerm;
                // Trigger the 'input' event to start the live search automatically
                searchInput.dispatchEvent(new Event('input', { bubbles: true }));
            }
            
            // Clean up UI
            setTimeout(() => {
                closeQuiz();
                // Reset loading state for next time
                document.getElementById('quiz-loading').classList.add('hidden');
                document.getElementById('quiz-step-1').classList.remove('hidden');
                
                // Scroll down to the results
                document.getElementById('product-results').scrollIntoView({behavior: 'smooth', block: 'start'});
            }, 800);
            
        }, 1500);
    }

    // Live AJAX Search
    document.addEventListener("DOMContentLoaded", function() {
        const searchInput = document.getElementById('live-search-input');
        const resultsContainer = document.getElementById('product-results');
        let searchTimeout = null;

        if (searchInput && resultsContainer) {
            searchInput.addEventListener('input', function(e) {
                const query = e.target.value.trim();
                
                // Clear previous timeout
                if (searchTimeout) clearTimeout(searchTimeout);
                
                // Show loading state if typed enough
                if (query.length >= 2 || query.length === 0) {
                    // Start 500ms debounce
                    searchTimeout = setTimeout(() => {
                        // Show spinner over products
                        resultsContainer.style.opacity = '0.5';
                        resultsContainer.style.pointerEvents = 'none';
                        
                        let fetchUrl = "<?php echo app_url(); ?>?url=products/search&q=" + encodeURIComponent(query);
                        // If empty, fetch all products
                        if (query.length === 0) {
                            fetchUrl = "<?php echo app_url(); ?>?url=products";
                        }

                        fetch(fetchUrl)
                            .then(response => response.text())
                            .then(html => {
                                // Parse the returned HTML
                                const parser = new DOMParser();
                                const doc = parser.parseFromString(html, 'text/html');
                                
                                // Find the results container in the fetched page
                                const newResults = doc.getElementById('product-results');
                                
                                if (newResults) {
                                    resultsContainer.innerHTML = newResults.innerHTML;
                                }
                                
                                // Restore opacity
                                resultsContainer.style.opacity = '1';
                                resultsContainer.style.pointerEvents = 'auto';
                            })
                            .catch(error => {
                                console.error('Error fetching search results:', error);
                                resultsContainer.style.opacity = '1';
                                resultsContainer.style.pointerEvents = 'auto';
                            });

                    }, 500);
                }
            });

            // Prevent form submit since it's live
            document.getElementById('live-search-form').addEventListener('submit', function(e) {
                e.preventDefault();
            });
        }
    });
</script>
