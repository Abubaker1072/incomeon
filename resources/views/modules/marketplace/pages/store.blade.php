@extends('modules.marketplace.layouts.app')

@section('meta_title'){{ $shop->meta_title }}@stop
@section('meta_description'){{ $shop->meta_description }}@stop

@section('content')
<section class="mp-store-hero">
    <div class="mp-container mp-store-hero__inner">
        <img class="mp-store-hero__logo"
            src="{{ $shop->logo ? uploaded_asset($shop->logo) : static_asset('assets/img/placeholder.jpg') }}"
            alt="{{ $shop->name }}">
        <div>
            <h1 style="margin:0 0 0.5rem;">{{ $shop->name }}</h1>
            <div style="color:var(--mp-accent);">{{ renderStarRating($shop->rating) }}</div>
            <p style="margin:0.75rem 0 0;opacity:0.85;max-width:560px;">{{ $shop->meta_description }}</p>
        </div>
    </div>
</section>

<div class="mp-container" style="padding:1.5rem 0 3rem;">
    <nav style="display:flex;gap:1rem;margin-bottom:1.5rem;flex-wrap:wrap;">
        <a href="{{ route('shop.visit', $shop->slug) }}" class="mp-btn mp-btn--outline @if(!isset($type)) mp-btn--primary @endif">{{ translate('Store Home') }}</a>
        <a href="{{ route('shop.visit.type', ['slug' => $shop->slug, 'type' => 'top-selling']) }}" class="mp-btn mp-btn--outline @if(($type ?? '') == 'top-selling') mp-btn--primary @endif">{{ translate('Top Selling') }}</a>
        <a href="{{ route('shop.visit.type', ['slug' => $shop->slug, 'type' => 'all-products']) }}" class="mp-btn mp-btn--outline @if(($type ?? '') == 'all-products') mp-btn--primary @endif">{{ translate('All Products') }}</a>
    </nav>

    @php
        $store_products = isset($products) ? $products : get_seller_products($shop->user_id);
    @endphp

    @if(isset($products) && method_exists($products, 'count') ? $products->count() : count($store_products))
        <div class="mp-product-grid">
            @foreach($store_products as $product)
                @include('modules.marketplace.components.product-card', ['product' => $product])
            @endforeach
        </div>
        @if(isset($products) && method_exists($products, 'links'))
            @include('modules.marketplace.components.pagination', ['paginator' => $products])
        @endif
    @else
        <p>{{ translate('No products in this store yet.') }}</p>
    @endif
</div>
@endsection
