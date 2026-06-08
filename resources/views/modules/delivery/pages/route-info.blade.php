@extends('modules.delivery.layouts.app')

@section('panel_content')
<div class="dlv-page">
    <div class="dlv-page__head">
        <h1>{{ translate('Route Information') }}</h1>
        <p>{{ translate('Active stops on your delivery route') }}</p>
    </div>

    @if ($pickup_lat && $pickup_lng)
        <div class="dlv-panel mb-4">
            <div class="dlv-panel__head">
                <h2><i class="las la-warehouse"></i> {{ translate('Pickup Location') }}</h2>
            </div>
            <p class="mb-2">{{ translate('Latitude') }}: {{ $pickup_lat }}, {{ translate('Longitude') }}: {{ $pickup_lng }}</p>
            <a href="https://www.google.com/maps?q={{ $pickup_lat }},{{ $pickup_lng }}" target="_blank" class="dlv-btn dlv-btn--ghost">
                <i class="las la-map"></i> {{ translate('Open in Maps') }}
            </a>
        </div>
    @endif

    <div class="dlv-route-list">
        @forelse ($orders as $index => $order)
            @php $address = json_decode($order->shipping_address); @endphp
            <div class="dlv-route-item">
                <div class="dlv-route-item__stop">{{ $index + 1 }}</div>
                <div class="dlv-route-item__content">
                    <div class="dlv-route-item__top">
                        <strong>#{{ $order->code }}</strong>
                        <span class="dlv-badge dlv-badge--{{ delivery_status_badge_class($order->delivery_status) }}">
                            {{ delivery_status_label($order->delivery_status) }}
                        </span>
                    </div>
                    <p class="mb-1">{{ $address->name ?? '' }} &middot; {{ $address->phone ?? '' }}</p>
                    <p class="mb-2 text-muted">{{ $address->address ?? '' }}, {{ $address->city ?? '' }}, {{ $address->postal_code ?? '' }}</p>
                    <div class="dlv-route-item__actions">
                        @if (!empty($address->lat_lang))
                            <a href="https://www.google.com/maps?q={{ $address->lat_lang }}" target="_blank" class="dlv-btn dlv-btn--ghost btn-sm">
                                <i class="las la-directions"></i> {{ translate('Navigate') }}
                            </a>
                        @endif
                        <a href="{{ route('delivery-boy.order-detail', $order->id) }}" class="dlv-btn dlv-btn--primary btn-sm">
                            {{ translate('View Order') }}
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="dlv-empty-state">
                <i class="las la-route"></i>
                <p>{{ translate('No active route stops') }}</p>
            </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $orders->links() }}
    </div>
</div>
@endsection
