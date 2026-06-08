<?php if(count($newest_products) > 0): ?>
    <?php echo $__env->make('modules.marketplace.components.product-slider', [
        'title' => translate('New Arrivals'),
        'products' => $newest_products,
        'view_all_url' => route('search', ['sort_by' => 'newest']),
    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\Incomeon_ecomm\resources\views/modules/marketplace/partials/home/newest-products.blade.php ENDPATH**/ ?>