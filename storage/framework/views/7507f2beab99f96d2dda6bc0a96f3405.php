

<?php $__env->startSection('content'); ?>

    <?php echo $__env->make('auth.'.get_setting('authentication_layout_select').'.admin_login', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script type="text/javascript">
        function autoFillAdmin(){
            $('#email').val('admin@example.com');
            $('#password').val('123456');
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('auth.layouts.authentication', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\Incomeon_ecomm\resources\views/auth/login.blade.php ENDPATH**/ ?>