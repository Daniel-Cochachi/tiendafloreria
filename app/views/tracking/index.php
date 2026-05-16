<?php $steps = ['pendiente', 'confirmada', 'preparando', 'listo_envio', 'enviada', 'entregada']; ?>

<section class="page-heading">
    <div>
        <p class="eyebrow">Tus pedidos</p>
        <h1>Seguimiento</h1>
    </div>
    <a class="btn btn-primary" href="<?php echo e(app_url('products')); ?>">Comprar de nuevo</a>
</section>

<?php if (count($data['orders']) > 0): ?>
    <section class="space-y-6">
        <?php foreach ($data['orders'] as $order): ?>
            <article class="panel">
                <div class="split-header">
                    <div>
                        <strong><?php echo e($order['numero_orden']); ?></strong>
                        <p class="muted small"><?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?></p>
                    </div>
                    <span class="badge badge-<?php echo e($order['estado_orden']); ?>"><?php echo e(str_replace('_', ' ', $order['estado_orden'])); ?></span>
                </div>

                <div class="timeline">
                    <?php
                        $current = array_search($order['estado_orden'], $steps, true);
                    ?>
                    <?php foreach ($steps as $index => $step): ?>
                        <div class="timeline-item <?php echo ($current !== false && $index <= $current) ? 'active' : ''; ?>">
                            <span></span>
                            <p><?php echo e(str_replace('_', ' ', $step)); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="line-item">
                    <span>Total</span>
                    <strong><?php echo money($order['total']); ?></strong>
                </div>

                <a class="btn btn-secondary mt-4" href="<?php echo e(app_url('tracking/detail/' . $order['id'])); ?>">Ver detalle</a>
            </article>
        <?php endforeach; ?>
    </section>
<?php else: ?>
    <div class="empty-state">
        <h2>No tienes pedidos en seguimiento</h2>
        <p>Realiza tu primera compra para ver el estado aqui.</p>
        <a class="btn btn-primary" href="<?php echo e(app_url('products')); ?>">Ir a la tienda</a>
    </div>
<?php endif; ?>
