@extends('modules.delivery.layouts.app')

@section('panel_content')
<div class="dlv-dash">
    <div class="dlv-dash__head">
        <div>
            <div class="dlv-dash__kicker">{{ translate('Module 5') }}</div>
            <h1 class="dlv-dash__title">{{ translate('Delivery Dashboard') }}</h1>
            <p class="dlv-dash__subtitle">{{ translate('Welcome back') }}, {{ auth()->user()->name }}</p>
        </div>
        <div class="dlv-dash__actions">
            <a href="{{ route('assigned-deliveries') }}" class="dlv-btn dlv-btn--primary">
                <i class="las la-clipboard-list"></i> {{ translate('Assigned Deliveries') }}
            </a>
            <a href="{{ route('delivery.route-info') }}" class="dlv-btn dlv-btn--ghost">
                <i class="las la-route"></i> {{ translate('Route Info') }}
            </a>
        </div>
    </div>

    <div class="dlv-dash-kpi">
        <div class="dlv-dash-kpi__card">
            <div class="dlv-dash-kpi__icon dlv-dash-kpi__icon--blue"><i class="las la-clipboard-list"></i></div>
            <div>
                <span class="dlv-dash-kpi__label">{{ translate('Assigned') }}</span>
                <span class="dlv-dash-kpi__value">{{ $stats['assigned'] ?? 0 }}</span>
            </div>
        </div>
        <div class="dlv-dash-kpi__card">
            <div class="dlv-dash-kpi__icon dlv-dash-kpi__icon--cyan"><i class="las la-box"></i></div>
            <div>
                <span class="dlv-dash-kpi__label">{{ translate('Picked Up') }}</span>
                <span class="dlv-dash-kpi__value">{{ $stats['picked_up'] ?? 0 }}</span>
            </div>
        </div>
        <div class="dlv-dash-kpi__card">
            <div class="dlv-dash-kpi__icon dlv-dash-kpi__icon--orange"><i class="las la-shipping-fast"></i></div>
            <div>
                <span class="dlv-dash-kpi__label">{{ translate('Out For Delivery') }}</span>
                <span class="dlv-dash-kpi__value">{{ $stats['out_for_delivery'] ?? 0 }}</span>
            </div>
        </div>
        <div class="dlv-dash-kpi__card">
            <div class="dlv-dash-kpi__icon dlv-dash-kpi__icon--green"><i class="las la-check-circle"></i></div>
            <div>
                <span class="dlv-dash-kpi__label">{{ translate('Delivered') }}</span>
                <span class="dlv-dash-kpi__value">{{ $stats['delivered'] ?? 0 }}</span>
            </div>
        </div>
        <div class="dlv-dash-kpi__card">
            <div class="dlv-dash-kpi__icon dlv-dash-kpi__icon--red"><i class="las la-times-circle"></i></div>
            <div>
                <span class="dlv-dash-kpi__label">{{ translate('Failed') }}</span>
                <span class="dlv-dash-kpi__value">{{ $stats['failed'] ?? 0 }}</span>
            </div>
        </div>
    </div>

    <div class="dlv-dash-grid dlv-dash-grid--2">
        <div class="dlv-panel">
            <div class="dlv-panel__head">
                <h2>{{ translate('COD Summary') }}</h2>
                <a href="{{ route('delivery.cod-collection') }}" class="dlv-link">{{ translate('View all') }}</a>
            </div>
            @include('modules.delivery.components.cod-summary', ['cod' => [
                'total_collection' => $stats['total_collection'] ?? 0,
                'today_collection' => $stats['cod_today'] ?? 0,
                'yesterday_collection' => 0,
                'cod_orders_today' => 0,
                'recent_collections' => collect(),
            ]])
        </div>
        <div class="dlv-panel">
            <div class="dlv-panel__head">
                <h2>{{ translate('Earnings') }}</h2>
                <a href="{{ route('total-earnings') }}" class="dlv-link">{{ translate('View all') }}</a>
            </div>
            <div class="dlv-earning-highlight">
                <span>{{ translate('Total Earnings') }}</span>
                <strong>{{ single_price($stats['total_earning'] ?? 0) }}</strong>
            </div>
        </div>
    </div>

    <div class="dlv-panel">
        <div class="dlv-panel__head">
            <h2>{{ translate('Active Deliveries') }}</h2>
            <a href="{{ route('pending-deliveries') }}" class="dlv-link">{{ translate('View all') }}</a>
        </div>
        <div class="dlv-card-grid">
            @forelse ($recent_orders as $order)
                @include('modules.delivery.components.delivery-card', ['order' => $order])
            @empty
                <p class="dlv-empty">{{ translate('No active deliveries right now') }}</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
