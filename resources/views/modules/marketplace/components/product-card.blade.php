@php
    $product_url = $product->auction_product == 1
        ? route('auction-product', $product->slug)
        : route('product', $product->slug);
    $thumb = get_image($product->thumbnail);
@endphp
<article class="mp-product-card">
    <a href="{{ $product_url }}" class="mp-product-card__img">
        <img src="{{ $thumb }}" alt="{{ $product->getTranslation('name') }}"
            onerror="this.src='{{ static_asset('assets/img/placeholder.jpg') }}'">
        @if(discount_in_percentage($product) > 0)
            <span class="mp-product-card__badge">-{{ discount_in_percentage($product) }}%</span>
        @endif
    </a>
    <div class="mp-product-card__body">
        <h3 class="mp-product-card__name">
            <a href="{{ $product_url }}">{{ $product->getTranslation('name') }}</a>
        </h3>
        <div class="mp-product-card__price">
            {{ home_discounted_base_price($product) }}
            @if(home_base_price($product) != home_discounted_base_price($product))
                <del>{{ home_base_price($product) }}</del>
            @endif
        </div>
        @auth
            <button type="button" class="mp-btn mp-btn--outline" style="margin-top:0.5rem;width:100%;font-size:0.75rem;"
                onclick="addToWishList({{ $product->id }})">
                <i class="las la-heart"></i> {{ translate('Wishlist') }}
            </button>
        @endauth
    </div>
</article>
