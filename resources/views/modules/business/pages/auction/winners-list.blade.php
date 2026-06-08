@extends('modules.business.layouts.app')

@section('biz_content')
<div class="biz-page">
    <h1>{{ translate('Auction Winners') }}</h1>
    <table class="biz-table">
        <thead><tr><th>{{ translate('Product') }}</th><th>{{ translate('Winner') }}</th><th>{{ translate('Winning Bid') }}</th></tr></thead>
        <tbody>
            @forelse($winners as $product)
                <tr>
                    <td><a href="{{ route('auction-product', $product->slug) }}">{{ $product->getTranslation('name') }}</a></td>
                    <td>{{ optional(optional($product->winning_bid)->user)->name ?? '—' }}</td>
                    <td>{{ $product->winning_bid ? single_price($product->winning_bid->amount) : '—' }}</td>
                </tr>
            @empty
                <tr><td colspan="3">{{ translate('No completed auctions yet') }}</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
