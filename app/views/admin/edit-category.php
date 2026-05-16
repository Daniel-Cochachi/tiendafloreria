<?php /** @var array $data */ ?>
<section class="page-heading">
    <div>
        <p class="eyebrow">Admin</p>
        <h1>Editar Categoria</h1>
    </div>
    <a class="btn btn-secondary" href="<?php echo e(app_url('admin/categories')); ?>">Volver</a>
</section>

<section class="panel">
    <form class="admin-form" method="POST" action="<?php echo e(app_url('admin/saveCategory')); ?>">
        <input type="hidden" name="id" value="<?php echo (int)$data['category']['id']; ?>">
        <div class="form-row">
            <label>Nombre *
                <input type="text" name="nombre" value="<?php echo e($data['category']['nombre']); ?>" required>
            </label>
            <label>Imagen
                <input type="text" name="imagen" value="<?php echo e($data['category']['imagen'] ?? ''); ?>" placeholder="categoria.jpg">
            </label>
        </div>
        <label>Descripcion
            <textarea name="descripcion" rows="2"><?php echo e($data['category']['descripcion'] ?? ''); ?></textarea>
        </label>
        <button class="btn btn-primary" type="submit">Guardar cambios</button>
    </form>
</section>
