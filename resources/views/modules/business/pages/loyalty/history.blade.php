@extends('modules.account.layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ static_asset('assets/modules/business/css/business.css') }}?v=1.0.0">
@endpush

@section('account_content')
<div class="biz-page">
    <div class="biz-page__head">
        <h1>{{ translate('Point History') }}</h1>
        <span class="biz-badge">{{ $total_points }} {{ translate('points available') }}</span>
    </div>
    <div class="biz-page__actions mb-3">
        <a href="{{ route('business.loyalty.redeem') }}" class="mp-btn mp-btn--primary">{{ translate('Redeem Points') }}</a>
    </div>
    <table class="biz-table">
        <thead><tr><th>{{ translate('Order') }}</th><th>{{ translate('Points') }}</th><th>{{ translate('Status') }}</th><th>{{ translate('Date') }}</th></tr></thead>
        <tbody>
            @forelse($club_points as $point)
                <tr>
                    <td>#{{ $point->order_id }}</td>
                    <td>{{ $point->points }}</td>
                    <td>{{ $point->convert_status ? translate('Converted') : translate('Available') }}</td>
                    <td>{{ $point->created_at->format('M d, Y') }}</td>
                </tr>
            @empty
                <tr><td colspan="4">{{ translate('No points earned yet') }}</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $club_points->links() }}
</div>
@endsection
