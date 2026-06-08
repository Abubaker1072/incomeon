<!DOCTYPE html>
<?php $rtl = get_session_language()->rtl ?? 0; ?>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" <?php if($rtl): ?> dir="rtl" <?php endif; ?>>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="app-url" content="<?php echo e(getBaseURL()); ?>">
    <title><?php echo $__env->yieldContent('meta_title', get_setting('website_name') . ' | ' . get_setting('site_motto')); ?></title>
    <meta name="description" content="<?php echo $__env->yieldContent('meta_description', get_setting('meta_description')); ?>">
    <?php echo $__env->yieldContent('meta'); ?>
    <link rel="icon" href="<?php echo e(uploaded_asset(get_setting('site_icon'))); ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="<?php echo e(static_asset('assets/modules/marketplace/css/marketplace.css')); ?>?v=2.3.0">
    <link rel="stylesheet" href="<?php echo e(static_asset('assets/css/responsive-global.css')); ?>?v=1.0.0">
    <style>:root {
        --mp-primary: <?php echo e(get_setting('base_color', '#2557aa')); ?>;
        --mp-primary-dark: color-mix(in srgb, <?php echo e(get_setting('base_color', '#2557aa')); ?> 82%, #000);
        --mp-accent: #00b4d8;
        --mp-accent-glow: rgba(0, 180, 216, 0.35);
    }</style>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="mp-body">
    <?php echo $__env->make('modules.marketplace.layouts.partials.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <main>
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <?php echo $__env->make('modules.marketplace.layouts.partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <script src="<?php echo e(static_asset('assets/modules/marketplace/js/marketplace.js')); ?>?v=2.2.0"></script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
    <?php if(Route::currentRouteName() == 'home'): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const token = document.querySelector('meta[name="csrf-token"]').content;
            const sections = [
                { url: '<?php echo e(route('home.section.todays_deal')); ?>', el: '#mp-todays-deal' },
                { url: '<?php echo e(route('home.section.featured')); ?>', el: '#mp-featured' },
                { url: '<?php echo e(route('home.section.best_selling')); ?>', el: '#mp-best-selling' },
                { url: '<?php echo e(route('home.section.newest_products')); ?>', el: '#mp-new-arrivals' },
                { url: '<?php echo e(route('home.section.best_sellers')); ?>', el: '#mp-popular-stores' },
            ];
            sections.forEach(function (s) {
                const target = document.querySelector(s.el);
                if (!target) return;
                fetch(s.url, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': token, 'Accept': 'text/html' },
                }).then(r => r.text()).then(html => { target.innerHTML = html; }).catch(() => {});
            });
        });
    </script>
    <?php endif; ?>
</body>
</html>
<?php /**PATH C:\laragon\www\Incomeon_ecomm\resources\views/modules/marketplace/layouts/app.blade.php ENDPATH**/ ?>