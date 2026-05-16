    </main>

    <!-- FOOTER -->
    <footer class="bg-charcoal text-white pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-6">
            <!-- Top: Brand + Newsletter -->
            <div class="flex flex-col md:flex-row items-start justify-between gap-8 pb-12 border-b border-white/10 mb-12">
                <div class="max-w-md">
                    <a href="<?php echo e(app_url()); ?>" class="flex items-center gap-2 mb-4">
                        <i data-lucide="flower-2" class="w-7 h-7 text-coral"></i>
                        <span class="text-xl font-serif font-bold"><?php echo e(APP_NAME); ?></span>
                    </a>
                    <p class="text-gray-400 text-sm leading-relaxed">
                        Diseños florales artesanales para momentos inolvidables. Frescura y calidad garantizada.
                    </p>
                </div>
                <div class="w-full md:w-auto">
                    <h4 class="text-xs font-bold uppercase tracking-widest text-coral mb-3">Newsletter</h4>
                    <form action="<?php echo e(app_url('newsletter/subscribe')); ?>" method="POST" class="flex">
                        <input type="email" name="email" placeholder="Tu email" required class="bg-white/10 border border-white/20 py-3 px-4 text-sm text-white outline-none focus:border-coral transition-colors w-56 placeholder-gray-500">
                        <button type="submit" class="bg-coral hover:bg-coral-hover text-white px-5 py-3 text-xs font-bold uppercase tracking-widest transition-colors">
                            <i data-lucide="chevron-right" class="w-4 h-4"></i>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Links Grid -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 mb-12">
                <!-- My Account -->
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-widest text-coral mb-5">Mi Cuenta</h4>
                    <ul class="space-y-3 text-sm">
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <li><a href="<?php echo e(app_url('user/profile')); ?>" class="text-gray-400 hover:text-white transition-colors">Mi Perfil</a></li>
                            <li><a href="<?php echo e(app_url('orders')); ?>" class="text-gray-400 hover:text-white transition-colors">Mis Pedidos</a></li>
                            <li><a href="<?php echo e(app_url('favorites')); ?>" class="text-gray-400 hover:text-white transition-colors">Lista de Deseos</a></li>
                        <?php else: ?>
                            <li><a href="<?php echo e(app_url('user/login')); ?>" class="text-gray-400 hover:text-white transition-colors">Iniciar Sesión</a></li>
                            <li><a href="<?php echo e(app_url('user/register')); ?>" class="text-gray-400 hover:text-white transition-colors">Registrarse</a></li>
                        <?php endif; ?>
                        <li><a href="<?php echo e(app_url('cart')); ?>" class="text-gray-400 hover:text-white transition-colors">Mi Carrito</a></li>
                    </ul>
                </div>

                <!-- Categories -->
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-widest text-coral mb-5">Categorías</h4>
                    <ul class="space-y-3 text-sm">
                        <li><a href="<?php echo e(app_url('products', ['category' => 1])); ?>" class="text-gray-400 hover:text-white transition-colors">Flores</a></li>
                        <li><a href="<?php echo e(app_url('products', ['category' => 2])); ?>" class="text-gray-400 hover:text-white transition-colors">Ramos</a></li>
                        <li><a href="<?php echo e(app_url('products', ['category' => 3])); ?>" class="text-gray-400 hover:text-white transition-colors">Arreglos</a></li>
                        <li><a href="<?php echo e(app_url('products', ['category' => 4])); ?>" class="text-gray-400 hover:text-white transition-colors">Combos</a></li>
                    </ul>
                </div>

                <!-- Information -->
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-widest text-coral mb-5">Información</h4>
                    <ul class="space-y-3 text-sm">
                        <li><a href="<?php echo e(app_url('about')); ?>" class="text-gray-400 hover:text-white transition-colors">Nosotros</a></li>
                        <li><a href="<?php echo e(app_url('contact')); ?>" class="text-gray-400 hover:text-white transition-colors">Contacto</a></li>
                        <li><a href="<?php echo e(app_url('faq')); ?>" class="text-gray-400 hover:text-white transition-colors">Preguntas Frecuentes</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Envíos</a></li>
                    </ul>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-widest text-coral mb-5">Síguenos</h4>
                    <div class="flex gap-3 mb-6">
                        <a href="#" class="w-9 h-9 bg-white/10 flex items-center justify-center text-gray-400 hover:bg-coral hover:text-white transition-all rounded-full" title="Facebook">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.469h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.469h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <a href="#" class="w-9 h-9 bg-white/10 flex items-center justify-center text-gray-400 hover:bg-coral hover:text-white transition-all rounded-full" title="Instagram">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                        </a>
                        <a href="#" class="w-9 h-9 bg-white/10 flex items-center justify-center text-gray-400 hover:bg-coral hover:text-white transition-all rounded-full" title="TikTok">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a5.64 5.64 0 0 1-1.04-.1z"/></svg>
                        </a>
                    </div>
                    <p class="text-gray-500 text-xs leading-relaxed">
                        <i data-lucide="phone" class="w-3 h-3 inline text-coral"></i> (01) 999 9999<br>
                        <i data-lucide="mail" class="w-3 h-3 inline text-coral"></i> info@floreriartesanal.com
                    </p>
                </div>
            </div>

            <!-- Bottom Bar -->
            <div class="pt-6 border-t border-white/10 flex flex-col md:flex-row items-center justify-between gap-4 text-xs text-gray-500">
                <p>&copy; <?php echo date('Y'); ?> <?php echo e(APP_NAME); ?>. Todos los derechos reservados.</p>
                <div class="flex items-center gap-6">
                    <a href="#" class="hover:text-white transition-colors">Términos</a>
                    <a href="#" class="hover:text-white transition-colors">Privacidad</a>
                    <a href="#" class="hover:text-white transition-colors">Cookies</a>
                </div>
            </div>
        </div>
    </footer>

    <?php include VIEWS_PATH . 'global/whatsapp.php'; ?>
    <?php include VIEWS_PATH . 'global/cookie-consent.php'; ?>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            lucide.createIcons();
            var menuBtn = document.getElementById('mobile-menu-btn');
            var menuPanel = document.getElementById('mobile-menu-panel');
            if (menuBtn && menuPanel) {
                menuBtn.addEventListener('click', function() { menuPanel.classList.toggle('hidden'); });
            }
        });
    </script>
    <script src="<?php echo e(asset_url('js/main.js')); ?>"></script>
</body>
</html>
