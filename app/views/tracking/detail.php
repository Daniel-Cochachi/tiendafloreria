<?php
$order = $data['order'];
$steps = ['pendiente', 'confirmada', 'preparando', 'listo_envio', 'enviada', 'entregada'];
$current = array_search($order['estado_orden'], $steps, true);
?>

<section class="page-heading">
    <div>
        <p class="eyebrow">Seguimiento</p>
        <h1><?php echo e($order['numero_orden']); ?></h1>
    </div>
    <a class="btn btn-secondary" href="<?php echo e(app_url('tracking')); ?>">Volver</a>
</section>

<div class="order-layout">
    <section class="panel">
        <div class="split-header">
            <div>
                <p><strong>Fecha:</strong> <?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?></p>
                <p><strong>Estado:</strong> <span class="badge badge-<?php echo e($order['estado_orden']); ?>"><?php echo e(str_replace('_', ' ', $order['estado_orden'])); ?></span></p>
            </div>
        </div>

        <h2>Estado del pedido</h2>
        <div class="timeline">
            <?php foreach ($steps as $index => $step): ?>
                <div class="timeline-item <?php echo ($current !== false && $index <= $current) ? 'active' : ''; ?>">
                    <span></span>
                    <p><?php echo e(str_replace('_', ' ', $step)); ?></p>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if (!empty($data['delivery']['repartidor'])): ?>
            <h2>Repartidor</h2>
            <p><strong>Nombre:</strong> <?php echo e($data['delivery']['repartidor']); ?></p>
            <?php if (!empty($data['delivery']['telefono'])): ?>
                <p><strong>Telefono:</strong> <?php echo e($data['delivery']['telefono']); ?></p>
            <?php endif; ?>
        <?php endif; ?>

        <h2>Direccion de entrega</h2>
        <div class="address-box">
            <strong><?php echo e($order['nombre'] . ' ' . $order['apellido']); ?></strong>
            <p><?php echo e($order['calle'] . ' ' . $order['numero']); ?></p>
            <p><?php echo e($order['distrito'] . ', ' . $order['provincia'] . ', ' . $order['departamento_prov']); ?></p>
            <?php if (!empty($order['referencia'])): ?>
                <p>Ref: <?php echo e($order['referencia']); ?></p>
            <?php endif; ?>
            <p><?php echo e($order['telefono']); ?></p>
        </div>

        <?php if (!empty($order['notas_especiales'])): ?>
            <h2>Notas del pedido</h2>
            <p><?php echo nl2br(e($order['notas_especiales'])); ?></p>
        <?php endif; ?>

        <h2>Productos</h2>
        <table class="responsive-table compact-table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['details'] as $detail): ?>
                    <tr>
                        <td><?php echo e($detail['nombre']); ?></td>
                        <td><?php echo (int)$detail['cantidad']; ?></td>
                        <td><?php echo money($detail['precio_unitario']); ?></td>
                        <td><?php echo money($detail['subtotal']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <?php if (!empty($data['services'])): ?>
            <h2>Servicios adicionales</h2>
            <div class="list-stack">
                <?php foreach ($data['services'] as $service): ?>
                    <div class="line-item">
                        <span><?php echo e($service['nombre']); ?></span>
                        <strong><?php echo money($service['precio']); ?></strong>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if ($order['estado_orden'] === 'pendiente'): ?>
            <a class="btn btn-danger mt-4" href="<?php echo e(app_url('orders/cancel/' . $order['id'])); ?>" onclick="return confirm('Cancelar esta orden?')">Cancelar orden</a>
        <?php endif; ?>
    </section>

    <aside class="summary-card">
        <h2>Resumen</h2>
        <div class="summary-row">
            <span>Subtotal</span>
            <strong><?php echo money($order['subtotal']); ?></strong>
        </div>
        <div class="summary-row">
            <span>Envio</span>
            <strong><?php echo money($order['costo_envio']); ?></strong>
        </div>
        <div class="summary-row">
            <span>Descuento</span>
            <strong>-<?php echo money($order['descuento_total']); ?></strong>
        </div>
        <div class="summary-row total">
            <span>Total</span>
            <strong><?php echo money($order['total']); ?></strong>
        </div>
    </aside>
</div>
