@php
    $address = json_decode($order->shipping_address);
    $nextStatus = \App\Services\DeliveryService::nextStatus($order->delivery_status);
    $statusClass = delivery_status_badge_class($order->delivery_status);
@endphp

<article class="dlv-card">
    <div class="dlv-card__head">
        <div>
            <span class="dlv-card__code">#{{ $order->code }}</span>
            <span class="dlv-badge dlv-badge--{{ $statusClass }}">{{ delivery_status_label($order->delivery_status) }}</span>
        </div>
        <span class="dlv-card__amount">{{ single_price($order->grand_total) }}</span>
    </div>

    <div class="dlv-card__body">
        <div class="dlv-card__row">
            <i class="las la-user"></i>
            <span>{{ $address->name ?? translate('Customer') }}</span>
        </div>
        <div class="dlv-card__row">
            <i class="las la-map-marker-alt"></i>
            <span>{{ $address->address ?? '' }}, {{ $address->city ?? '' }}</span>
        </div>
        <div class="dlv-card__row">
            <i class="las la-phone"></i>
            <span>{{ $address->phone ?? '—' }}</span>
        </div>
        @if ($order->payment_type === 'cash_on_delivery')
            <div class="dlv-card__row dlv-card__row--cod">
                <i class="las la-money-bill-wave"></i>
                <span>{{ translate('COD') }}: {{ single_price($order->grand_total) }}</span>
            </div>
        @endif
    </div>

    <div class="dlv-card__foot">
        <a href="{{ route('delivery-boy.order-detail', $order->id) }}" class="dlv-btn dlv-btn--ghost">
            <i class="las la-eye"></i> {{ translate('Details') }}
        </a>
        @if ($nextStatus)
            <button type="button" class="dlv-btn dlv-btn--primary dlv-status-btn"
                data-order="{{ $order->id }}" data-status="{{ $nextStatus }}">
                <i class="las la-arrow-right"></i>
                {{ delivery_status_label($nextStatus) }}
            </button>
        @endif
        @if (in_array($order->delivery_status, ['on_the_way', 'picked_up']))
            <a href="{{ route('delivery.verification', $order->id) }}" class="dlv-btn dlv-btn--accent">
                <i class="las la-check-circle"></i> {{ translate('Verify') }}
            </a>
        @endif
    </div>
</article>
