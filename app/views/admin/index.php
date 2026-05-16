<div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <p class="text-sm font-semibold text-forest-600 uppercase tracking-wider mb-1">Administracion</p>
        <h1 class="text-3xl font-serif font-bold text-gray-900">Resumen General</h1>
    </div>
    <div class="flex flex-wrap gap-3">
        <a class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors" href="<?php echo e(app_url('admin/products')); ?>">
            <i data-lucide="plus" class="w-4 h-4"></i> Nuevo Producto
        </a>
        <a class="inline-flex items-center gap-2 px-4 py-2 bg-forest-700 text-white rounded-md shadow-sm text-sm font-medium hover:bg-forest-800 transition-colors" href="<?php echo e(app_url('admin/orders')); ?>">
            <i data-lucide="list" class="w-4 h-4"></i> Ver Pedidos
        </a>
    </div>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-sm font-medium text-gray-500">Ventas Pagadas</h3>
            <div class="p-2 bg-green-50 text-green-600 rounded-lg">
                <i data-lucide="trending-up" class="w-5 h-5"></i>
            </div>
        </div>
        <p class="text-2xl font-bold text-gray-900"><?php echo money($data['stats']['ventas_pagadas'] ?? 0); ?></p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-sm font-medium text-gray-500">Pedidos Totales</h3>
            <div class="p-2 bg-blue-50 text-blue-600 rounded-lg">
                <i data-lucide="shopping-bag" class="w-5 h-5"></i>
            </div>
        </div>
        <p class="text-2xl font-bold text-gray-900"><?php echo (int)($data['stats']['total_ordenes'] ?? 0); ?></p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-sm font-medium text-gray-500">Pendientes</h3>
            <div class="p-2 bg-yellow-50 text-yellow-600 rounded-lg">
                <i data-lucide="clock" class="w-5 h-5"></i>
            </div>
        </div>
        <p class="text-2xl font-bold text-gray-900"><?php echo (int)($data['stats']['ordenes_pendientes'] ?? 0); ?></p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-sm font-medium text-gray-500">Productos Activos</h3>
            <div class="p-2 bg-purple-50 text-purple-600 rounded-lg">
                <i data-lucide="package" class="w-5 h-5"></i>
            </div>
        </div>
        <p class="text-2xl font-bold text-gray-900"><?php echo (int)$data['total_products']; ?></p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-sm font-medium text-gray-500">Clientes</h3>
            <div class="p-2 bg-gold-50 text-gold-600 rounded-lg">
                <i data-lucide="users" class="w-5 h-5"></i>
            </div>
        </div>
        <p class="text-2xl font-bold text-gray-900"><?php echo (int)$data['total_clients']; ?></p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden lg:col-span-2">
        <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
            <h2 class="text-lg font-semibold text-gray-800">Pedidos Recientes</h2>
            <a href="<?php echo e(app_url('admin/orders')); ?>" class="text-sm font-medium text-forest-600 hover:text-forest-800">Ver todos</a>
        </div>
        <div class="divide-y divide-gray-100">
            <?php foreach ($data['recent_orders'] as $order): ?>
                <div class="p-6 flex items-center justify-between hover:bg-gray-50 transition-colors">
                    <div class="flex flex-col">
                        <span class="text-sm font-bold text-charcoal"><?php echo e($order['numero_orden']); ?></span>
                        <span class="text-xs text-gray-500"><?php echo e($order['nombre'] . ' ' . ($order['apellido'] ?? '')); ?></span>
                    </div>
                    <div class="flex items-center gap-6">
                        <span class="px-3 py-1 text-[10px] font-bold uppercase tracking-widest rounded-full <?php echo $order['estado_pago'] === 'pagado' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700'; ?>">
                            <?php echo $order['estado_pago']; ?>
                        </span>
                        <strong class="text-charcoal font-bold text-base"><?php echo money($order['total']); ?></strong>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php if (!$data['recent_orders']): ?>
                <div class="p-6 text-center text-gray-500">Sin pedidos registrados.</div>
            <?php endif; ?>
        </div>
    </div>

    <div class="flex flex-col gap-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                    <i data-lucide="alert-triangle" class="w-5 h-5 text-yellow-500"></i> Stock Bajo
                </h2>
                <a href="<?php echo e(app_url('admin/products')); ?>" class="text-sm font-medium text-forest-600 hover:text-forest-800">Gestionar</a>
            </div>
            <div class="divide-y divide-gray-100">
                <?php foreach ($data['low_stock'] as $product): ?>
                    <div class="p-4 flex items-center justify-between">
                        <span class="text-sm text-gray-700 font-medium truncate pr-4" title="<?php echo e($product['nombre']); ?>"><?php echo e($product['nombre']); ?></span>
                        <span class="px-2 py-1 bg-red-50 text-red-700 font-bold text-xs rounded-md"><?php echo (int)$product['stock']; ?> left</span>
                    </div>
                <?php endforeach; ?>
                <?php if (!$data['low_stock']): ?>
                    <div class="p-6 text-center text-gray-500 text-sm">Stock en optimas condiciones.</div>
                <?php endif; ?>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                    <i data-lucide="star" class="w-5 h-5 text-gold-500"></i> Resenas Pendientes
                </h2>
                <a href="<?php echo e(app_url('admin/reviews')); ?>" class="text-sm font-medium text-forest-600 hover:text-forest-800">Revisar</a>
            </div>
            <div class="divide-y divide-gray-100">
                <?php foreach (array_slice($data['pending_reviews'], 0, 5) as $review): ?>
                    <div class="p-4 flex items-center justify-between">
                        <span class="text-sm text-gray-700 truncate pr-4" title="<?php echo e($review['producto_nombre']); ?>"><?php echo e($review['producto_nombre']); ?></span>
                        <div class="flex items-center text-gold-500 text-sm font-bold gap-1">
                            <?php echo (int)$review['calificacion']; ?> <i data-lucide="star" class="w-3 h-3 fill-current"></i>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php if (!$data['pending_reviews']): ?>
                    <div class="p-6 text-center text-gray-500 text-sm">No hay resenas pendientes.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
