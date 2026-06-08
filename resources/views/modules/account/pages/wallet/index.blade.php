@extends('modules.account.layouts.app')

@section('account_content')
    <div class="acc-page-head">
        <h1>{{ translate('My Wallet') }}</h1>
    </div>

    @include('modules.account.components.wallet-card', ['balance' => auth()->user()->balance])

    <div class="acc-card">
        <h3 style="margin:0 0 1rem;">{{ translate('Transaction History') }}</h3>
        @if ($wallets->count())
            <div class="acc-table-wrap">
                <table class="acc-table">
                    <thead>
                        <tr>
                            <th>{{ translate('Date') }}</th>
                            <th>{{ translate('Amount') }}</th>
                            <th>{{ translate('Payment Method') }}</th>
                            <th>{{ translate('Type') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($wallets as $wallet)
                            <tr>
                                <td>{{ $wallet->created_at->format('M d, Y') }}</td>
                                <td style="color:{{ $wallet->approval ? '#16a34a' : 'var(--mp-dark)' }};">
                                    {{ $wallet->approval ? '+' : '-' }}{{ single_price($wallet->amount) }}
                                </td>
                                <td>{{ $wallet->payment_method }}</td>
                                <td>
                                    <span class="acc-badge acc-badge--{{ $wallet->approval ? 'success' : 'warning' }}">
                                        {{ $wallet->approval ? translate('Credit') : translate('Debit') }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div style="margin-top:1.5rem;">
                @include('modules.marketplace.components.pagination', ['paginator' => $wallets])
            </div>
        @else
            <p style="color:var(--mp-muted);">{{ translate('No transactions yet.') }}</p>
        @endif
    </div>
@endsection
