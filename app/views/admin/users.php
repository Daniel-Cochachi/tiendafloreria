<?php /** @var array $data */ ?>
<section class="page-heading">
    <div>
        <p class="eyebrow">Admin</p>
        <h1>Usuarios</h1>
    </div>
    <a class="btn btn-secondary" href="<?php echo e(app_url('admin')); ?>">Panel</a>
</section>

<details class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 mb-8">
    <summary class="font-semibold text-forest-700 cursor-pointer flex items-center gap-2 hover:text-forest-600 transition-colors">
        <i data-lucide="plus-circle" class="w-5 h-5"></i> Registrar Nuevo Usuario
    </summary>
    <div class="mt-6 pt-6 border-t border-gray-100">
        <form class="admin-form" method="POST" action="<?php echo e(app_url('admin/saveUser')); ?>">
            <div class="form-row">
                <label>Nombre *
                    <input type="text" name="nombre" required>
                </label>
                <label>Apellido *
                    <input type="text" name="apellido" required>
                </label>
            </div>
            <div class="form-row">
                <label>Email *
                    <input type="email" name="email" required>
                </label>
                <label>Password *
                    <input type="password" name="password" required>
                </label>
            </div>
            <div class="form-row">
                <label>Telefono
                    <input type="tel" name="telefono">
                </label>
                <label>Documento
                    <input type="text" name="documento" placeholder="DNI / RUC">
                </label>
            </div>
            <div class="form-row">
                <label>Rol *
                    <select name="rol" required>
                        <option value="">Selecciona</option>
                        <option value="admin">Admin</option>
                        <option value="empleado">Empleado</option>
                        <option value="cliente">Cliente</option>
                        <option value="repartidor">Repartidor</option>
                    </select>
                </label>
                <label>Estado
                    <select name="estado">
                        <option value="activo">Activo</option>
                        <option value="inactivo">Inactivo</option>
                    </select>
                </label>
            </div>
            <button class="btn btn-primary" type="submit">Registrar usuario</button>
        </form>
    </div>
</details>

<section class="table-card">
    <h2>Usuarios</h2>
    <div class="table-scroll">
        <table class="responsive-table compact-table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Telefono</th>
                    <th>Documento</th>
                    <th>Estado</th>
                    <th>Fecha registro</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['users'] as $user): ?>
                    <tr>
                        <td><?php echo e($user['nombre'] . ' ' . ($user['apellido'] ?? '')); ?></td>
                        <td><?php echo e($user['email']); ?></td>
                        <td><span class="badge badge-<?php echo e($user['rol']); ?>"><?php echo e($user['rol']); ?></span></td>
                        <td><?php echo e($user['telefono'] ?? '-'); ?></td>
                        <td><?php echo e($user['documento_numero'] ?? '-'); ?></td>
                        <td><span class="badge badge-<?php echo e($user['estado'] ?? 'activo'); ?>"><?php echo e($user['estado'] ?? 'activo'); ?></span></td>
                        <td><?php echo date('d/m/Y', strtotime($user['created_at'] ?? $user['fecha_registro'])); ?></td>
                        <td class="actions-cell">
                            <?php if (($user['estado'] ?? 'activo') === 'activo'): ?>
                                <a class="btn btn-danger" href="<?php echo e(app_url('admin/deleteUser/' . $user['id'])); ?>" onclick="return confirm('¿Desactivar este usuario?')">Desactivar</a>
                            <?php else: ?>
                                <a class="btn btn-primary" href="<?php echo e(app_url('admin/activateUser/' . $user['id'])); ?>" onclick="return confirm('¿Activar este usuario?')">Activar</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (!$data['users']): ?>
                    <tr>
                        <td colspan="8" class="empty-state">No hay usuarios registrados.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <?php include __DIR__ . '/../_partials/pagination.php'; ?>
</section>
