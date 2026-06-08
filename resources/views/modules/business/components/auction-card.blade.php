@php
    $highest = \App\Models\AuctionProductBid::where('product_id', $product->id)->orderBy('amount', 'desc')->first();
@endphp
<article class="biz-auction-card">
    <a href="{{ route('auction-product', $product->slug) }}" class="biz-auction-card__img">
        <img src="{{ uploaded_asset($product->thumbnail_img) }}" alt="{{ $product->getTranslation('name') }}">
        <span class="biz-auction-card__live">{{ translate('Live') }}</span>
    </a>
    <div class="biz-auction-card__body">
        <h3><a href="{{ route('auction-product', $product->slug) }}">{{ $product->getTranslation('name') }}</a></h3>
        <div class="biz-auction-card__bid">
            <span>{{ translate('Highest Bid') }}</span>
            <strong>{{ $highest ? single_price($highest->amount) : single_price($product->starting_bid ?? 0) }}</strong>
        </div>
        <small>{{ translate('Ends') }}: {{ date('M d, H:i', $product->auction_end_date) }}</small>
    </div>
</article>
