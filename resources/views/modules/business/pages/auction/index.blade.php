@extends('modules.business.layouts.app')

@section('biz_content')
<div class="biz-page">
    <div class="biz-page__head">
        <h1>{{ translate('Active Auctions') }}</h1>
        <div class="biz-page__actions">
            @auth
                <a href="{{ route('auction.bid-history') }}" class="mp-btn mp-btn--outline">{{ translate('Bid History') }}</a>
                <a href="{{ route('auction.winners') }}" class="mp-btn mp-btn--outline">{{ translate('Winners') }}</a>
            @endauth
        </div>
    </div>
    <div class="biz-auction-grid">
        @forelse($products as $product)
            @include('modules.business.components.auction-card', ['product' => $product])
        @empty
            <p class="biz-empty">{{ translate('No active auctions right now') }}</p>
        @endforelse
    </div>
    <div class="d-flex justify-content-center mt-4">{{ $products->links() }}</div>
</div>
@endsection
