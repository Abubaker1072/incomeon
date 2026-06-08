@extends('modules.delivery.layouts.app')

@section('panel_content')
@php $address = json_decode($order->shipping_address); @endphp
<div class="dlv-page">
    <div class="dlv-page__head">
        <div>
            <h1>{{ translate('Order') }} #{{ $order->code }}</h1>
            <span class="dlv-badge dlv-badge--{{ delivery_status_badge_class($order->delivery_status) }}">
                {{ delivery_status_label($order->delivery_status) }}
            </span>
        </div>
        <div class="dlv-dash__actions">
            @if (in_array($order->delivery_status, ['on_the_way', 'picked_up', 'pending', 'confirmed']))
                <a href="{{ route('delivery.verification', $order->id) }}" class="dlv-btn dlv-btn--accent">
                    <i class="las la-check-circle"></i> {{ translate('Verify Delivery') }}
                </a>
            @endif
            @if ($order->cancel_request == 0 && !in_array($order->delivery_status, ['delivered', 'cancelled']))
                <a href="{{ route('cancel-request', $order->id) }}" class="dlv-btn dlv-btn--ghost"
                    onclick="return confirm('{{ translate('Request cancellation for this order?') }}')">
                    <i class="las la-ban"></i> {{ translate('Cancel Request') }}
                </a>
            @endif
        </div>
    </div>

    <div class="dlv-dash-grid dlv-dash-grid--2">
        <div class="dlv-panel">
            <div class="dlv-panel__head"><h2>{{ translate('Shipping Info') }}</h2></div>
            <ul class="dlv-detail-list">
                <li><span>{{ translate('Name') }}</span><strong>{{ $address->name ?? '—' }}</strong></li>
                <li><span>{{ translate('Phone') }}</span><strong>{{ $address->phone ?? '—' }}</strong></li>
                <li><span>{{ translate('Address') }}</span><strong>{{ $address->address ?? '' }}</strong></li>
                <li><span>{{ translate('City') }}</span><strong>{{ $address->city ?? '' }}</strong></li>
                <li><span>{{ translate('Postal Code') }}</span><strong>{{ $address->postal_code ?? '—' }}</strong></li>
            </ul>
        </div>

        <div class="dlv-panel">
            <div class="dlv-panel__head"><h2>{{ translate('Order Summary') }}</h2></div>
            <ul class="dlv-detail-list">
                <li><span>{{ translate('Subtotal') }}</span><strong>{{ single_price($order->orderDetails->sum('price')) }}</strong></li>
                <li><span>{{ translate('Shipping') }}</span><strong>{{ single_price($order->orderDetails->sum('shipping_cost')) }}</strong></li>
                <li><span>{{ translate('Tax') }}</span><strong>{{ single_price($order->orderDetails->sum('tax')) }}</strong></li>
                <li><span>{{ translate('Grand Total') }}</span><strong>{{ single_price($order->grand_total) }}</strong></li>
                <li><span>{{ translate('Payment') }}</span><strong>{{ ucfirst(str_replace('_', ' ', $order->payment_type)) }}</strong></li>
            </ul>
        </div>
    </div>

    <div class="dlv-panel">
        <div class="dlv-panel__head"><h2>{{ translate('Status Timeline') }}</h2></div>
        @include('modules.delivery.components.status-timeline', ['order' => $order])
    </div>

    <div class="dlv-panel">
        <div class="dlv-panel__head"><h2>{{ translate('Items') }}</h2></div>
        <div class="dlv-table-wrap">
            <table class="dlv-table">
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
                            <td>{{ optional($detail->product)->name ?? translate('Product') }}</td>
                            <td>{{ $detail->quantity }}</td>
                            <td>{{ single_price($detail->price) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @if ($next_status)
        <div class="dlv-panel">
            <div class="dlv-panel__head"><h2>{{ translate('Update Status') }}</h2></div>
            <button type="button" class="dlv-btn dlv-btn--primary dlv-status-btn"
                data-order="{{ $order->id }}" data-status="{{ $next_status }}">
                <i class="las la-arrow-right"></i>
                {{ translate('Move to') }} {{ delivery_status_label($next_status) }}
            </button>
        </div>
    @endif
</div>
@endsection

@section('script')
<script>
    DLV.initStatusUpdate('{{ route('delivery-boy.orders.update_delivery_status') }}', '{{ csrf_token() }}');
</script>
@endsection
