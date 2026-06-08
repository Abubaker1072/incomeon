@extends('modules.business.layouts.app')

@section('biz_content')
<div class="biz-page">
    <div class="biz-page__head">
        <h1>{{ translate('Pre-Order Products') }}</h1>
        @auth
            <a href="{{ route('preorder.order_list') }}" class="mp-btn mp-btn--outline">{{ translate('My Pre-Orders') }}</a>
        @endauth
    </div>
    <div class="biz-product-grid">
        @forelse($products as $product)
            <a href="{{ route('preorder-product.details', $product->slug) }}" class="biz-product-card">
                <img src="{{ uploaded_asset($product->thumbnail) }}" alt="">
                <h3>{{ $product->getTranslation('product_name') }}</h3>
                <strong>{{ single_price($product->unit_price) }}</strong>
                @if($product->is_available == 0)
                    <span class="biz-tag">{{ translate('Reserve Inventory') }}</span>
                @endif
            </a>
        @empty
            <p class="biz-empty">{{ translate('No pre-order products') }}</p>
        @endforelse
    </div>
    {{ $products->links() }}
</div>
@endsection
