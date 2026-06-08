@extends('modules.marketplace.layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ static_asset('assets/modules/account/css/account.css') }}?v=1.0.0">
@endpush

@section('content')
@include('modules.account.layouts.partials.flash')
<div class="mp-container" style="padding:2rem 0 3rem;">


    <div class="acc-page-head">
        <h1>{{ translate('Track Your Order') }}</h1>
    </div>

    <div class="acc-card" style="max-width:480px;">
        <form method="GET" action="{{ route('orders.track') }}">
            <div class="acc-field">
                <label>{{ translate('Order Code') }}</label>
                <input type="text" name="order_code" value="{{ request('order_code') }}" placeholder="{{ translate('Enter your order code') }}" required>
            </div>
            <button type="submit" class="mp-btn mp-btn--primary">{{ translate('Track') }}</button>
        </form>
    </div>

    @if (isset($order) && $order)
        <div class="acc-card" style="margin-top:1.5rem;">
            <h3 style="margin:0 0 1rem;">{{ translate('Order') }} #{{ $order->code }}</h3>
            <div class="acc-stats">
                <div class="acc-stat">
                    <div class="acc-stat__label">{{ translate('Status') }}</div>
                    <div class="acc-stat__value" style="font-size:1rem;">{{ translate(ucfirst(str_replace('_', ' ', $order->delivery_status))) }}</div>
                </div>
                <div class="acc-stat">
                    <div class="acc-stat__label">{{ translate('Payment') }}</div>
                    <div class="acc-stat__value" style="font-size:1rem;">{{ translate(ucfirst($order->payment_status)) }}</div>
                </div>
                <div class="acc-stat">
                    <div class="acc-stat__label">{{ translate('Total') }}</div>
                    <div class="acc-stat__value" style="font-size:1rem;">{{ single_price($order->grand_total) }}</div>
                </div>
            </div>
        </div>
    @elseif (request('order_code'))
        <div class="acc-flash acc-flash--warning" style="margin-top:1rem;">{{ translate('Order not found.') }}</div>
    @endif
</div>
@endsection
