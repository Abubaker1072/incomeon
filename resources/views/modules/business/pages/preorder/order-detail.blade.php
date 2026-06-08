@extends('modules.business.layouts.app')

@section('biz_content')
<div class="biz-page">
    <h1>{{ translate('Pre-Order') }} #{{ $order->order_code ?? $order->id }}</h1>
    @include('modules.business.components.preorder-status-steps', ['order' => $order])
    <div class="biz-panel mt-3">
        <h3>{{ optional($order->preorder_product)->getTranslation('product_name') }}</h3>
        <ul class="biz-list">
            <li><span>{{ translate('Quantity') }}</span><strong>{{ $order->quantity ?? 1 }}</strong></li>
            <li><span>{{ translate('Total') }}</span><strong>{{ single_price($order->grand_total ?? 0) }}</strong></li>
            <li><span>{{ translate('Deposit Status') }}</span><strong>{{ ucfirst($order->prepayment_status ?? 'pending') }}</strong></li>
            <li><span>{{ translate('Final Payment') }}</span><strong>{{ ucfirst($order->final_payment_status ?? 'pending') }}</strong></li>
        </ul>
    </div>
</div>
@endsection
