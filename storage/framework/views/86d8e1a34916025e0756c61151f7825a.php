<?php $__currentLoopData = session('flash_notification', collect()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $flash): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="mp-container" style="padding-top:1rem;">
        <div class="acc-flash acc-flash--<?php echo e($flash['level'] === 'danger' ? 'danger' : ($flash['level'] === 'warning' ? 'warning' : 'success')); ?>">
            <?php echo e($flash['message']); ?>

        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php if($errors->any()): ?>
    <div class="mp-container" style="padding-top:1rem;">
        <div class="acc-flash acc-flash--danger">
            <ul style="margin:0;padding-left:1.25rem;">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    </div>
<?php endif; ?>
<?php /**PATH C:\laragon\www\Incomeon_ecomm\resources\views/modules/account/layouts/partials/flash.blade.php ENDPATH**/ ?>