@extends('modules.business.layouts.app')

@section('biz_content')
<div class="biz-page">
    <h1>{{ translate('How to Pre-Order') }}</h1>
    <div class="biz-panel">
        <ol>
            <li>{{ translate('Browse pre-order products and reserve your item') }}</li>
            <li>{{ translate('Pay the deposit to secure inventory') }}</li>
            <li>{{ translate('Complete the final payment when the product is ready') }}</li>
            <li>{{ translate('Receive your order after fulfillment') }}</li>
        </ol>
        <a href="{{ route('all_preorder_products') }}" class="mp-btn mp-btn--primary mt-3">{{ translate('Browse Pre-Orders') }}</a>
    </div>
</div>
@endsection
