

<?php $__env->startSection('content'); ?>
    <?php if(auth()->user()->can('smtp_settings') && env('MAIL_USERNAME') == null && env('MAIL_PASSWORD') == null): ?>
        <div class="alert alert-info d-flex align-items-center flex-wrap adm-dash-alert">
            <?php echo e(translate('Please Configure SMTP Setting to work all email sending functionality')); ?>,
            <a class="alert-link ml-2" href="<?php echo e(route('smtp_settings.index')); ?>"><?php echo e(translate('Configure Now')); ?></a>
        </div>
    <?php endif; ?>

    <?php if(in_array(auth()->user()->user_type, ['admin', 'staff'])): ?>
        <div class="adm-dash">
            <div class="adm-dash__head">
                <div>
                    <div class="adm-dash__kicker"><?php echo e(translate('Overview')); ?></div>
                    <h1 class="adm-dash__title"><?php echo e(translate('Dashboard')); ?></h1>
                    <p class="adm-dash__subtitle"><?php echo e(translate('Welcome back')); ?>, <?php echo e(auth()->user()->name); ?> — <?php echo e(translate("here's what's happening today")); ?></p>
                </div>
                <div class="adm-dash__head-actions">
                    <span class="adm-live-badge"><span class="adm-live-dot"></span> <?php echo e(translate('Live')); ?></span>
                    <a href="<?php echo e(route('all_orders.index')); ?>" class="adm-dash-btn adm-dash-btn--ghost"><i class="las la-external-link-alt"></i> <?php echo e(translate('View Orders')); ?></a>
                    <a href="<?php echo e(route('products.create')); ?>" class="adm-dash-btn adm-dash-btn--primary"><i class="las la-plus"></i> <?php echo e(translate('Add Product')); ?></a>
                </div>
            </div>

            <div class="adm-dash-kpi">
                <div class="adm-dash-kpi__card">
                    <div class="adm-dash-kpi__icon adm-dash-kpi__icon--blue"><i class="las la-wallet"></i></div>
                    <div class="adm-dash-kpi__body">
                        <span class="adm-dash-kpi__label"><?php echo e(translate('Total Revenue')); ?></span>
                        <span class="adm-dash-kpi__value"><?php echo e(single_price($total_sale ?? 0)); ?></span>
                        <span class="adm-dash-kpi__meta adm-dash-kpi__meta--up"><i class="las la-arrow-up"></i> <?php echo e(translate('All time')); ?></span>
                    </div>
                </div>
                <div class="adm-dash-kpi__card">
                    <div class="adm-dash-kpi__icon adm-dash-kpi__icon--cyan"><i class="las la-shopping-bag"></i></div>
                    <div class="adm-dash-kpi__body">
                        <span class="adm-dash-kpi__label"><?php echo e(translate('Total Orders')); ?></span>
                        <span class="adm-dash-kpi__value"><?php echo e($total_order ?? 0); ?></span>
                        <span class="adm-dash-kpi__meta"><?php echo e($total_pending_order ?? 0); ?> <?php echo e(translate('pending')); ?></span>
                    </div>
                </div>
                <div class="adm-dash-kpi__card">
                    <div class="adm-dash-kpi__icon adm-dash-kpi__icon--purple"><i class="las la-users"></i></div>
                    <div class="adm-dash-kpi__body">
                        <span class="adm-dash-kpi__label"><?php echo e(translate('Customers')); ?></span>
                        <span class="adm-dash-kpi__value"><?php echo e($total_customers ?? 0); ?></span>
                        <span class="adm-dash-kpi__meta"><?php echo e(translate('Verified customers')); ?></span>
                    </div>
                </div>
                <div class="adm-dash-kpi__card">
                    <div class="adm-dash-kpi__icon adm-dash-kpi__icon--orange"><i class="las la-box"></i></div>
                    <div class="adm-dash-kpi__body">
                        <span class="adm-dash-kpi__label"><?php echo e(translate('Products')); ?></span>
                        <span class="adm-dash-kpi__value"><?php echo e($total_products ?? 0); ?></span>
                        <span class="adm-dash-kpi__meta"><?php echo e($total_inhouse_products ?? 0); ?> <?php echo e(translate('in-house')); ?> · <?php echo e($total_sellers_products ?? 0); ?> <?php echo e(translate('seller')); ?></span>
                    </div>
                </div>
            </div>

            <?php echo $__env->make('backend.dashboard.charts_section', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <div class="adm-dash-grid adm-dash-grid--3">
                <div class="adm-dash-panel">
                    <div class="adm-dash-panel__head"><h2><?php echo e(translate('In-house Store')); ?></h2></div>
                    <ul class="adm-dash-list">
                        <li><span><?php echo e(translate('Total Sales')); ?></span><strong><?php echo e(single_price($total_inhouse_sale)); ?></strong></li>
                        <li><span><?php echo e(translate('In-house product')); ?></span><strong><?php echo e($total_inhouse_products); ?></strong></li>
                        <li><span><?php echo e(translate('Ratings')); ?></span><strong><?php echo e(number_format($inhouse_product_rating ?? 0, 1)); ?></strong></li>
                        <li><span><?php echo e(translate('Total Orders')); ?></span><strong><?php echo e($total_inhouse_order); ?></strong></li>
                    </ul>
                    <a href="<?php echo e(route('inhouse_orders.index')); ?>" class="adm-dash-btn adm-dash-btn--block adm-dash-btn--ghost mt-3"><?php echo e(translate('All In-house Orders')); ?></a>
                </div>
                <div class="adm-dash-panel">
                    <div class="adm-dash-panel__head">
                        <h2><?php echo e(translate('In-house Top Category')); ?></h2>
                        <small><?php echo e(translate('By Sales')); ?></small>
                    </div>
                    <ul class="adm-dash-rank">
                        <?php $__currentLoopData = $top_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $top_category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $cat = \App\Models\CategoryTranslation::where('category_id', $top_category->id)->where('lang', app()->getLocale())->first();
                                $colors = ['adm-rank--1', 'adm-rank--2', 'adm-rank--3'];
                            ?>
                            <li class="adm-dash-rank__item <?php echo e($colors[$key] ?? ''); ?>">
                                <span class="adm-dash-rank__name"><?php echo e($cat->name ?? translate('Not Found')); ?></span>
                                <span class="adm-dash-rank__val"><?php echo e(single_price($top_category->total)); ?></span>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php if($top_categories->isEmpty()): ?>
                            <li class="adm-dash-empty"><?php echo e(translate('No data yet')); ?></li>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="adm-dash-panel adm-dash-panel--promo">
                    <?php if(get_setting('vendor_system_activation') == 1): ?>
                        <div class="adm-dash-panel__head"><h2><?php echo e(translate('Sellers')); ?></h2></div>
                        <div class="adm-dash-sellers__count"><?php echo e($total_sellers); ?></div>
                        <p class="adm-dash-sellers__label"><?php echo e(translate('Total Sellers')); ?></p>
                        <?php $__currentLoopData = $status_wise_sellers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sw): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="adm-dash-sellers__row">
                                <span><?php echo e($sw->verification_status == 1 ? translate('Approved Sellers') : translate('Pending Seller')); ?></span>
                                <strong><?php echo e($sw->total); ?></strong>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <div class="adm-dash-avatars adm-dash-avatars--sm mt-3">
                            <?php $__currentLoopData = $top_sellers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $seller): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="adm-dash-avatar" title="<?php echo e($seller->name); ?>">
                                    <img src="<?php echo e(uploaded_asset($seller->avatar_original)); ?>" alt=""
                                        onerror="this.src='<?php echo e(static_asset('assets/img/placeholder.jpg')); ?>'">
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <a href="<?php echo e(route('sellers.index')); ?>" class="adm-dash-btn adm-dash-btn--block adm-dash-btn--primary mt-3"><?php echo e(translate('All Sellers')); ?></a>
                    <?php else: ?>
                        <div class="adm-dash-promo">
                            <img src="<?php echo e(static_asset('assets/img/multivendor.jpg')); ?>" alt="" class="adm-dash-promo__img">
                            <h3><?php echo e(translate('Multi-Vendor E-commerce Marketplace')); ?></h3>
                            <a href="<?php echo e(route('activation.index')); ?>" class="adm-dash-btn adm-dash-btn--primary"><?php echo e(translate('Activate Vendor System')); ?></a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="adm-dash-grid adm-dash-grid--2">
                <div class="adm-dash-panel">
                    <div class="adm-dash-panel__head">
                        <h2><?php echo e(translate('In-house Top Brands')); ?></h2>
                        <small><?php echo e(translate('By Sales')); ?></small>
                    </div>
                    <ul class="adm-dash-rank">
                        <?php $__currentLoopData = $top_brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $top_brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $brand = \App\Models\BrandTranslation::where('brand_id', $top_brand->id)->where('lang', app()->getLocale())->first();
                            ?>
                            <li class="adm-dash-rank__item">
                                <span class="adm-dash-rank__name"><?php echo e($brand->name ?? translate('Not Found')); ?></span>
                                <span class="adm-dash-rank__val"><?php echo e(single_price($top_brand->total)); ?></span>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php if($top_brands->isEmpty()): ?>
                            <li class="adm-dash-empty"><?php echo e(translate('No data yet')); ?></li>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="adm-dash-panel adm-dash-panel--sales">
                    <div class="adm-dash-panel__head">
                        <h2><?php echo e(translate('Sales Breakdown')); ?></h2>
                        <span class="adm-chart-badge adm-chart-badge--blue"><?php echo e(translate('This month')); ?></span>
                    </div>
                    <div class="adm-dash-sales__total"><?php echo e(single_price($sale_this_month)); ?></div>
                    <div class="adm-dash-sales__split">
                        <div>
                            <span class="adm-dot adm-dot--blue"></span>
                            <?php echo e(translate('In-house Sales')); ?>

                            <em><?php echo e(single_price($admin_sale_this_month->total_sale ?? 0)); ?></em>
                        </div>
                        <div>
                            <span class="adm-dot adm-dot--cyan"></span>
                            <?php echo e(translate('Sellers Sales')); ?>

                            <em><?php echo e(single_price($seller_sale_this_month->total_sale ?? 0)); ?></em>
                        </div>
                    </div>
                    <div class="adm-mini-bars">
                        <?php $saleBars = [40, 55, 48, 70, 62, 85, 78, 92, 88, 75, 82, 95]; ?>
                        <?php $__currentLoopData = $saleBars; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <span style="--h:<?php echo e($h); ?>%"></span>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-warning"><?php echo e(translate('You do not have permission to view the dashboard.')); ?></div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\Incomeon_ecomm\resources\views\modules\admin\compat/backend/dashboard.blade.php ENDPATH**/ ?>