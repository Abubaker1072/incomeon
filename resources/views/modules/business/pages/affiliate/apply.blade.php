@extends('modules.business.layouts.app')

@section('biz_content')
<div class="biz-page">
    <h1>{{ translate('Become an Affiliate') }}</h1>
    <form method="POST" action="{{ route('affiliate.store_affiliate_user') }}" class="biz-panel">
        @csrf
        <p>{{ translate('Join our affiliate program and earn commissions on referrals.') }}</p>
        <button type="submit" class="mp-btn mp-btn--primary">{{ translate('Apply Now') }}</button>
    </form>
</div>
@endsection
