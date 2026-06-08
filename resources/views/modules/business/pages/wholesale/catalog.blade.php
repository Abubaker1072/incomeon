@extends('modules.business.layouts.app')

@section('biz_content')
<div class="biz-page">
    <h1>{{ translate('Wholesale Catalog') }}</h1>
    <p>{{ translate('Tier pricing and bulk purchase rules apply at checkout.') }}</p>
    <div class="biz-product-grid">
        @forelse($products as $product)
            <div class="biz-product-card">
                <a href="{{ route('product', $product->slug) }}">
                    <img src="{{ uploaded_asset($product->thumbnail_img) }}" alt="">
                    <h3>{{ $product->getTranslation('name') }}</h3>
                </a>
                @include('modules.business.components.wholesale-tier-table', ['product' => $product])
            </div>
        @empty
            <p class="biz-empty">{{ translate('No wholesale products available') }}</p>
        @endforelse
    </div>
    {{ $products->links() }}
</div>
@endsection
