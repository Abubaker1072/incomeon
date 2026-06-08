<?php if(get_setting('vendor_system_activation') == 1 && count(get_best_sellers(12)) > 0): ?>
    <div class="mp-section__head">
        <h2 class="mp-section__title"><?php echo e(translate('Popular Stores')); ?></h2>
        <a href="<?php echo e(route('sellers')); ?>" class="mp-section__link"><?php echo e(translate('View All')); ?></a>
    </div>
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:1rem;">
        <?php $__currentLoopData = get_best_sellers(12); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $seller): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php echo $__env->make('modules.marketplace.components.store-card', ['seller' => $seller], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php endif; ?>
<?php /**PATH C:\laragon\www\Incomeon_ecomm\resources\views/modules/marketplace/partials/home/popular-stores.blade.php ENDPATH**/ ?>