<section class="page-heading">
    <div>
        <p class="eyebrow">Admin</p>
        <h1>Cupones</h1>
    </div>
    <a class="btn btn-secondary" href="<?php echo e(app_url('admin')); ?>">Panel</a>
</section>

<details class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 mb-8">
    <summary class="font-semibold text-forest-700 cursor-pointer flex items-center gap-2 hover:text-forest-600 transition-colors">
        <i data-lucide="plus-circle" class="w-5 h-5"></i> Crear Nuevo Cupón
    </summary>
    <div class="mt-6 pt-6 border-t border-gray-100">
        <form class="admin-form" method="POST" action="<?php echo e(app_url('admin/saveCoupon')); ?>">
            <div class="form-row">
                <label>Codigo *
                    <input type="text" name="codigo" required placeholder="EJ: FLORES20">
                </label>
                <label>Tipo *
                    <select name="tipo">
                        <option value="porcentaje">Porcentaje (%)</option>
                        <option value="cantidad_fija">Cantidad fija (S/.)</option>
                    </select>
                </label>
                <label>Valor *
                    <input type="number" name="valor" min="0" step="0.01" required>
                </label>
                <label>Compra minima
                    <input type="number" name="valor_minimo_compra" min="0" step="0.01" value="0">
                </label>
                <label>Usos maximos
                    <input type="number" name="usos_maximos" min="1" value="100">
                </label>
            </div>
            <label>Descripcion
                <textarea name="descripcion" rows="2" placeholder="Describe brevemente el beneficio del cupón..."></textarea>
            </label>
            <div class="form-row">
                <label>Inicio *
                    <input type="datetime-local" name="fecha_inicio" required>
                </label>
                <label>Fin *
                    <input type="datetime-local" name="fecha_fin" required>
                </label>
                <label>Estado
                    <select name="estado">
                        <option value="activo">Activo</option>
                        <option value="inactivo">Inactivo</option>
                    </select>
                </label>
            </div>
            <button class="btn btn-primary" type="submit">Guardar Cupón</button>
        </form>
    </div>
</details>

<section class="table-card">
    <div class="px-6 py-4 border-b border-gray-100">
        <h2 class="text-lg font-bold text-charcoal">Cupones Existentes</h2>
    </div>
    <div class="table-scroll">
        <table class="responsive-table">
            <thead>
                <tr>
                    <th>Codigo</th>
                    <th>Tipo</th>
                    <th>Valor</th>
                    <th>Vigencia</th>
                    <th>Usos</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['coupons'] as $coupon): ?>
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="font-bold text-charcoal"><?php echo e($coupon['codigo']); ?></td>
                        <td class="text-xs uppercase tracking-wider text-gray-500"><?php echo e(str_replace('_', ' ', $coupon['tipo'])); ?></td>
                        <td class="font-bold text-coral">
                            <?php echo $coupon['tipo'] === 'porcentaje' ? $coupon['valor'] . '%' : money($coupon['valor']); ?>
                        </td>
                        <td class="text-xs">
                            <div class="flex flex-col">
                                <span><?php echo date('d/m/Y', strtotime($coupon['fecha_inicio'])); ?></span>
                                <span class="text-gray-400">al <?php echo date('d/m/Y', strtotime($coupon['fecha_fin'])); ?></span>
                            </div>
                        </td>
                        <td>
                            <div class="flex flex-col">
                                <span class="font-medium"><?php echo (int)$coupon['usos_actuales']; ?> / <?php echo e($coupon['usos_maximos'] ?? '∞'); ?></span>
                                <div class="w-24 h-1 bg-gray-100 rounded-full mt-1 overflow-hidden">
                                    <?php 
                                        $percent = ($coupon['usos_maximos'] > 0) ? ($coupon['usos_actuales'] / $coupon['usos_maximos']) * 100 : 0;
                                        $percent = min(100, $percent);
                                    ?>
                                    <div class="h-full bg-coral transition-all" style="width: <?php echo $percent; ?>%"></div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge badge-<?php echo e($coupon['estado']); ?>"><?php echo e($coupon['estado']); ?></span>
                        </td>
                        <td class="actions-cell">
                            <?php if ($coupon['estado'] === 'activo'): ?>
                                <a class="btn btn-danger btn-sm" href="<?php echo e(app_url('admin/deleteCoupon/' . $coupon['id'])); ?>" onclick="return confirm('¿Desactivar este cupón?')">Desactivar</a>
                            <?php else: ?>
                                <a class="btn btn-primary btn-sm" href="<?php echo e(app_url('admin/activateCoupon/' . $coupon['id'])); ?>" onclick="return confirm('¿Activar este cupón?')">Activar</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>
