@extends('modules.account.layouts.app')

@section('account_content')
    <div class="acc-page-head">
        <h1>{{ translate('Order History') }}</h1>
        @if (addon_is_activated('digital_product'))
            <a href="{{ route('digital_purchase_history.index') }}" class="mp-btn mp-btn--outline">{{ translate('Digital Orders') }}</a>
        @endif
    </div>

    <div class="acc-card">
        @if ($orders->count())
            @include('modules.account.components.order-table', ['orders' => $orders])
            <div style="margin-top:1.5rem;">
                @include('modules.marketplace.components.pagination', ['paginator' => $orders])
            </div>
        @else
            <p style="color:var(--mp-muted);">{{ translate('No orders found.') }}</p>
        @endif
    </div>
@endsection
