<section class="hero">
    <div class="hero-watermark" aria-hidden="true">404</div>
    <div class="hero-content">
        <p class="eyebrow">Error 404</p>
        <h1>Pagina no <span class="text-gold">encontrada</span></h1>
        <p class="hero-desc"><?php echo e($message ?? 'La pagina solicitada no existe.'); ?></p>
        <div class="hero-actions">
            <a class="btn btn-primary" href="<?php echo e(app_url()); ?>">Volver al inicio</a>
            <a class="btn btn-light" href="<?php echo e(app_url('contact')); ?>">Contactanos</a>
        </div>
    </div>
</section>
