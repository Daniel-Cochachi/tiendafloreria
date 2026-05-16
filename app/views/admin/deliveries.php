<section class="page-heading">
    <div>
        <p class="eyebrow">Admin</p>
        <h1>Entregas</h1>
    </div>
    <a class="btn btn-secondary" href="<?php echo e(app_url('admin')); ?>">Panel</a>
</section>

<section class="table-card">
    <div class="table-scroll">
        <table class="responsive-table compact-table">
            <thead>
                <tr>
                    <th>Orden</th>
                    <th>Cliente</th>
                    <th>Repartidor</th>
                    <th>Estado entrega</th>
                    <th>Fecha asignacion</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['deliveries'] as $delivery): ?>
                    <tr>
                        <td>
                            <a href="<?php echo e(app_url('orders/detail/' . $delivery['orden_id'])); ?>"><?php echo e($delivery['numero_orden']); ?></a>
                        </td>
                        <td><?php echo e($delivery['cliente_nombre'] . ' ' . ($delivery['cliente_apellido'] ?? '')); ?></td>
                        <td>
                            <?php if (!empty($delivery['repartidor_nombre'])): ?>
                                <?php echo e($delivery['repartidor_nombre']); ?>
                            <?php else: ?>
                                <span class="muted">Sin asignar</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span class="badge badge-<?php echo e($delivery['estado_entrega'] ?? 'pendiente'); ?>">
                                <?php echo e(str_replace('_', ' ', $delivery['estado_entrega'] ?? 'pendiente')); ?>
                            </span>
                        </td>
                        <td>
                            <?php if (!empty($delivery['fecha_asignacion'])): ?>
                                <?php echo date('d/m/Y', strtotime($delivery['fecha_asignacion'])); ?>
                            <?php else: ?>
                                <span class="muted">-</span>
                            <?php endif; ?>
                        </td>
                        <td class="actions-cell">
                            <form id="delivery-<?php echo (int)$delivery['id']; ?>" method="POST" action="<?php echo e(app_url('admin/updateDelivery/' . $delivery['id'])); ?>" class="inline-edit">
                                <select name="repartidor_id">
                                    <option value="">Asignar repartidor</option>
                                    <?php foreach ($data['repartidores'] as $repartidor): ?>
                                        <option value="<?php echo (int)$repartidor['id']; ?>" <?php echo ($delivery['repartidor_id'] ?? null) == $repartidor['id'] ? 'selected' : ''; ?>>
                                            <?php echo e($repartidor['nombre'] . ' ' . ($repartidor['apellido'] ?? '')); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <select name="estado_entrega">
                                    <?php foreach (['pendiente', 'asignado', 'en_camino', 'entregado', 'fallido', 'devuelto'] as $st): ?>
                                        <option value="<?php echo e($st); ?>" <?php echo ($delivery['estado_entrega'] === $st) ? 'selected' : ''; ?>>
                                            <?php echo e(str_replace('_', ' ', $st)); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <button class="btn btn-primary" type="submit">Actualizar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (!$data['deliveries']): ?>
                    <tr>
                        <td colspan="6" class="empty-state">No hay entregas registradas.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>
