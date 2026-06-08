<?php
    $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    $maxOrder = max(1, $total_order ?? 1);
    $orderStages = [
        ['label' => translate('Placed'), 'val' => $total_placed_order ?? 0, 'badge' => 'primary'],
        ['label' => translate('Confirmed'), 'val' => $total_confirmed_order ?? 0, 'badge' => 'success'],
        ['label' => translate('Processed'), 'val' => $total_picked_up_order ?? 0, 'badge' => 'info'],
        ['label' => translate('Shipped'), 'val' => $total_shipped_order ?? 0, 'badge' => 'warning'],
        ['label' => translate('Pending'), 'val' => $total_pending_order ?? 0, 'badge' => 'danger'],
    ];
    $c = max(1, $total_customers ?? 1);
    $p = max(1, $total_products ?? 1);
    $o = max(1, $total_order ?? 1);
    $donutTotal = $c + $p + $o;
    $p1 = round(($c / $donutTotal) * 100);
    $p2 = round(($p / $donutTotal) * 100);
    $p3 = 100 - $p1 - $p2;
    $retention = $total_customers > 0 ? min(99, round(($total_order / max(1, $total_customers)) * 10)) : 0;
?>


<div class="adm-dash-grid adm-dash-grid--hero">
    <div class="adm-dash-panel adm-dash-panel--chart adm-dash-panel--wide">
        <div class="adm-dash-panel__head">
            <div>
                <h2><?php echo e(translate('Monthly Revenue')); ?></h2>
                <small><?php echo e(translate('Sales performance overview')); ?></small>
            </div>
            <span class="adm-chart-badge adm-chart-badge--blue"><?php echo e(translate('This Year')); ?></span>
        </div>
        <div class="adm-area-chart adm-area-chart--lg">
            <svg viewBox="0 0 400 140" preserveAspectRatio="none" class="adm-area-chart__svg" aria-hidden="true">
                <defs>
                    <linearGradient id="admAreaGrad" x1="0" y1="0" x2="0" y2="1">
                        <stop offset="0%" stop-color="#2557aa" stop-opacity="0.25"/>
                        <stop offset="100%" stop-color="#2557aa" stop-opacity="0"/>
                    </linearGradient>
                </defs>
                <path d="M0,110 L36,95 L72,88 L108,70 L144,78 L180,55 L216,62 L252,45 L288,52 L324,35 L360,42 L400,30 L400,140 L0,140 Z" fill="url(#admAreaGrad)"/>
                <path d="M0,110 L36,95 L72,88 L108,70 L144,78 L180,55 L216,62 L252,45 L288,52 L324,35 L360,42 L400,30" fill="none" stroke="#2557aa" stroke-width="2.5" stroke-linecap="round"/>
            </svg>
            <div class="adm-area-chart__months">
                <?php $__currentLoopData = $months; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <span><?php echo e($month); ?></span>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        <div class="adm-area-chart__legend">
            <span><span class="adm-dot adm-dot--blue"></span> <?php echo e(translate('This month')); ?> <strong><?php echo e(single_price($sale_this_month ?? 0)); ?></strong></span>
            <span><span class="adm-dot adm-dot--cyan"></span> <?php echo e(translate('All time')); ?> <strong><?php echo e(single_price($total_sale ?? 0)); ?></strong></span>
        </div>
    </div>

    <div class="adm-dash-panel adm-dash-panel--chart">
        <div class="adm-dash-panel__head">
            <div>
                <h2><?php echo e(translate('Customer Overview')); ?></h2>
                <small><?php echo e(translate('Store engagement')); ?></small>
            </div>
        </div>
        <div class="adm-donut-wrap adm-donut-wrap--center">
            <div class="adm-donut" style="--p1: <?php echo e($p1); ?>%; --p2: <?php echo e($p2); ?>%; --p3: <?php echo e($p3); ?>%;">
                <div class="adm-donut__hole">
                    <strong><?php echo e($retention); ?>%</strong>
                    <span><?php echo e(translate('Activity')); ?></span>
                </div>
            </div>
            <div class="adm-donut-stats">
                <div class="adm-donut-stat">
                    <strong><?php echo e($total_customers ?? 0); ?></strong>
                    <span><?php echo e(translate('Customers')); ?></span>
                </div>
                <div class="adm-donut-stat">
                    <strong><?php echo e($total_order ?? 0); ?></strong>
                    <span><?php echo e(translate('Total Orders')); ?></span>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="adm-dash-grid adm-dash-grid--3">
    <div class="adm-dash-panel">
        <div class="adm-dash-panel__head">
            <h2><?php echo e(translate('Top Selling')); ?></h2>
            <a href="<?php echo e(route('all_orders.index')); ?>" class="adm-dash-link"><?php echo e(translate('View all')); ?></a>
        </div>
        <ul class="adm-dash-feed">
            <?php $__empty_1 = true; $__currentLoopData = $top_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $top_category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    $cat = \App\Models\CategoryTranslation::where('category_id', $top_category->id)->where('lang', app()->getLocale())->first();
                    $pct = max(10, min(100, 100 - ($key * 25)));
                ?>
                <li class="adm-dash-feed__item">
                    <div class="adm-dash-feed__info">
                        <strong><?php echo e($cat->name ?? translate('Category')); ?></strong>
                        <span><?php echo e(single_price($top_category->total)); ?></span>
                    </div>
                    <div class="adm-dash-feed__bar"><span style="width:<?php echo e($pct); ?>%"></span></div>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <li class="adm-dash-empty"><?php echo e(translate('No data yet')); ?></li>
            <?php endif; ?>
        </ul>
    </div>

    <div class="adm-dash-panel">
        <div class="adm-dash-panel__head">
            <h2><?php echo e(translate('Order Status')); ?></h2>
        </div>
        <ul class="adm-dash-feed adm-dash-feed--status">
            <?php $__currentLoopData = $orderStages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="adm-dash-feed__item">
                    <div class="adm-dash-feed__info">
                        <strong><?php echo e($stage['label']); ?></strong>
                        <span class="adm-badge adm-badge--<?php echo e($stage['badge']); ?>"><?php echo e($stage['val']); ?></span>
                    </div>
                    <?php $pct = max(8, min(100, round(($stage['val'] / $maxOrder) * 100))); ?>
                    <div class="adm-dash-feed__bar"><span style="width:<?php echo e($pct); ?>%"></span></div>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>

    <div class="adm-dash-panel">
        <div class="adm-dash-panel__head">
            <h2><?php echo e(translate('Top Customers')); ?></h2>
            <a href="<?php echo e(route('customers.index')); ?>" class="adm-dash-link"><?php echo e(translate('View all')); ?></a>
        </div>
        <ul class="adm-dash-feed adm-dash-feed--users">
            <?php $__empty_1 = true; $__currentLoopData = $top_customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <li class="adm-dash-feed__item adm-dash-feed__item--row">
                    <img src="<?php echo e(uploaded_asset($customer->avatar_original)); ?>" alt=""
                        onerror="this.src='<?php echo e(static_asset('assets/img/placeholder.jpg')); ?>'">
                    <div class="adm-dash-feed__info">
                        <strong><?php echo e(Str::limit($customer->name, 20)); ?></strong>
                        <span><?php echo e(single_price($customer->total ?? 0)); ?></span>
                    </div>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <li class="adm-dash-empty"><?php echo e(translate('No data yet')); ?></li>
            <?php endif; ?>
        </ul>
    </div>
</div>
<?php /**PATH C:\laragon\www\Incomeon_ecomm\resources\views/backend/dashboard/charts_section.blade.php ENDPATH**/ ?>