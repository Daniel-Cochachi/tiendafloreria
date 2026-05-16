<?php $user = $data['user']; ?>

<section class="page-heading">
    <div>
        <p class="eyebrow">Dashboard</p>
        <h1>Mi cuenta</h1>
    </div>
</section>

<p class="text-lg text-forest font-serif mb-8">Bienvenido de nuevo, <?php echo e($user['nombre']); ?></p>

<section class="stat-grid">
    <div class="stat-card">
        <span>Pedidos totales</span>
        <strong><?php echo count($data['recent_orders']); ?></strong>
    </div>
    <div class="stat-card">
        <span>Favoritos guardados</span>
        <strong><?php echo (int)($data['favorites_count'] ?? 0); ?></strong>
    </div>
    <div class="stat-card">
        <span>Direcciones</span>
        <strong><?php echo (int)($data['addresses_count'] ?? 0); ?></strong>
    </div>
</section>

<div class="mt-12">
    <div class="section-title">
        <h2>Pedidos recientes</h2>
        <a class="btn btn-secondary" href="<?php echo e(app_url('orders')); ?>">Ver todos</a>
    </div>

    <?php if (count($data['recent_orders']) > 0): ?>
        <section class="table-card">
            <table class="responsive-table">
                <thead>
                    <tr>
                        <th>Numero</th>
                        <th>Fecha</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $displayed = 0; ?>
                    <?php foreach ($data['recent_orders'] as $order): ?>
                        <?php if ($displayed >= 5) break; ?>
                        <tr>
                            <td><?php echo e($order['numero_orden']); ?></td>
                            <td><?php echo date('d/m/Y', strtotime($order['created_at'])); ?></td>
                            <td><?php echo money($order['total']); ?></td>
                            <td><span class="badge badge-<?php echo e($order['estado_orden']); ?>"><?php echo e(str_replace('_', ' ', $order['estado_orden'])); ?></span></td>
                            <td><a class="btn btn-secondary" href="<?php echo e(app_url('orders/detail/' . $order['id'])); ?>">Ver</a></td>
                        </tr>
                        <?php $displayed++; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    <?php else: ?>
        <div class="empty-state">
            <h2>Aun no tienes pedidos</h2>
            <p>Cuando completes una compra, aparecera aqui.</p>
        </div>
    <?php endif; ?>
</div>

<div class="mt-12">
    <h2>Accesos rapidos</h2>
    <div class="flex flex-wrap gap-4 mt-4">
        <a class="btn btn-primary" href="<?php echo e(app_url('products')); ?>">Ver catalogo</a>
        <a class="btn btn-secondary" href="<?php echo e(app_url('favorites')); ?>">Mis favoritos</a>
        <a class="btn btn-secondary" href="<?php echo e(app_url('user/profile')); ?>">Mis direcciones</a>
    </div>
</div>

<section class="panel mt-12">
    <h2>Informacion de la cuenta</h2>
    <div class="list-stack">
        <div class="line-item">
            <span>Nombre</span>
            <strong><?php echo e($user['nombre'] . ' ' . ($user['apellido'] ?? '')); ?></strong>
        </div>
        <div class="line-item">
            <span>Email</span>
            <strong><?php echo e($user['email']); ?></strong>
        </div>
        <div class="line-item">
            <span>Telefono</span>
            <strong><?php echo e($user['telefono'] ?? 'No registrado'); ?></strong>
        </div>
    </div>
    <a class="btn btn-secondary mt-4" href="<?php echo e(app_url('user/profile')); ?>">Editar perfil</a>
</section>
