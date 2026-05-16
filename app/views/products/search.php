<?php /** @var array $data */ ?>
<div class="min-h-screen" style="background-color: #FDF9F8;">
    <!-- Page Header -->
    <section class="py-16 px-6 text-center border-b" style="background-color: #FFF5F0; border-color: #FDECE8;">
        <div class="max-w-4xl mx-auto">
            <span class="font-script text-coral text-3xl block mb-2">Búsqueda</span>
            <h1 class="text-4xl md:text-5xl font-serif text-charcoal mb-8">
                <?php echo e($data['search_term'] ? 'Resultados para "' . $data['search_term'] . '"' : 'Buscar Productos'); ?>
            </h1>
            <form id="live-search-form" class="max-w-lg mx-auto relative mt-6" action="<?php echo e(app_url()); ?>" method="GET">
                <input type="hidden" name="url" value="products/search">
                <input id="live-search-input" type="search" name="q" value="<?php echo e($data['search_term']); ?>" placeholder="Buscar flores, ramos o regalos..." class="w-full bg-white border py-4 px-8 text-sm outline-none focus:border-coral transition-colors text-charcoal shadow-sm rounded-full" style="border-color: #F2E8E6;">
                <i data-lucide="search" class="absolute right-6 top-1/2 -translate-y-1/2 text-gray-400 w-5 h-5 pointer-events-none" style="top: 50%; transform: translateY(-50%);"></i>
            </form>
        </div>
    </section>

    <!-- Search Content -->
    <div class="max-w-7xl mx-auto px-6 py-14" id="product-results">
        
        <?php if (strlen($data['search_term']) > 0 && strlen($data['search_term']) < 2): ?>
            <div class="bg-red-50 text-red-600 p-4 rounded-lg mb-8 text-center text-sm font-bold border border-red-100">
                Escribe al menos 2 caracteres para buscar.
            </div>
        <?php endif; ?>

        <?php if (count($data['products']) > 0): ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <?php foreach ($data['products'] as $product): ?>
                    <?php include __DIR__ . '/../_partials/product_card.php'; ?>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <?php if (!$data['products'] && strlen($data['search_term']) >= 2): ?>
                <div class="text-center py-24 bg-white rounded-2xl shadow-sm border border-[#F2E8E6] max-w-3xl mx-auto">
                    <div class="w-20 h-20 bg-[#FDF5F3] rounded-full flex items-center justify-center mx-auto mb-6">
                        <i data-lucide="search-X" class="w-10 h-10 text-coral"></i>
                    </div>
                    <h2 class="font-serif text-3xl text-charcoal mb-3">Sin resultados</h2>
                    <p class="text-charcoal-light mb-8 max-w-md mx-auto">No encontramos flores que coincidan con "<?php echo e($data['search_term']); ?>". Prueba usando otros términos de búsqueda.</p>
                    <a href="<?php echo e(app_url('products')); ?>" class="inline-block bg-coral hover:bg-[#D93838] text-white px-8 py-3.5 text-xs font-bold uppercase tracking-widest transition-colors rounded-full shadow-sm">
                        Volver al catálogo
                    </a>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

<script>
    // Live AJAX Search for search page
    document.addEventListener("DOMContentLoaded", function() {
        const searchInput = document.getElementById('live-search-input');
        const resultsContainer = document.getElementById('product-results');
        let searchTimeout = null;

        if (searchInput && resultsContainer) {
            // Put cursor at the end if there's text
            if(searchInput.value) {
                searchInput.setSelectionRange(searchInput.value.length, searchInput.value.length);
                searchInput.focus();
            }

            searchInput.addEventListener('input', function(e) {
                const query = e.target.value.trim();
                
                if (searchTimeout) clearTimeout(searchTimeout);
                
                if (query.length >= 2 || query.length === 0) {
                    searchTimeout = setTimeout(() => {
                        resultsContainer.style.opacity = '0.5';
                        resultsContainer.style.pointerEvents = 'none';
                        
                        let fetchUrl = "<?php echo app_url(); ?>?url=products/search&q=" + encodeURIComponent(query);
                        if (query.length === 0) {
                            fetchUrl = "<?php echo app_url(); ?>?url=products";
                        }

                        fetch(fetchUrl)
                            .then(response => response.text())
                            .then(html => {
                                const parser = new DOMParser();
                                const doc = parser.parseFromString(html, 'text/html');
                                const newResults = doc.getElementById('product-results');
                                
                                if (newResults) {
                                    // Also update the title
                                    const titleH1 = doc.querySelector('h1.font-serif');
                                    if(titleH1 && document.querySelector('h1.font-serif')) {
                                        document.querySelector('h1.font-serif').innerHTML = titleH1.innerHTML;
                                    }
                                    // Update history URL without reloading
                                    window.history.pushState({}, '', fetchUrl);
                                    
                                    resultsContainer.innerHTML = newResults.innerHTML;
                                }
                                
                                resultsContainer.style.opacity = '1';
                                resultsContainer.style.pointerEvents = 'auto';
                            })
                            .catch(error => {
                                console.error('Error fetching search results:', error);
                                resultsContainer.style.opacity = '1';
                                resultsContainer.style.pointerEvents = 'auto';
                            });

                    }, 400); // slightly faster debounce on search page
                }
            });

            document.getElementById('live-search-form').addEventListener('submit', function(e) {
                e.preventDefault();
            });
        }
    });
</script>
