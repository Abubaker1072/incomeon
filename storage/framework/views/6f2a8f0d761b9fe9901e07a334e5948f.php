<?php
    $nav_categories = $nav_categories ?? \App\Models\Category::with(['catIcon'])
        ->where('level', 0)->orderBy('order_level', 'desc')->take(20)->get();
?>
<div class="mp-nav-categories__panel-head">
    <a href="<?php echo e(route('categories.all')); ?>"><?php echo e(translate('See All Categories')); ?> &rarr;</a>
</div>
<ul class="mp-nav-categories__list">
    <?php $__currentLoopData = $nav_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php $name = $category->getTranslation('name'); ?>
        <li>
            <a href="<?php echo e(route('products.category', $category->slug)); ?>" class="mp-nav-categories__link">
                <?php if($category->catIcon && $category->catIcon->file_name): ?>
                    <img src="<?php echo e(uploaded_asset($category->catIcon->file_name)); ?>" alt="" width="20" height="20">
                <?php else: ?>
                    <i class="las la-tag" aria-hidden="true"></i>
                <?php endif; ?>
                <span><?php echo e($name); ?></span>
            </a>
        </li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ul>
<?php /**PATH C:\laragon\www\Incomeon_ecomm\resources\views/modules/marketplace/components/category-sidebar-nav.blade.php ENDPATH**/ ?>