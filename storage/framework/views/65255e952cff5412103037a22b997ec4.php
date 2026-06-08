<?php
    $social_links = [
        'facebook' => get_setting('facebook_link'),
        'instagram' => get_setting('instagram_link'),
        'youtube' => get_setting('youtube_link'),
        'linkedin' => get_setting('linkedin_link'),
    ];
    $has_social = get_setting('show_social_links') == 'on' && collect($social_links)->filter()->isNotEmpty();
?>
<?php echo $__env->make('modules.marketplace.layouts.partials.policy-ribbon', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<footer class="mp-footer">
    <div class="mp-container">
        <div class="mp-footer__top">
            <div class="mp-footer__brand">
                <a href="<?php echo e(route('home')); ?>" class="mp-footer__logo">
                    <?php if(get_setting('footer_logo') || get_setting('header_logo')): ?>
                        <img src="<?php echo e(uploaded_asset(get_setting('footer_logo') ?: get_setting('header_logo'))); ?>" alt="<?php echo e(get_setting('website_name')); ?>">
                    <?php else: ?>
                        <span class="mp-footer__logo-text"><?php echo e(get_setting('website_name')); ?></span>
                    <?php endif; ?>
                </a>
                <p class="mp-footer__motto"><?php echo e(get_setting('site_motto')); ?></p>
                <div class="mp-footer__newsletter">
                    <p><?php echo e(translate('Subscribe to our newsletter for regular updates about Offers, Coupons & more')); ?></p>
                    <form action="<?php echo e(route('subscribers.store')); ?>" method="POST" class="mp-footer__newsletter-form">
                        <?php echo csrf_field(); ?>
                        <input type="email" name="email" placeholder="<?php echo e(translate('Your Email Address')); ?>" required>
                        <button type="submit" class="mp-btn mp-btn--primary"><?php echo e(translate('Subscribe')); ?></button>
                    </form>
                </div>
            </div>
            <?php if($has_social): ?>
                <div class="mp-footer__social">
                    <h4><?php echo e(translate('FOLLOW US')); ?></h4>
                    <div class="mp-footer__social-icons">
                        <?php if($social_links['facebook']): ?>
                            <a href="<?php echo e($social_links['facebook']); ?>" target="_blank" rel="noopener" class="mp-footer__social-icon mp-footer__social-icon--fb" title="Facebook"><i class="lab la-facebook-f"></i></a>
                        <?php endif; ?>
                        <?php if($social_links['instagram']): ?>
                            <a href="<?php echo e($social_links['instagram']); ?>" target="_blank" rel="noopener" class="mp-footer__social-icon mp-footer__social-icon--ig" title="Instagram"><i class="lab la-instagram"></i></a>
                        <?php endif; ?>
                        <?php if($social_links['youtube']): ?>
                            <a href="<?php echo e($social_links['youtube']); ?>" target="_blank" rel="noopener" class="mp-footer__social-icon mp-footer__social-icon--yt" title="YouTube"><i class="lab la-youtube"></i></a>
                        <?php endif; ?>
                        <?php if($social_links['linkedin']): ?>
                            <a href="<?php echo e($social_links['linkedin']); ?>" target="_blank" rel="noopener" class="mp-footer__social-icon mp-footer__social-icon--li" title="LinkedIn"><i class="lab la-linkedin-in"></i></a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div class="mp-footer__columns">
            <div class="mp-footer__col">
                <h4><?php echo e(translate('QUICK LINKS')); ?></h4>
                <ul>
                    <li><a href="<?php echo e(route('supportpolicy')); ?>"><?php echo e(translate('Support Policy')); ?></a></li>
                    <li><a href="<?php echo e(route('returnpolicy')); ?>"><?php echo e(translate('Return Policy')); ?></a></li>
                    <li><a href="<?php echo e(url('/about-us')); ?>"><?php echo e(translate('About Us')); ?></a></li>
                    <li><a href="<?php echo e(route('privacypolicy')); ?>"><?php echo e(translate('Privacy Policy')); ?></a></li>
                    <li><a href="<?php echo e(route('sellerpolicy')); ?>"><?php echo e(translate('Seller Policy')); ?></a></li>
                    <li><a href="<?php echo e(route('terms')); ?>"><?php echo e(translate('Terms & Conditions')); ?></a></li>
                </ul>
            </div>
            <div class="mp-footer__col">
                <h4><?php echo e(translate('CONTACTS')); ?></h4>
                <ul>
                    <?php if(get_setting('helpline_number')): ?>
                        <li><i class="las la-phone"></i> <?php echo e(translate('UAN')); ?>: <?php echo e(get_setting('helpline_number')); ?></li>
                    <?php endif; ?>
                    <?php if(get_setting('contact_email')): ?>
                        <li><i class="las la-envelope"></i> <a href="mailto:<?php echo e(get_setting('contact_email')); ?>"><?php echo e(get_setting('contact_email')); ?></a></li>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="mp-footer__col">
                <h4><?php echo e(translate('MY ACCOUNT')); ?></h4>
                <ul>
                    <?php if(auth()->guard()->check()): ?>
                        <li><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(translate('My Account')); ?></a></li>
                    <?php else: ?>
                        <li><a href="<?php echo e(route('user.login')); ?>"><?php echo e(translate('Login')); ?></a></li>
                    <?php endif; ?>
                    <li><a href="<?php echo e(route('purchase_history.index')); ?>"><?php echo e(translate('Order History')); ?></a></li>
                    <li><a href="<?php echo e(route('wishlists.index')); ?>"><?php echo e(translate('My Wishlist')); ?></a></li>
                    <li><a href="<?php echo e(route('orders.track')); ?>"><?php echo e(translate('Track Order')); ?></a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="mp-footer__bar">
        <div class="mp-container">
            <?php
                $site_label = get_setting('website_name');
                if (filter_var($site_label, FILTER_VALIDATE_URL)) {
                    $site_label = config('app.name', 'Get Technologies');
                }
            ?>
            <p><?php echo e(translate('All rights reserved.')); ?> <?php echo e(translate('Copyright')); ?> &copy; <?php echo e(date('Y')); ?>-<?php echo e(date('y', strtotime('+1 year'))); ?> <?php echo e($site_label); ?>.</p>
        </div>
    </div>
</footer>

<div class="mp-side-fab" aria-label="<?php echo e(translate('Quick actions')); ?>">
    <button type="button" class="mp-side-fab__btn" id="mp-side-menu" title="<?php echo e(translate('Menu')); ?>"><i class="las la-bars"></i></button>
    <a href="<?php echo e(route('flash-deals')); ?>" class="mp-side-fab__btn" title="<?php echo e(translate('Flash Sale')); ?>"><i class="las la-bolt"></i></a>
    <a href="<?php echo e(route('orders.track')); ?>" class="mp-side-fab__btn" title="<?php echo e(translate('Track Order')); ?>"><i class="las la-clock"></i></a>
</div>

<?php if(get_setting('whatsapp_link')): ?>
    <a href="<?php echo e(get_setting('whatsapp_link')); ?>" class="mp-whatsapp-fab" target="_blank" rel="noopener" title="WhatsApp">
        <i class="lab la-whatsapp"></i>
    </a>
<?php endif; ?>
<?php /**PATH C:\laragon\www\Incomeon_ecomm\resources\views/modules/marketplace/layouts/partials/footer.blade.php ENDPATH**/ ?>