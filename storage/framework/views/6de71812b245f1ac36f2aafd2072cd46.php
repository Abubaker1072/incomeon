<?php if(count($todays_deal_products) > 0): ?>
    <?php echo $__env->make('modules.marketplace.components.product-slider', [
        'title' => translate("Today's Deal"),
        'products' => $todays_deal_products,
        'view_all_url' => route('todays-deal'),
    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\Incomeon_ecomm\resources\views/modules/marketplace/partials/home/todays-deal.blade.php ENDPATH**/ ?>