@php $shop = $seller ?? $shop; @endphp
@if($shop)
<div class="mp-store-card">
    <img class="mp-store-card__logo"
        src="{{ $shop->logo ? uploaded_asset($shop->logo) : static_asset('assets/img/placeholder.jpg') }}"
        alt="{{ $shop->name }}">
    <div>
        <h3 class="mp-store-card__name">
            <a href="{{ route('shop.visit', $shop->slug) }}">{{ $shop->name }}</a>
        </h3>
        @if(isset($shop->rating))
            <div style="color:var(--mp-accent);font-size:0.85rem;">{{ renderStarRating($shop->rating) }}</div>
        @endif
        <a href="{{ route('shop.visit', $shop->slug) }}" class="mp-btn mp-btn--primary" style="margin-top:0.5rem;font-size:0.75rem;">
            {{ translate('Visit Store') }}
        </a>
    </div>
</div>
@endif
