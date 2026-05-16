<?php /** @var array $data */ ?>
<?php /** @var string $message */ ?>
<?php /** @var string $error */ ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($data['title'] ?? APP_NAME . ' - Admin'); ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo e(asset_url('css/style.css')); ?>">
    <link rel="icon" type="image/svg+xml" href="<?php echo e(asset_url('favicon.svg')); ?>">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <style>
        /* Custom tweaks for the admin panel if tailwind is not fully covering it yet */
        .admin-sidebar { transition: all 0.3s; }
        .admin-nav-link { transition: all 0.2s; }
        .admin-nav-link:hover, .admin-nav-link.active { background-color: rgba(255,255,255,0.1); border-left-color: #D4AF37; }
        
        @media (max-width: 1023px) {
            .admin-sidebar {
                position: fixed;
                top: 0;
                left: -100%;
                height: 100vh;
                z-index: 50;
                width: 280px;
            }
            .admin-sidebar.active {
                left: 0;
            }
            .admin-overlay {
                display: none;
                position: fixed;
                inset: 0;
                background: rgba(0,0,0,0.5);
                z-index: 40;
            }
            .admin-overlay.active {
                display: block;
            }
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased">
    <div id="admin-overlay" class="admin-overlay"></div>
    <div class="flex min-h-screen relative">
        
        <!-- Sidebar -->
        <aside id="admin-sidebar" class="w-64 bg-forest-900 text-white flex-shrink-0 admin-sidebar flex flex-col">
            <div class="h-16 flex items-center justify-between px-6 bg-forest-950 border-b border-forest-800">
                <a href="<?php echo e(app_url('admin')); ?>" class="flex items-center gap-2 text-gold-500 hover:text-gold-400 font-serif text-xl font-bold">
                    <img src="<?php echo e(asset_url('img/logo.svg')); ?>" alt="Logo" class="w-6 h-6 invert sepia saturate-200 hue-rotate-[30deg] brightness-125">
                    <span><?php echo e(APP_NAME); ?></span>
                </a>
                <button id="close-admin-menu" class="lg:hidden text-white/50 hover:text-white">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>
            
            <div class="p-4 flex-1 overflow-y-auto">
                <p class="text-xs font-semibold text-forest-300 uppercase tracking-wider mb-2 mt-4 px-3">Principal</p>
                <nav class="space-y-1">
                    <a href="<?php echo e(app_url('admin')); ?>" class="admin-nav-link flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium border-l-4 border-transparent <?php echo strpos($_SERVER['REQUEST_URI'], '/admin') !== false && !strpos($_SERVER['REQUEST_URI'], '/admin/') ? 'active' : ''; ?>">
                        <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                        Dashboard
                    </a>
                </nav>

                <p class="text-xs font-semibold text-forest-300 uppercase tracking-wider mb-2 mt-6 px-3">Gestion de Tienda</p>
                <nav class="space-y-1">
                    <a href="<?php echo e(app_url('admin/orders')); ?>" class="admin-nav-link flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium border-l-4 border-transparent <?php echo strpos($_SERVER['REQUEST_URI'], '/admin/orders') !== false ? 'active' : ''; ?>">
                        <i data-lucide="shopping-cart" class="w-5 h-5"></i>
                        Pedidos
                    </a>
                    <a href="<?php echo e(app_url('admin/products')); ?>" class="admin-nav-link flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium border-l-4 border-transparent <?php echo strpos($_SERVER['REQUEST_URI'], '/admin/products') !== false ? 'active' : ''; ?>">
                        <i data-lucide="package" class="w-5 h-5"></i>
                        Productos
                    </a>
                    <a href="<?php echo e(app_url('admin/categories')); ?>" class="admin-nav-link flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium border-l-4 border-transparent <?php echo strpos($_SERVER['REQUEST_URI'], '/admin/categories') !== false ? 'active' : ''; ?>">
                        <i data-lucide="tags" class="w-5 h-5"></i>
                        Categorias
                    </a>
                    <a href="<?php echo e(app_url('admin/deliveries')); ?>" class="admin-nav-link flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium border-l-4 border-transparent <?php echo strpos($_SERVER['REQUEST_URI'], '/admin/deliveries') !== false ? 'active' : ''; ?>">
                        <i data-lucide="truck" class="w-5 h-5"></i>
                        Entregas
                    </a>
                </nav>

                <p class="text-xs font-semibold text-forest-300 uppercase tracking-wider mb-2 mt-6 px-3">Marketing & Clientes</p>
                <nav class="space-y-1">
                    <a href="<?php echo e(app_url('admin/users')); ?>" class="admin-nav-link flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium border-l-4 border-transparent <?php echo strpos($_SERVER['REQUEST_URI'], '/admin/users') !== false ? 'active' : ''; ?>">
                        <i data-lucide="users" class="w-5 h-5"></i>
                        Usuarios
                    </a>
                    <a href="<?php echo e(app_url('admin/coupons')); ?>" class="admin-nav-link flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium border-l-4 border-transparent <?php echo strpos($_SERVER['REQUEST_URI'], '/admin/coupons') !== false ? 'active' : ''; ?>">
                        <i data-lucide="ticket" class="w-5 h-5"></i>
                        Cupones
                    </a>
                    <a href="<?php echo e(app_url('admin/reviews')); ?>" class="admin-nav-link flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium border-l-4 border-transparent <?php echo strpos($_SERVER['REQUEST_URI'], '/admin/reviews') !== false ? 'active' : ''; ?>">
                        <i data-lucide="star" class="w-5 h-5"></i>
                        Resenas
                    </a>
                    <a href="<?php echo e(app_url('admin/settings')); ?>" class="admin-nav-link flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium border-l-4 border-transparent <?php echo strpos($_SERVER['REQUEST_URI'], '/admin/settings') !== false ? 'active' : ''; ?>">
                        <i data-lucide="settings" class="w-5 h-5"></i>
                        Config Home
                    </a>
                </nav>
            </div>
            
            <div class="p-4 border-t border-forest-800">
                <a href="<?php echo e(app_url('user/logout')); ?>" class="flex items-center gap-3 px-3 py-2 text-red-400 hover:text-red-300 hover:bg-forest-800 rounded-md transition-colors text-sm font-medium">
                    <i data-lucide="log-out" class="w-5 h-5"></i>
                    Cerrar Sesion
                </a>
            </div>
        </aside>

        <!-- Main Content Wrapper -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Topbar -->
            <header class="h-16 bg-white shadow-sm flex items-center justify-between px-6 z-10 flex-shrink-0">
                <div class="flex items-center gap-4">
                    <button id="open-admin-menu" class="text-gray-500 hover:text-forest-600 lg:hidden">
                        <i data-lucide="menu"></i>
                    </button>
                    <h2 class="text-xl font-semibold text-gray-800 hidden sm:block">Panel de Administracion</h2>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const openBtn = document.getElementById('open-admin-menu');
                        const closeBtn = document.getElementById('close-admin-menu');
                        const sidebar = document.getElementById('admin-sidebar');
                        const overlay = document.getElementById('admin-overlay');

                        function toggleMenu() {
                            sidebar.classList.toggle('active');
                            overlay.classList.toggle('active');
                        }

                        if(openBtn) openBtn.addEventListener('click', toggleMenu);
                        if(closeBtn) closeBtn.addEventListener('click', toggleMenu);
                        if(overlay) overlay.addEventListener('click', toggleMenu);
                    });
                </script>
                
                <div class="flex items-center gap-4">
                    <a href="<?php echo e(app_url()); ?>" target="_blank" class="text-sm text-forest-600 hover:text-forest-800 flex items-center gap-1 font-medium bg-forest-50 px-3 py-1.5 rounded-full transition-colors">
                        <i data-lucide="external-link" class="w-4 h-4"></i>
                        Ver Tienda
                    </a>
                    <div class="relative flex items-center gap-2 border-l pl-4 ml-2">
                        <div class="w-8 h-8 rounded-full bg-gold-500 text-white flex items-center justify-center font-bold">
                            <?php echo strtoupper(substr($_SESSION['user_name'] ?? 'A', 0, 1)); ?>
                        </div>
                        <span class="text-sm font-medium text-gray-700 hidden md:block"><?php echo e($_SESSION['user_name'] ?? 'Admin'); ?></span>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6">
                
                <?php if ($message = flash('message')): ?>
                    <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-md shadow-sm flex items-start gap-3">
                        <i data-lucide="check-circle" class="text-green-500 mt-0.5"></i>
                        <p class="text-green-800 font-medium"><?php echo e($message); ?></p>
                    </div>
                <?php endif; ?>

                <?php if ($error = flash('error')): ?>
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-md shadow-sm flex items-start gap-3">
                        <i data-lucide="alert-circle" class="text-red-500 mt-0.5"></i>
                        <p class="text-red-800 font-medium"><?php echo e($error); ?></p>
                    </div>
                <?php endif; ?>
