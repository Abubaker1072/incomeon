@extends('modules.account.layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ static_asset('assets/modules/business/css/business.css') }}?v=1.0.0">
@endpush

@push('scripts')
<script src="{{ static_asset('assets/modules/business/js/business.js') }}?v=1.0.0"></script>
@endpush

@section('account_content')
<div class="biz-page">
    <h1>{{ translate('Affiliate Marketing') }}</h1>
    @include('modules.business.components.affiliate-link-card', ['link' => $stats['referral_link']])

    <div class="biz-kpi-row mt-4">
        <div class="biz-kpi"><span>{{ translate('Total Earnings') }}</span><strong>{{ single_price($stats['total_earnings']) }}</strong></div>
        <div class="biz-kpi"><span>{{ translate('Referrals') }}</span><strong>{{ $stats['total_referrals'] }}</strong></div>
        <div class="biz-kpi"><span>{{ translate('Balance') }}</span><strong>{{ single_price($affiliate_user->balance ?? 0) }}</strong></div>
    </div>

    <div class="biz-page__actions mt-4">
        <a href="{{ route('affiliate.user.referrals') }}" class="mp-btn mp-btn--outline">{{ translate('Referral Tracking') }}</a>
        <a href="{{ route('affiliate.user.commissions') }}" class="mp-btn mp-btn--outline">{{ translate('Commission Reports') }}</a>
        <a href="{{ route('affiliate.payment_settings') }}" class="mp-btn mp-btn--outline">{{ translate('Payment Settings') }}</a>
    </div>
</div>
@endsection
