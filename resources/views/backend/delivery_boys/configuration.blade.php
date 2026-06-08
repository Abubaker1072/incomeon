@extends('backend.layouts.app')

@section('content')
<div class="aiz-titlebar text-left mt-2 mb-3">
    <h1 class="h3">{{ translate('Delivery Boy Configuration') }}</h1>
</div>

<div class="card">
    <div class="card-body">
        <p class="text-muted">{{ translate('Configure delivery boy settings from') }}
            <a href="{{ route('general_setting.index') }}">{{ translate('General Settings') }}</a>
            {{ translate('or business settings panel.') }}
        </p>
        <ul class="list-group">
            <li class="list-group-item d-flex justify-content-between">
                <span>{{ translate('Payment Type') }}</span>
                <strong>{{ get_setting('delivery_boy_payment_type') ?? '—' }}</strong>
            </li>
            <li class="list-group-item d-flex justify-content-between">
                <span>{{ translate('Commission') }}</span>
                <strong>{{ single_price(get_setting('delivery_boy_commission') ?? 0) }}</strong>
            </li>
            <li class="list-group-item d-flex justify-content-between">
                <span>{{ translate('Pickup Latitude') }}</span>
                <strong>{{ get_setting('delivery_pickup_latitude') ?? '—' }}</strong>
            </li>
            <li class="list-group-item d-flex justify-content-between">
                <span>{{ translate('Pickup Longitude') }}</span>
                <strong>{{ get_setting('delivery_pickup_longitude') ?? '—' }}</strong>
            </li>
        </ul>
    </div>
</div>
@endsection
