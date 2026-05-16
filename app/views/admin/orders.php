<?php /** @var array $data */ ?>
<section class="page-heading">
    <div>
        <p class="eyebrow">Admin</p>
        <h1>Pedidos</h1>
    </div>
    <a class="btn btn-secondary" href="<?php echo e(app_url('admin')); ?>">Panel</a>
</section>

<section class="table-card">
    <table class="responsive-table">
        <thead>
            <tr>
                <th>Orden</th>
                <th>Cliente</th>
                <th>Total</th>
                <th>Pedido</th>
                <th>Pago</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['orders'] as $order): ?>
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="py-4">
                        <div class="flex flex-col">
                            <a href="<?php echo e(app_url('orders/detail/' . $order['id'])); ?>" class="font-bold text-charcoal hover:text-coral transition-colors"><?php echo e($order['numero_orden']); ?></a>
                            <span class="text-[11px] text-gray-400 font-medium uppercase tracking-tighter"><?php echo date('d/m/Y', strtotime($order['created_at'])); ?></span>
                        </div>
                    </td>
                    <td class="py-4">
                        <div class="flex flex-col">
                            <span class="font-semibold text-charcoal"><?php echo e($order['nombre'] . ' ' . $order['apellido']); ?></span>
                            <span class="text-xs text-gray-400"><?php echo e($order['email']); ?></span>
                        </div>
                    </td>
                    <td class="py-4">
                        <span class="font-bold text-coral"><?php echo money($order['total']); ?></span>
                    </td>
                    <td class="py-4">
                        <?php
                            $statusMap = [
                                'pendiente' => 'Recibido',
                                'confirmada' => 'Confirmado',
                                'preparando' => 'Preparando',
                                'listo_envio' => 'Listo',
                                'enviada' => 'En Camino',
                                'entregada' => 'Entregado',
                                'cancelada' => 'Cancelado',
                                'devuelto' => 'Devuelto'
                            ];
                        ?>
                        <form id="order-<?php echo (int)$order['id']; ?>" method="POST" action="<?php echo e(app_url('admin/updateOrder/' . $order['id'])); ?>">
                            <select name="estado_orden" class="bg-gray-50 border border-gray-100 rounded px-2 py-1.5 text-xs font-medium text-charcoal outline-none focus:border-coral transition-colors w-full max-w-[140px]">
                                <?php foreach ($statusMap as $val => $label): ?>
                                    <option value="<?php echo e($val); ?>" <?php echo ($order['estado_orden'] === $val) ? 'selected' : ''; ?>><?php echo e($label); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </form>
                    </td>
                    <td class="py-4">
                        <select form="order-<?php echo (int)$order['id']; ?>" name="estado_pago" class="bg-gray-50 border border-gray-100 rounded px-2 py-1.5 text-xs font-medium text-charcoal outline-none focus:border-coral transition-colors w-full max-w-[120px]">
                            <?php foreach (['pendiente', 'pagado', 'fallido', 'reembolsado'] as $estado): ?>
                                <option value="<?php echo e($estado); ?>" <?php echo ($order['estado_pago'] === $estado) ? 'selected' : ''; ?>><?php echo e(ucfirst($estado)); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td class="py-4">
                        <button class="btn btn-primary btn-sm !py-2 !px-4" form="order-<?php echo (int)$order['id']; ?>" type="submit">Guardar</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <!-- Pagination -->
    <?php include __DIR__ . '/../_partials/pagination.php'; ?>
</section>
