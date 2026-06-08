@if(count(get_featured_products()) > 0)
    @include('modules.marketplace.components.product-slider', [
        'title' => translate('Featured Products'),
        'products' => get_featured_products(),
        'view_all_url' => route('search'),
    ])
@endif
