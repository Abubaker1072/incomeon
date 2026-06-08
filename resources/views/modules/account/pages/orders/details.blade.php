@extends('modules.account.layouts.app')

@section('account_content')
    <div class="acc-page-head">
        <h1>{{ translate('Order') }} #{{ $order->code }}</h1>
        <a href="{{ route('purchase_history.index') }}" class="mp-btn mp-btn--outline">&larr; {{ translate('Back') }}</a>
    </div>

    <div class="acc-stats" style="margin-bottom:1rem;">
        <div class="acc-stat">
            <div class="acc-stat__label">{{ translate('Order Date') }}</div>
            <div class="acc-stat__value" style="font-size:1rem;">{{ date('M d, Y', $order->date) }}</div>
        </div>
        <div class="acc-stat">
            <div class="acc-stat__label">{{ translate('Total') }}</div>
            <div class="acc-stat__value" style="font-size:1rem;">{{ single_price($order->grand_total) }}</div>
        </div>
        <div class="acc-stat">
            <div class="acc-stat__label">{{ translate('Delivery') }}</div>
            <div class="acc-stat__value" style="font-size:1rem;">{{ translate(ucfirst($order->delivery_status)) }}</div>
        </div>
        <div class="acc-stat">
            <div class="acc-stat__label">{{ translate('Payment') }}</div>
            <div class="acc-stat__value" style="font-size:1rem;">{{ translate(ucfirst($order->payment_status)) }}</div>
        </div>
    </div>

    <div class="acc-card">
        <h3 style="margin:0 0 1rem;">{{ translate('Order Items') }}</h3>
        <div class="acc-table-wrap">
            <table class="acc-table">
                <thead>
                    <tr>
                        <th>{{ translate('Product') }}</th>
                        <th>{{ translate('Qty') }}</th>
                        <th>{{ translate('Price') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->orderDetails as $detail)
                        <tr>
                            <td>{{ $detail->product?->getTranslation('name') ?? translate('Product') }}</td>
                            <td>{{ $detail->quantity }}</td>
                            <td>{{ single_price($detail->price) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if ($order->delivery_status === 'pending' && $order->payment_status === 'unpaid')
            <a href="{{ route('purchase_history.destroy', $order->id) }}" class="mp-btn mp-btn--outline" style="margin-top:1rem;color:#dc2626;border-color:#dc2626;"
                onclick="return confirm('{{ translate('Cancel this order?') }}')">{{ translate('Cancel Order') }}</a>
        @endif
        <a href="{{ route('re_order', encrypt($order->id)) }}" class="mp-btn mp-btn--primary" style="margin-top:1rem;margin-left:0.5rem;">{{ translate('Re-order') }}</a>
    </div>
@endsection
