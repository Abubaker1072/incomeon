<?php if(count(get_featured_products()) > 0): ?>
    <?php echo $__env->make('modules.marketplace.components.product-slider', [
        'title' => translate('Featured Products'),
        'products' => get_featured_products(),
        'view_all_url' => route('search'),
    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\Incomeon_ecomm\resources\views/modules/marketplace/partials/home/featured-products.blade.php ENDPATH**/ ?>