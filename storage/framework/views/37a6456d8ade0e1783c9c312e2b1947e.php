<form action="<?php echo e(route('search')); ?>" method="GET">
    <input type="text" name="keyword" value="<?php echo e($query ?? request('keyword')); ?>"
        placeholder="<?php echo e(translate('Search products, brands, stores...')); ?>" autocomplete="off">
    <button type="submit" aria-label="<?php echo e(translate('Search')); ?>"><i class="las la-search"></i></button>
</form>
<?php /**PATH C:\laragon\www\Incomeon_ecomm\resources\views/modules/marketplace/components/search-bar.blade.php ENDPATH**/ ?>