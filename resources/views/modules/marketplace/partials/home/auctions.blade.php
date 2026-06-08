@php $auction_products = get_auction_products(8); @endphp
@if(count($auction_products))
<section class="mp-section mp-section--white">
    <div class="mp-container">
        @include('modules.marketplace.components.product-slider', [
            'title' => translate('Auctions'),
            'products' => $auction_products,
            'view_all_url' => route('auction_products.all'),
        ])
    </div>
</section>
@endif
