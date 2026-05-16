<?php /** @var array $data */ ?>
<?php /** @var string $message */ ?>
<?php /** @var string $error */ ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($data['title'] ?? APP_NAME); ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo e(asset_url('css/style.css')); ?>">
    <link rel="icon" type="image/svg+xml" href="<?php echo e(asset_url('favicon.svg')); ?>">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <style>
        body { font-family: 'Montserrat', sans-serif; color: #1a1a1a; }
        h1, h2, h3, h4, h5, h6, .font-serif { font-family: 'Playfair Display', serif; }
        .font-script { font-family: 'Great Vibes', cursive; }
        
        /* Responsive Safety Classes */
        .flex-safe { display: flex; flex-direction: column; }
        @media (min-width: 768px) {
            .flex-safe { flex-direction: row; }
            .w-sidebar-safe { width: 380px !important; flex: 0 0 380px !important; }
            .w-1-3-safe { width: 33.3333% !important; flex: 0 0 33.3333% !important; }
            .w-2-3-safe { width: 66.6666% !important; flex: 0 0 66.6666% !important; }
            .w-1-2-safe { width: 50% !important; flex: 0 0 50% !important; }
            .flex-1-safe { flex: 1 1 auto !important; }
        }
        @media (max-width: 767px) {
            .w-sidebar-safe, .w-1-3-safe, .w-2-3-safe, .w-1-2-safe, .flex-1-safe { width: 100% !important; flex: 0 0 100% !important; }
            .mobile-hide { display: none !important; }
            .mobile-show { display: block !important; }
        }
    </style>
</head>
<body class="min-h-screen flex flex-col antialiased bg-white selection:bg-coral selection:text-white">

    <!-- TOP BAR -->
    <div class="bg-charcoal text-white text-xs">
        <div class="max-w-7xl mx-auto px-6 h-10 flex items-center justify-between">
            <div class="hidden md:flex items-center gap-6">
                <a href="tel:+5119999999" class="flex items-center gap-1.5 hover:text-coral-light transition-colors">
                    <i data-lucide="phone" class="w-3 h-3"></i>
                    <span>(01) 999 9999</span>
                </a>
                <a href="mailto:info@floreriartesanal.com" class="flex items-center gap-1.5 hover:text-coral-light transition-colors">
                    <i data-lucide="mail" class="w-3 h-3"></i>
                    <span>info@floreriartesanal.com</span>
                </a>
            </div>
            <div class="flex-1 md:flex-none text-center">
                <span class="font-medium tracking-wider uppercase">Envío Gratis en pedidos +S/150</span>
            </div>
            <div class="hidden md:flex items-center gap-4">
                <a href="#" class="hover:text-coral-light transition-colors"><i data-lucide="facebook" class="w-3.5 h-3.5"></i></a>
                <a href="#" class="hover:text-coral-light transition-colors"><i data-lucide="instagram" class="w-3.5 h-3.5"></i></a>
                <a href="#" class="hover:text-coral-light transition-colors"><i data-lucide="twitter" class="w-3.5 h-3.5"></i></a>
            </div>
        </div>
    </div>

    <!-- MAIN HEADER -->
    <header class="bg-white border-b border-gray-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <!-- Logo -->
            <a href="<?php echo e(app_url()); ?>" class="flex items-center gap-2 text-charcoal shrink-0">
                <img src="<?php echo e(asset_url('img/logo.svg')); ?>" alt="Logo" class="w-8 h-8 text-coral">
                <span class="font-serif font-bold text-2xl tracking-tight"><?php echo e(APP_NAME); ?></span>
            </a>
            
            <!-- Mobile Toggle -->
            <button id="mobile-menu-btn" class="lg:hidden text-charcoal hover:text-coral transition-colors" type="button" aria-expanded="false" aria-controls="primary-menu">
                <i data-lucide="menu" class="w-6 h-6"></i>
            </button>
            
            <!-- Center Nav -->
            <nav id="primary-menu" class="hidden lg:flex flex-1 justify-center">
                <ul class="flex items-center gap-8 font-semibold text-[13px] uppercase tracking-[0.12em] text-charcoal">
                    <li><a href="<?php echo e(app_url()); ?>" class="py-2 border-b-2 border-transparent hover:text-coral hover:border-coral transition-all">Inicio</a></li>
                    <li><a href="<?php echo e(app_url('about')); ?>" class="py-2 border-b-2 border-transparent hover:text-coral hover:border-coral transition-all">Nosotros</a></li>
                    <li><a href="<?php echo e(app_url('products')); ?>" class="py-2 border-b-2 border-transparent hover:text-coral hover:border-coral transition-all">Tienda</a></li>
                    <li><a href="<?php echo e(app_url('promotions')); ?>" class="py-2 border-b-2 border-transparent hover:text-coral hover:border-coral transition-all">Ofertas</a></li>
                    <li><a href="<?php echo e(app_url('contact')); ?>" class="py-2 border-b-2 border-transparent hover:text-coral hover:border-coral transition-all">Contacto</a></li>
                </ul>
            </nav>
            
            <!-- Right Actions -->
            <div class="hidden lg:flex items-center gap-5 shrink-0">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <div class="relative group">
                        <a href="#" class="flex items-center gap-2 text-charcoal hover:text-coral transition-colors">
                            <i data-lucide="user" class="w-5 h-5"></i>
                            <span class="text-xs font-semibold uppercase tracking-wider"><?php echo e($_SESSION['user_name'] ?? 'Cuenta'); ?></span>
                        </a>
                        <div class="absolute right-0 top-full mt-2 w-48 bg-white shadow-card rounded-md opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all flex flex-col z-50 py-2 border border-gray-100">
                            <a href="<?php echo e(app_url('user/profile')); ?>" class="px-4 py-2 text-sm text-charcoal hover:text-coral hover:bg-blush-50">Mi Perfil</a>
                            <a href="<?php echo e(app_url('orders')); ?>" class="px-4 py-2 text-sm text-charcoal hover:text-coral hover:bg-blush-50">Mis Pedidos</a>
                            <a href="<?php echo e(app_url('favorites')); ?>" class="px-4 py-2 text-sm text-charcoal hover:text-coral hover:bg-blush-50">Favoritos</a>
                            <?php if (($_SESSION['user_rol'] ?? '') === 'admin'): ?>
                                <a href="<?php echo e(app_url('admin')); ?>" class="px-4 py-2 text-sm font-bold text-coral hover:bg-blush-50">Panel Admin</a>
                            <?php endif; ?>
                            <div class="border-t border-gray-50 my-1"></div>
                            <a href="<?php echo e(app_url('user/logout')); ?>" class="px-4 py-2 text-sm text-gray-500 hover:text-red-500">Cerrar Sesión</a>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="<?php echo e(app_url('user/login')); ?>" class="text-charcoal hover:text-coral transition-colors" title="Iniciar Sesión">
                        <i data-lucide="user" class="w-5 h-5"></i>
                    </a>
                <?php endif; ?>

                <a href="<?php echo e(app_url('favorites')); ?>" class="text-charcoal hover:text-coral transition-colors" title="Favoritos">
                    <i data-lucide="heart" class="w-5 h-5"></i>
                </a>

                <a href="<?php echo e(app_url('cart')); ?>" class="flex items-center text-charcoal hover:text-coral transition-colors relative" title="Carrito">
                    <div class="relative">
                        <i data-lucide="shopping-bag" class="w-5 h-5"></i>
                        <span id="cart-count-badge" class="absolute -top-2 -right-2.5 bg-coral text-white text-[10px] font-bold w-[18px] h-[18px] flex items-center justify-center rounded-full">
                            <?php
                            $cart_count = 0;
                            if (isset($_SESSION['user_id'])) {
                                static $cart_model_loaded = false;
                                if (!$cart_model_loaded) {
                                    $cart_db = new Database();
                                    $cart_conn = $cart_db->connect();
                                    $cart_query = "SELECT COALESCE(SUM(cantidad), 0) AS count FROM carrito WHERE usuario_id = :uid";
                                    $cart_stmt = $cart_conn->prepare($cart_query);
                                    $cart_stmt->execute([':uid' => $_SESSION['user_id']]);
                                    $cart_row = $cart_stmt->fetch();
                                    $cart_count = (int)($cart_row['count'] ?? 0);
                                    $cart_model_loaded = true;
                                }
                            }
                            echo e($cart_count);
                            ?>
                        </span>
                    </div>
                </a>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu-panel" class="hidden lg:hidden bg-white border-t border-gray-100 shadow-card">
            <nav class="max-w-7xl mx-auto px-6 py-6">
                <ul class="flex flex-col gap-4 font-semibold text-sm uppercase tracking-wider text-charcoal">
                    <li><a href="<?php echo e(app_url()); ?>" class="block py-2 hover:text-coral transition-colors">Inicio</a></li>
                    <li><a href="<?php echo e(app_url('about')); ?>" class="block py-2 hover:text-coral transition-colors">Nosotros</a></li>
                    <li><a href="<?php echo e(app_url('products')); ?>" class="block py-2 hover:text-coral transition-colors">Tienda</a></li>
                    <li><a href="<?php echo e(app_url('promotions')); ?>" class="block py-2 hover:text-coral transition-colors">Ofertas</a></li>
                    <li><a href="<?php echo e(app_url('contact')); ?>" class="block py-2 hover:text-coral transition-colors">Contacto</a></li>
                </ul>
                <div class="flex items-center gap-6 mt-6 pt-6 border-t border-gray-100">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="<?php echo e(app_url('user/profile')); ?>" class="text-charcoal hover:text-coral transition-colors"><i data-lucide="user" class="w-5 h-5"></i></a>
                    <?php else: ?>
                        <a href="<?php echo e(app_url('user/login')); ?>" class="text-charcoal hover:text-coral transition-colors"><i data-lucide="user" class="w-5 h-5"></i></a>
                    <?php endif; ?>
                    <a href="<?php echo e(app_url('favorites')); ?>" class="text-charcoal hover:text-coral transition-colors"><i data-lucide="heart" class="w-5 h-5"></i></a>
                    <a href="<?php echo e(app_url('cart')); ?>" class="text-charcoal hover:text-coral transition-colors relative">
                        <i data-lucide="shopping-bag" class="w-5 h-5"></i>
                        <span class="absolute -top-2 -right-2.5 bg-coral text-white text-[10px] font-bold w-[18px] h-[18px] flex items-center justify-center rounded-full"><?php echo e($cart_count); ?></span>
                    </a>
                </div>
            </nav>
        </div>
    </header>

    <main class="flex-grow">
        <?php if ($message = flash('message')): ?>
            <div class="bg-green-50 text-green-700 border-l-4 border-green-500 p-4 flex items-center gap-3 max-w-7xl mx-auto my-6 text-sm font-medium animate-slide-up">
                <i data-lucide="check-circle" class="w-5 h-5"></i> <?php echo e($message); ?>
            </div>
        <?php endif; ?>

        <?php if ($error = flash('error')): ?>
            <div class="bg-red-50 text-red-600 border-l-4 border-red-500 p-4 flex items-center gap-3 max-w-7xl mx-auto my-6 text-sm font-medium animate-slide-up">
                <i data-lucide="alert-triangle" class="w-5 h-5"></i> <?php echo e($error); ?>
            </div>
        <?php endif; ?>
