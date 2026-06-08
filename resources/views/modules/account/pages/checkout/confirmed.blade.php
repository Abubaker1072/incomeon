@extends('modules.account.layouts.app')

@section('account_content')
    <div class="acc-card" style="text-align:center;padding:3rem 2rem;">
        <div style="width:72px;height:72px;border-radius:50%;background:#dcfce7;color:#16a34a;display:inline-flex;align-items:center;justify-content:center;font-size:2rem;margin-bottom:1rem;">
            <i class="las la-check"></i>
        </div>
        <h1 style="margin:0 0 0.5rem;font-size:1.75rem;">{{ translate('Order Confirmed!') }}</h1>
        <p style="color:var(--mp-muted);margin:0 0 1.5rem;">{{ translate('Thank you for your purchase. Your order has been placed successfully.') }}</p>
        @foreach ($combined_order->orders as $order)
            <p style="margin:0.25rem 0;"><strong>{{ translate('Order') }} #{{ $order->code }}</strong> — {{ single_price($order->grand_total) }}</p>
        @endforeach
        <div style="margin-top:2rem;display:flex;gap:0.75rem;justify-content:center;flex-wrap:wrap;">
            <a href="{{ route('purchase_history.index') }}" class="mp-btn mp-btn--primary">{{ translate('View Orders') }}</a>
            <a href="{{ route('home') }}" class="mp-btn mp-btn--outline">{{ translate('Continue Shopping') }}</a>
        </div>
    </div>
@endsection
