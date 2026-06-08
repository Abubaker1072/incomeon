@extends('modules.business.layouts.app')

@section('biz_content')
<div class="biz-page biz-page--detail">
    <div class="biz-detail-grid">
        <div class="biz-detail__media">
            <img src="{{ uploaded_asset($product->thumbnail_img) }}" alt="{{ $product->getTranslation('name') }}">
        </div>
        <div class="biz-detail__info">
            <h1>{{ $product->getTranslation('name') }}</h1>
            <p>{{ $product->getTranslation('description') }}</p>
            <div class="biz-detail__stats">
                <div><span>{{ translate('Highest Bid') }}</span><strong>{{ $highest_bid ? single_price($highest_bid->amount) : single_price($product->starting_bid ?? 0) }}</strong></div>
                <div><span>{{ translate('Ends') }}</span><strong>{{ date('M d, Y H:i', $product->auction_end_date) }}</strong></div>
            </div>
            @auth
                @include('modules.business.components.bid-form', compact('product', 'highest_bid'))
            @else
                <a href="{{ route('user.login') }}" class="mp-btn mp-btn--primary">{{ translate('Login to Bid') }}</a>
            @endauth
        </div>
    </div>

    <div class="biz-panel mt-4">
        <h2>{{ translate('Bid History') }}</h2>
        <table class="biz-table">
            <thead><tr><th>{{ translate('Bidder') }}</th><th>{{ translate('Amount') }}</th><th>{{ translate('Date') }}</th></tr></thead>
            <tbody>
                @forelse($bid_history as $bid)
                    <tr>
                        <td>{{ optional($bid->user)->name }}</td>
                        <td>{{ single_price($bid->amount) }}</td>
                        <td>{{ $bid->created_at->format('M d, H:i') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3">{{ translate('No bids yet') }}</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
