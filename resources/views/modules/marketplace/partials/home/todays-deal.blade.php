@if(count($todays_deal_products) > 0)
    @include('modules.marketplace.components.product-slider', [
        'title' => translate("Today's Deal"),
        'products' => $todays_deal_products,
        'view_all_url' => route('todays-deal'),
    ])
@endif
