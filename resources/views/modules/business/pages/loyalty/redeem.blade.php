@extends('modules.account.layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ static_asset('assets/modules/business/css/business.css') }}?v=1.0.0">
@endpush

@section('account_content')
<div class="biz-page">
    <h1>{{ translate('Point Redemption') }}</h1>
    <p>{{ translate('Convert club points into wallet balance.') }} {{ translate('Rate') }}: {{ get_setting('club_point_convert_rate') }} {{ translate('points per unit') }}</p>
    <div class="biz-panel">
        @forelse($club_points as $point)
            <div class="biz-redeem-row">
                <div>
                    <strong>{{ $point->points }} {{ translate('points') }}</strong>
                    <small>{{ translate('Order') }} #{{ $point->order_id }}</small>
                </div>
                <form action="{{ route('convert_point_into_wallet') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $point->id }}">
                    <button type="submit" class="mp-btn mp-btn--primary btn-sm">{{ translate('Convert to Wallet') }}</button>
                </form>
            </div>
        @empty
            <p class="biz-empty">{{ translate('No redeemable points') }}</p>
        @endforelse
    </div>
</div>
@endsection
