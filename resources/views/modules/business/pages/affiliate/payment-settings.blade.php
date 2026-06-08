@extends('modules.account.layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ static_asset('assets/modules/business/css/business.css') }}?v=1.0.0">
@endpush

@section('account_content')
<div class="biz-page">
    <h1>{{ translate('Payment Settings') }}</h1>
    <form method="POST" action="{{ route('affiliate.payment_settings_store') }}" class="biz-panel">
        @csrf
        <div class="acc-field"><label>{{ translate('PayPal Email') }}</label><input type="email" name="paypal_email" value="{{ $affiliate_user->paypal_email ?? '' }}"></div>
        <div class="acc-field"><label>{{ translate('Bank Information') }}</label><textarea name="bank_information" rows="4">{{ $affiliate_user->bank_information ?? '' }}</textarea></div>
        <button type="submit" class="mp-btn mp-btn--primary">{{ translate('Save') }}</button>
    </form>
</div>
@endsection
