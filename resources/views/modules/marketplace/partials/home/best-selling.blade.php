@php $products = get_best_selling_products(12); @endphp
@if(count($products) > 0)
    @include('modules.marketplace.components.product-slider', [
        'title' => translate('Best Sellers'),
        'products' => $products,
        'view_all_url' => route('search'),
    ])
@endif
