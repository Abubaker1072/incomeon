@extends('modules.business.layouts.app')

@section('biz_content')
<div class="biz-page">
    <h1>{{ translate('Bid History') }}</h1>
    <div class="biz-auction-grid">
        @forelse($products as $product)
            @include('modules.business.components.auction-card', ['product' => $product])
        @empty
            <p class="biz-empty">{{ translate('You have not placed any bids yet') }}</p>
        @endforelse
    </div>
    {{ $products->links() }}
</div>
@endsection
