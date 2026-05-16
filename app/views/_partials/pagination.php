<?php
/**
 * Reusable Pagination Partial
 * Expected variables:
 * - $data['current_page']
 * - $data['total_pages']
 * - $data['pagination_base_url'] (e.g., 'admin/products')
 */
?>
<?php if (isset($data['total_pages']) && $data['total_pages'] > 1): ?>
<div class="mt-8 flex items-center justify-center gap-2">
    <?php 
    $base_url = $data['pagination_base_url'] ?? '';
    $current = $data['current_page'];
    $total = $data['total_pages'];
    ?>

    <?php if ($current > 1): ?>
        <a href="<?php echo e(app_url($base_url, ['page' => $current - 1])); ?>" class="w-10 h-10 flex items-center justify-center rounded-lg border border-gray-200 bg-white text-charcoal hover:border-coral hover:text-coral transition-all shadow-sm">
            <i data-lucide="chevron-left" class="w-4 h-4"></i>
        </a>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $total; $i++): ?>
        <?php if ($i == 1 || $i == $total || ($i >= $current - 1 && $i <= $current + 1)): ?>
            <a href="<?php echo e(app_url($base_url, ['page' => $i])); ?>" 
               class="w-10 h-10 flex items-center justify-center rounded-lg border <?php echo $i == $current ? 'border-coral bg-coral text-white shadow-md' : 'border-gray-200 bg-white text-charcoal hover:border-coral hover:text-coral shadow-sm'; ?> transition-all font-bold text-sm">
                <?php echo $i; ?>
            </a>
        <?php elseif ($i == 2 || $i == $total - 1): ?>
            <span class="text-gray-400 px-1">...</span>
        <?php endif; ?>
    <?php endfor; ?>

    <?php if ($current < $total): ?>
        <a href="<?php echo e(app_url($base_url, ['page' => $current + 1])); ?>" class="w-10 h-10 flex items-center justify-center rounded-lg border border-gray-200 bg-white text-charcoal hover:border-coral hover:text-coral transition-all shadow-sm">
            <i data-lucide="chevron-right" class="w-4 h-4"></i>
        </a>
    <?php endif; ?>
</div>
<?php endif; ?>
