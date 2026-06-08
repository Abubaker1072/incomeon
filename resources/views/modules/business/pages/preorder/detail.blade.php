@extends('modules.business.layouts.app')

@section('biz_content')
<div class="biz-page biz-page--detail">
    <div class="biz-detail-grid">
        <img src="{{ uploaded_asset($product->thumbnail) }}" alt="" class="biz-detail__img">
        <div>
            <h1>{{ $product->getTranslation('product_name') }}</h1>
            <p>{!! $product->getTranslation('description') !!}</p>
            <div class="biz-detail__stats">
                <div><span>{{ translate('Unit Price') }}</span><strong>{{ single_price($product->unit_price) }}</strong></div>
                @if($product->preorder_prepayment)
                    <div><span>{{ translate('Deposit') }}</span><strong>{{ $product->preorder_prepayment->prepayment_amount }}%</strong></div>
                @endif
            </div>
            @auth
                <a href="{{ route('preorder.order_list') }}" class="mp-btn mp-btn--primary">{{ translate('Place Pre-Order') }}</a>
            @endauth
        </div>
    </div>
</div>
@endsection
