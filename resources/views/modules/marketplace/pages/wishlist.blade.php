@extends('modules.marketplace.layouts.app')

@section('meta_title'){{ translate('Wishlist') }} | {{ get_setting('website_name') }}@stop

@section('content')
<div class="mp-container" style="padding:2rem 0 3rem;">
    <h1 class="mp-section__title">{{ translate('Wishlist') }}</h1>

    @if($wishlists->count())
        <div class="mp-product-grid" style="margin-top:1.5rem;">
            @foreach($wishlists as $wishlist)
                @if($wishlist->product)
                    @include('modules.marketplace.components.product-card', ['product' => $wishlist->product])
                @endif
            @endforeach
        </div>
        @include('modules.marketplace.components.pagination', ['paginator' => $wishlists])
    @else
        <p style="margin-top:1rem;color:var(--mp-muted);">{{ translate('Your wishlist is empty.') }}</p>
        <a href="{{ route('search') }}" class="mp-btn mp-btn--primary" style="margin-top:1rem;">{{ translate('Browse products') }}</a>
    @endif
</div>
@endsection
