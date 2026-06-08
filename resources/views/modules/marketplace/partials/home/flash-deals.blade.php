@php $flash_deal = get_featured_flash_deal(); @endphp
@if($flash_deal)
@php $flash_deal->load(['flash_deal_products.product']); @endphp
<section class="mp-section" style="background:linear-gradient(135deg,#1a1a1a,#2d2d2d);color:#fff;">
    <div class="mp-container">
        <div class="mp-section__head">
            <h2 class="mp-section__title" style="color:#fff;">{{ translate('Flash Deals') }} — {{ $flash_deal->title }}</h2>
            <a href="{{ route('flash-deal-details', $flash_deal->slug) }}" class="mp-section__link">{{ translate('View All') }}</a>
        </div>
        <div class="mp-product-grid">
            @foreach($flash_deal->flash_deal_products->take(8) as $fdp)
                @if($fdp->product)
                    @include('modules.marketplace.components.product-card', ['product' => $fdp->product])
                @endif
            @endforeach
        </div>
    </div>
</section>
@endif
