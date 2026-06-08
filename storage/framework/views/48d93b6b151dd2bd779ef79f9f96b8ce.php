<?php $__env->startSection('meta_title', ($page->getTranslation('title') ?? translate('Policy')) . ' | ' . get_setting('website_name')); ?>

<?php $__env->startSection('content'); ?>
<section class="mp-section mp-section--white">
    <div class="mp-container mp-policy-page">
        <h1 class="mp-policy-page__title"><?php echo e($page->getTranslation('title')); ?></h1>
        <div class="mp-policy-page__content">
            <?php echo $page->getTranslation('content'); ?>

        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('modules.marketplace.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\Incomeon_ecomm\resources\views/modules/marketplace/pages/policies/policy.blade.php ENDPATH**/ ?>