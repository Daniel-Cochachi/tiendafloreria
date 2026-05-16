<section class="page-heading">
    <div>
        <p class="eyebrow">Admin</p>
        <h1>Categorias</h1>
    </div>
    <a class="btn btn-secondary" href="<?php echo e(app_url('admin')); ?>">Panel</a>
</section>

<details class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 mb-8">
    <summary class="font-semibold text-forest-700 cursor-pointer flex items-center gap-2 hover:text-forest-600 transition-colors">
        <i data-lucide="plus-circle" class="w-5 h-5"></i> Crear Nueva Categoría
    </summary>
    <div class="mt-6 pt-6 border-t border-gray-100">
        <form class="admin-form" method="POST" action="<?php echo e(app_url('admin/saveCategory')); ?>">
            <div class="form-row">
                <label>Nombre *
                    <input type="text" name="nombre" required>
                </label>
                <label>Imagen
                    <input type="text" name="imagen" placeholder="categoria.jpg">
                </label>
            </div>
            <label>Descripcion
                <textarea name="descripcion" rows="2"></textarea>
            </label>
            <button class="btn btn-primary" type="submit">Guardar Categoría</button>
        </form>
    </div>
</details>

<section class="table-card">
    <h2>Listado</h2>
    <div class="table-scroll">
        <table class="responsive-table compact-table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Descripcion</th>
                    <th>Productos</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['categories'] as $category): ?>
                    <tr>
                        <td><?php echo e($category['nombre']); ?></td>
                        <td><?php echo e($category['descripcion'] ?? '-'); ?></td>
                        <td><?php echo (int)($category['producto_count'] ?? 0); ?></td>
                        <td><span class="badge badge-<?php echo e($category['estado'] ?? 'activo'); ?>"><?php echo e($category['estado'] ?? 'activo'); ?></span></td>
                        <td class="actions-cell">
                            <a class="btn btn-primary" href="<?php echo e(app_url('admin/editCategory/' . $category['id'])); ?>">Editar</a>
                            <?php if (($category['estado'] ?? 'activo') === 'activo'): ?>
                                <a class="btn btn-danger" href="<?php echo e(app_url('admin/deleteCategory/' . $category['id'])); ?>" onclick="return confirm('¿Desactivar esta categoría?')">Desactivar</a>
                            <?php else: ?>
                                <a class="btn btn-primary !bg-forest-600" href="<?php echo e(app_url('admin/activateCategory/' . $category['id'])); ?>" onclick="return confirm('¿Activar esta categoría?')">Activar</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (!$data['categories']): ?>
                    <tr>
                        <td colspan="5" class="empty-state">No hay categorias registradas.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>
