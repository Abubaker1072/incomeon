<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <?php if(get_setting('site_icon')): ?>
        <link rel="icon" href="<?php echo e(uploaded_asset(get_setting('site_icon'))); ?>">
    <?php endif; ?>
    <title><?php echo $__env->yieldContent('auth_title', translate('Sign In')); ?> | <?php echo e(get_setting('site_name')); ?></title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;500;600;700&display=swap">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="<?php echo e(static_asset('assets/css/auth-login.css')); ?>?v=1.2.1">
    <link rel="stylesheet" href="<?php echo e(static_asset('assets/css/responsive-global.css')); ?>?v=1.0.0">
    <link rel="stylesheet" href="<?php echo e(static_asset('assets/modules/account/css/account.css')); ?>?v=1.1.0">
</head>
<body class="auth-body">
    <div class="auth-page-loader is-active" id="auth-page-loader" aria-hidden="false">
        <div class="auth-page-loader__inner">
            <div class="auth-spinner"></div>
            <span><?php echo e(translate('Loading')); ?>...</span>
        </div>
    </div>

    <?php echo $__env->make('modules.account.layouts.partials.flash', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="auth-page">
        <div class="auth-card <?php echo $__env->yieldContent('auth_card_class'); ?>" style="width:min(100%,<?php echo $__env->yieldContent('auth_card_width','960px'); ?>);">
            <div class="auth-card__row">
                <div class="auth-card__hero">
                    <img src="<?php echo e(static_asset('assets/img/auth/login-hero.png')); ?>" alt="<?php echo e(translate('Login')); ?>">
                </div>
                <div class="auth-card__form acc-auth__card" style="width:100%;max-width:none;box-shadow:none;border:none;border-radius:0;">
                    <?php echo $__env->yieldContent('auth_content'); ?>
                </div>
            </div>
            <div class="auth-back">
                <a href="<?php echo e(route('home')); ?>" class="auth-nav-link" data-auth-nav><i class="las la-arrow-left"></i> <?php echo e(translate('Back to Home')); ?></a>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="<?php echo e(static_asset('assets/js/auth-ui.js')); ?>?v=1.0.0"></script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\laragon\www\Incomeon_ecomm\resources\views/modules/account/layouts/auth.blade.php ENDPATH**/ ?>