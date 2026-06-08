<?php
    $user = auth()->user();
    $cart_count = count(get_user_cart());
    $nav_categories = \App\Models\Category::with(['catIcon'])
        ->where('level', 0)->orderBy('order_level', 'desc')->take(20)->get();
    $menu_labels = get_setting('header_menu_labels') ? json_decode(get_setting('header_menu_labels'), true) : [];
    $menu_links = get_setting('header_menu_links') ? json_decode(get_setting('header_menu_links'), true) : [];
?>

<div class="mp-promo">
    <div class="mp-container">
        <?php echo e(translate('Free shipping on orders over')); ?> $50
        <a href="<?php echo e(route('search')); ?>"><?php echo e(translate('Shop now')); ?> &rarr;</a>
        <?php if(get_setting('helpline_number')): ?>
            &nbsp;|&nbsp; <?php echo e(translate('Call')); ?>: <strong><?php echo e(get_setting('helpline_number')); ?></strong>
        <?php endif; ?>
    </div>
</div>

<header class="mp-header">
    <div class="mp-container mp-header__inner">
        <button type="button" class="mp-mobile-toggle" id="mp-mobile-toggle" aria-expanded="false" aria-controls="mp-main-nav" aria-label="<?php echo e(translate('Menu')); ?>">
            <i class="las la-bars"></i>
        </button>
        <a href="<?php echo e(route('home')); ?>" class="mp-logo">
            <?php if(get_setting('header_logo')): ?>
                <img src="<?php echo e(uploaded_asset(get_setting('header_logo'))); ?>" alt="<?php echo e(get_setting('website_name')); ?>">
            <?php else: ?>
                <strong><?php echo e(get_setting('website_name')); ?></strong>
            <?php endif; ?>
        </a>
        <div class="mp-search">
            <?php echo $__env->make('modules.marketplace.components.search-bar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div class="mp-header__actions">
            <?php if(auth()->guard()->check()): ?>
                <a href="<?php echo e(route('dashboard')); ?>" class="mp-btn mp-btn--outline"><i class="las la-user"></i> <span><?php echo e($user->name); ?></span></a>
            <?php else: ?>
                <a href="<?php echo e(route('user.login')); ?>" class="mp-btn mp-btn--dark"><i class="las la-user"></i> <span><?php echo e(translate('Sign In')); ?></span></a>
            <?php endif; ?>
            <a href="<?php echo e(route('wishlists.index')); ?>" class="mp-btn mp-btn--outline" title="<?php echo e(translate('Wishlist')); ?>">
                <i class="las la-heart"></i>
                <span id="mp-wishlist-count"><?php if(auth()->guard()->check()): ?><?php echo e(get_user_wishlist()->count()); ?><?php else: ?> 0 <?php endif; ?></span>
            </a>
            <a href="<?php echo e(route('cart')); ?>" class="mp-btn mp-btn--primary" title="<?php echo e(translate('Cart')); ?>">
                <i class="las la-shopping-cart"></i> <span><?php echo e($cart_count); ?></span>
            </a>
        </div>
    </div>
    <nav class="mp-nav mp-nav--primary" id="mp-main-nav">
        <div class="mp-container mp-nav__inner">
            <div class="mp-nav-categories" id="mp-nav-categories">
                <button type="button" class="mp-nav-categories__trigger" aria-expanded="false" aria-controls="mp-nav-categories-panel">
                    <span class="mp-nav-categories__label"><?php echo e(translate('Categories')); ?></span>
                    <span class="mp-nav-categories__see-all">(<?php echo e(translate('See All')); ?>)</span>
                    <i class="las la-angle-down mp-nav-categories__chevron" aria-hidden="true"></i>
                </button>
                <div class="mp-nav-categories__panel" id="mp-nav-categories-panel">
                    <?php echo $__env->make('modules.marketplace.components.category-sidebar-nav', ['nav_categories' => $nav_categories], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
            <div class="mp-nav__links" id="mp-nav-links">
                <?php if(!empty($menu_labels)): ?>
                    <?php $__currentLoopData = $menu_labels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e($menu_links[$key] ?? '#'); ?>" class="mp-nav-link mp-nav-link--menu"><?php echo e(translate($label)); ?></a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <a href="<?php echo e(route('home')); ?>" class="mp-nav-link mp-nav-link--menu"><?php echo e(translate('Home')); ?></a>
                    <a href="<?php echo e(route('flash-deals')); ?>" class="mp-nav-link mp-nav-link--menu"><?php echo e(translate('Flash Sale')); ?></a>
                    <a href="<?php echo e(route('brands.all')); ?>" class="mp-nav-link mp-nav-link--menu"><?php echo e(translate('Brand')); ?></a>
                    <a href="<?php echo e(route('supportpolicy')); ?>" class="mp-nav-link mp-nav-link--menu"><?php echo e(translate('Service & Support')); ?></a>
                    <a href="<?php echo e(url('/contact-us')); ?>" class="mp-nav-link mp-nav-link--menu"><?php echo e(translate('Contact US')); ?></a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
</header>
<div class="mp-nav-overlay" id="mp-nav-overlay" aria-hidden="true"></div>
<?php /**PATH C:\laragon\www\Incomeon_ecomm\resources\views/modules/marketplace/layouts/partials/header.blade.php ENDPATH**/ ?>