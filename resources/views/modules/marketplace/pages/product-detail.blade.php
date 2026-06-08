@extends('modules.marketplace.layouts.app')

@section('meta_title'){{ $detailedProduct->meta_title }}@stop
@section('meta_description'){{ $detailedProduct->meta_description }}@stop

@section('content')
@php
    $photos = $detailedProduct->photos ? json_decode($detailedProduct->photos) : [];
    $main_img = count($photos) ? uploaded_asset($photos[0]) : get_image($detailedProduct->thumbnail);
@endphp
<div class="mp-container">
    <div class="mp-pdp">
        <div class="mp-pdp__gallery">
            <img src="{{ $main_img }}" alt="{{ $detailedProduct->getTranslation('name') }}">
        </div>
        <div>
            <h1 class="mp-pdp__title">{{ $detailedProduct->getTranslation('name') }}</h1>
            <div class="mp-pdp__price">{{ home_discounted_base_price($detailedProduct) }}</div>
            <p style="color:var(--mp-muted);">{!! $detailedProduct->getTranslation('description') !!}</p>

            @if($detailedProduct->user && $detailedProduct->user->shop)
                <div class="mp-store-card" style="margin:1.5rem 0;">
                    @include('modules.marketplace.components.store-card', ['seller' => $detailedProduct->user->shop])
                </div>
            @endif

            <form action="{{ route('cart.addToCart') }}" method="POST" style="margin-top:1rem;">
                @csrf
                <input type="hidden" name="id" value="{{ $detailedProduct->id }}">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="mp-btn mp-btn--primary">{{ translate('Add to cart') }}</button>
                @auth
                    <button type="button" class="mp-btn mp-btn--outline" onclick="addToWishList({{ $detailedProduct->id }})">{{ translate('Add to wishlist') }}</button>
                @endauth
            </form>
        </div>
    </div>

    @if($reviews->count())
    <section class="mp-section">
        <h2 class="mp-section__title">{{ translate('Reviews') }}</h2>
        <div style="display:grid;gap:1rem;margin-top:1rem;">
            @foreach($reviews as $review)
                @include('modules.marketplace.components.review-card', ['review' => $review])
            @endforeach
        </div>
    </section>
    @endif

    @if($product_queries->count())
    <section class="mp-section mp-section--white">
        <h2 class="mp-section__title">{{ translate('Questions & Answers') }}</h2>
        @foreach($product_queries as $q)
            <div class="mp-review" style="margin-top:0.75rem;">
                <strong>{{ $q->user->name ?? translate('Customer') }}</strong>
                <p>{{ $q->question }}</p>
                @if($q->reply) <p style="color:var(--mp-muted);"><em>{{ $q->reply }}</em></p> @endif
            </div>
        @endforeach
    </section>
    @endif

    @php
        $related = filter_products(\App\Models\Product::where('category_id', $detailedProduct->category_id)
            ->where('id', '!=', $detailedProduct->id)->limit(8))->get();
    @endphp
    @if($related->count())
    <section class="mp-section">
        @include('modules.marketplace.components.product-slider', [
            'title' => translate('Related Products'),
            'products' => $related,
        ])
    </section>
    @endif
</div>
@endsection
