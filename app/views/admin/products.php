<?php /** @var array $data */ ?>
<section class="page-heading">
    <div>
        <p class="eyebrow">Admin</p>
        <h1>Productos</h1>
    </div>
    <a class="btn btn-secondary" href="<?php echo e(app_url('admin')); ?>">Panel</a>
</section>

<details class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 mb-8">
    <summary class="font-semibold text-forest-700 cursor-pointer flex items-center gap-2 hover:text-forest-600 transition-colors">
        <i data-lucide="plus-circle" class="w-5 h-5"></i> Crear Nuevo Producto
    </summary>
    <div class="mt-6 pt-6 border-t border-gray-100">
        <form class="admin-form" method="POST" action="<?php echo e(app_url('admin/saveProduct')); ?>">
            <div class="form-row">
                <label>Categoria
                    <select name="categoria_id" required>
                        <?php foreach ($data['categories'] as $category): ?>
                            <option value="<?php echo (int)$category['id']; ?>"><?php echo e($category['nombre']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </label>
                <label>Nombre
                    <input type="text" name="nombre" required>
                </label>
                <label>SKU
                    <input type="text" name="codigo_sku" required>
                </label>
            </div>
            <label>Descripcion
                <textarea name="descripcion" rows="2"></textarea>
            </label>
            <div class="form-row">
                <label>Precio
                    <input type="number" name="precio_unitario" min="0" step="0.01" required>
                </label>
                <label>Descuento %
                    <input type="number" name="descuento_porcentaje" min="0" max="100" step="0.01" value="0">
                </label>
                <label>Precio final
                    <input type="number" name="precio_final" min="0" step="0.01">
                </label>
                <label>Stock
                    <input type="number" name="stock" min="0" value="0">
                </label>
                <label>Stock minimo
                    <input type="number" name="stock_minimo" min="0" value="10">
                </label>
            </div>
            <div class="form-row">
                <label>Tipo
                    <select name="tipo_producto">
                        <option value="flor_individual">Flor individual</option>
                        <option value="arreglo">Arreglo</option>
                        <option value="ramo">Ramo</option>
                        <option value="combo">Combo</option>
                    </select>
                </label>
                <label>Imagen
                    <input type="text" name="imagen_principal" placeholder="rosa-roja.jpg">
                </label>
                <label>Duracion dias
                    <input type="number" name="duracion_dias" min="0" value="10">
                </label>
                <label>Estado
                    <select name="estado">
                        <option value="activo">Activo</option>
                        <option value="inactivo">Inactivo</option>
                        <option value="descontinuado">Descontinuado</option>
                    </select>
                </label>
            </div>
            <label>Cuidados
                <textarea name="cuidados" rows="2"></textarea>
            </label>
            <button class="btn btn-primary" type="submit">Guardar Producto</button>
        </form>
    </div>
</details>

<section class="panel">
    <h2>Inventario</h2>
    <div class="table-scroll">
        <table class="responsive-table compact-table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Categoria</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['products'] as $product): ?>
                    <tr>
                        <td>
                            <form id="product-<?php echo (int)$product['id']; ?>" method="POST" action="<?php echo e(app_url('admin/saveProduct/' . $product['id'])); ?>" class="inline-edit">
                                <input type="hidden" name="categoria_id" value="<?php echo (int)$product['categoria_id']; ?>">
                                <input type="hidden" name="descripcion" value="<?php echo e($product['descripcion']); ?>">
                                <input type="hidden" name="descuento_porcentaje" value="<?php echo e($product['descuento_porcentaje']); ?>">
                                <input type="hidden" name="precio_final" value="<?php echo e($product['precio_final']); ?>">
                                <input type="hidden" name="imagen_principal" value="<?php echo e($product['imagen_principal']); ?>">
                                <input type="hidden" name="stock_minimo" value="<?php echo e($product['stock_minimo']); ?>">
                                <input type="hidden" name="tipo_producto" value="<?php echo e($product['tipo_producto']); ?>">
                                <input type="hidden" name="duracion_dias" value="<?php echo e($product['duracion_dias']); ?>">
                                <input type="hidden" name="cuidados" value="<?php echo e($product['cuidados']); ?>">
                                <input name="nombre" value="<?php echo e($product['nombre']); ?>">
                                <input name="codigo_sku" value="<?php echo e($product['codigo_sku']); ?>">
                            </form>
                        </td>
                        <td><?php echo e($product['categoria_nombre']); ?></td>
                        <td><input form="product-<?php echo (int)$product['id']; ?>" type="number" name="precio_unitario" min="0" step="0.01" value="<?php echo e($product['precio_unitario']); ?>"></td>
                        <td><input form="product-<?php echo (int)$product['id']; ?>" type="number" name="stock" min="0" value="<?php echo (int)$product['stock']; ?>"></td>
                        <td>
                            <select form="product-<?php echo (int)$product['id']; ?>" name="estado">
                                <?php foreach (['activo', 'inactivo', 'descontinuado'] as $estado): ?>
                                    <option value="<?php echo e($estado); ?>" <?php echo ($product['estado'] === $estado) ? 'selected' : ''; ?>><?php echo e($estado); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td class="actions-cell">
                            <button class="btn btn-primary" form="product-<?php echo (int)$product['id']; ?>" type="submit">Guardar</button>
                            <a class="btn btn-danger" href="<?php echo e(app_url('admin/deleteProduct/' . $product['id'])); ?>" onclick="return confirm('Desactivar producto?')">Desactivar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <?php include __DIR__ . '/../_partials/pagination.php'; ?>
</section>
