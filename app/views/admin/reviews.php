<section class="page-heading">
    <div>
        <p class="eyebrow">Admin</p>
        <h1>Resenas pendientes</h1>
    </div>
    <a class="btn btn-secondary" href="<?php echo e(app_url('admin')); ?>">Panel</a>
</section>

<section class="panel">
    <div class="list-stack">
        <?php foreach ($data['reviews'] as $review): ?>
            <article class="review-item">
                <div class="split-header">
                    <div>
                        <strong><?php echo e($review['producto_nombre']); ?></strong>
                        <p class="flex items-center gap-1.5">
                            <?php echo e($review['usuario_nombre']); ?>
                            <span class="stars inline-flex items-center gap-0.5">
                                <?php for ($i = 0; $i < 5; $i++): ?>
                                    <i data-lucide="star" class="w-3.5 h-3.5 <?php echo $i < (int)$review['calificacion'] ? 'fill-gold text-gold' : 'text-gray-200'; ?>"></i>
                                <?php endfor; ?>
                            </span>
                        </p>
                    </div>
                    <div class="heading-actions">
                        <a class="btn btn-primary" href="<?php echo e(app_url('admin/approveReview/' . $review['id'])); ?>">Aprobar</a>
                        <a class="btn btn-danger" href="<?php echo e(app_url('admin/rejectReview/' . $review['id'])); ?>">Rechazar</a>
                    </div>
                </div>
                <h2><?php echo e($review['titulo']); ?></h2>
                <p><?php echo nl2br(e($review['comentario'])); ?></p>
            </article>
        <?php endforeach; ?>

        <?php if (!$data['reviews']): ?>
            <div class="empty-state">
                <h2>No hay resenas pendientes</h2>
                <p>Las nuevas resenas apareceran aqui antes de publicarse.</p>
            </div>
        <?php endif; ?>
    </div>
</section>
