@extends('modules.account.layouts.app')

@section('account_content')
    <div class="acc-page-head">
        <h1>{{ translate('Dashboard') }}</h1>
        <a href="{{ route('search') }}" class="mp-btn mp-btn--primary">{{ translate('Continue Shopping') }}</a>
    </div>

    <div class="acc-stats">
        <div class="acc-stat">
            <div class="acc-stat__label">{{ translate('Total Orders') }}</div>
            <div class="acc-stat__value">{{ $total_orders }}</div>
        </div>
        @if (get_setting('wallet_system') == 1)
            <div class="acc-stat">
                <div class="acc-stat__label">{{ translate('Wallet Balance') }}</div>
                <div class="acc-stat__value">{{ single_price($wallet_balance) }}</div>
            </div>
        @endif
        @if (addon_is_activated('club_point'))
            <div class="acc-stat">
                <div class="acc-stat__label">{{ translate('Loyalty Points') }}</div>
                <div class="acc-stat__value">{{ $loyalty_points }}</div>
            </div>
        @endif
        @if (addon_is_activated('affiliate_system') && $affiliate_earnings !== null)
            <div class="acc-stat">
                <div class="acc-stat__label">{{ translate('Affiliate Earnings') }}</div>
                <div class="acc-stat__value">{{ single_price($affiliate_earnings) }}</div>
            </div>
        @endif
    </div>

    <div class="acc-card">
        <h3 style="margin:0 0 1rem;font-size:1.1rem;">{{ translate('Recent Orders') }}</h3>
        @if ($recent_orders->count())
            @include('modules.account.components.order-table', ['orders' => $recent_orders, 'compact' => true])
            <a href="{{ route('purchase_history.index') }}" class="mp-btn mp-btn--outline" style="margin-top:1rem;">{{ translate('View All Orders') }}</a>
        @else
            <p style="color:var(--mp-muted);margin:0;">{{ translate('No orders yet.') }}</p>
            <a href="{{ route('search') }}" class="mp-btn mp-btn--primary" style="margin-top:1rem;">{{ translate('Start Shopping') }}</a>
        @endif
    </div>
@endsection
