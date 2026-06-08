@if(count($newest_products) > 0)
    @include('modules.marketplace.components.product-slider', [
        'title' => translate('New Arrivals'),
        'products' => $newest_products,
        'view_all_url' => route('search', ['sort_by' => 'newest']),
    ])
@endif
