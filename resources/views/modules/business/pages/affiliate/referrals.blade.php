@extends('modules.account.layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ static_asset('assets/modules/business/css/business.css') }}?v=1.0.0">
@endpush

@section('account_content')
<div class="biz-page">
    <h1>{{ translate('Referral Tracking') }}</h1>
    <table class="biz-table">
        <thead><tr><th>{{ translate('User') }}</th><th>{{ translate('Order') }}</th><th>{{ translate('Amount') }}</th><th>{{ translate('Date') }}</th></tr></thead>
        <tbody>
            @forelse($logs as $log)
                <tr>
                    <td>{{ optional($log->user)->name ?? '—' }}</td>
                    <td>#{{ $log->order_id }}</td>
                    <td>{{ single_price($log->amount) }}</td>
                    <td>{{ $log->created_at->format('M d, Y') }}</td>
                </tr>
            @empty
                <tr><td colspan="4">{{ translate('No referrals yet') }}</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $logs->links() }}
</div>
@endsection
