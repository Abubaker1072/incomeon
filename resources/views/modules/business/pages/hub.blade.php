@extends('modules.business.layouts.app')

@section('biz_content')
<div class="biz-page">
    <div class="biz-page__head">
        <span class="biz-kicker">{{ translate('Module 6') }}</span>
        <h1>{{ translate('Advanced Business Modules') }}</h1>
        <p>{{ translate('Auctions, wholesale, pre-orders, loyalty, affiliate, POS, and communication tools.') }}</p>
    </div>

    <div class="biz-grid">
        @if($modules['auction'])
            <a href="{{ route('auction_products.all') }}" class="biz-card">
                <i class="las la-gavel"></i>
                <h3>{{ translate('Auction System') }}</h3>
                <p>{{ translate('Active auctions, bid history, winners') }}</p>
            </a>
        @endif
        @if($modules['wholesale'])
            <a href="{{ route('business.wholesale') }}" class="biz-card">
                <i class="las la-boxes"></i>
                <h3>{{ translate('Wholesale') }}</h3>
                <p>{{ translate('Tier pricing and bulk purchase rules') }}</p>
            </a>
        @endif
        @if($modules['preorder'])
            <a href="{{ route('all_preorder_products') }}" class="biz-card">
                <i class="las la-clock"></i>
                <h3>{{ translate('Pre-Order') }}</h3>
                <p>{{ translate('Reserve inventory, deposits, final payments') }}</p>
            </a>
        @endif
        @if($modules['club_point'])
            <a href="{{ route('earnng_point_for_user') }}" class="biz-card">
                <i class="las la-star"></i>
                <h3>{{ translate('Loyalty Rewards') }}</h3>
                <p>{{ translate('Point history and redemption') }}</p>
            </a>
        @endif
        @if($modules['affiliate_system'])
            <a href="{{ route('affiliate.user.index') }}" class="biz-card">
                <i class="las la-link"></i>
                <h3>{{ translate('Affiliate Marketing') }}</h3>
                <p>{{ translate('Referral links, tracking, commissions') }}</p>
            </a>
        @endif
        @if($modules['pos_system'])
            <a href="{{ auth()->user()->user_type === 'seller' ? route('poin-of-sales.seller_index') : route('poin-of-sales.index') }}" class="biz-card">
                <i class="las la-cash-register"></i>
                <h3>{{ translate('POS System') }}</h3>
                <p>{{ translate('Barcode scanner, checkout, receipts') }}</p>
            </a>
        @endif
        <a href="{{ route('conversations.index') }}" class="biz-card">
            <i class="las la-comments"></i>
            <h3>{{ translate('Communication') }}</h3>
            <p>{{ translate('Chat, notifications, support tickets') }}</p>
        </a>
    </div>
</div>
@endsection
