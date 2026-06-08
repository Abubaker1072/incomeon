@extends('modules.account.layouts.app')

@section('account_content')
    <div class="acc-page-head">
        <h1>{{ translate('Support Tickets') }}</h1>
    </div>

    <div class="acc-card">
        <h3 style="margin:0 0 1rem;">{{ translate('Create New Ticket') }}</h3>
        <form action="{{ route('support_ticket.store') }}" method="POST">
            @csrf
            <div class="acc-field">
                <label>{{ translate('Subject') }}</label>
                <input type="text" name="subject" required>
            </div>
            <div class="acc-field">
                <label>{{ translate('Details') }}</label>
                <textarea name="details" rows="4" required></textarea>
            </div>
            <button type="submit" class="mp-btn mp-btn--primary">{{ translate('Submit Ticket') }}</button>
        </form>
    </div>

    <div class="acc-card">
        <h3 style="margin:0 0 1rem;">{{ translate('My Tickets') }}</h3>
        @if ($tickets->count())
            <div class="acc-table-wrap">
                <table class="acc-table">
                    <thead>
                        <tr>
                            <th>{{ translate('Code') }}</th>
                            <th>{{ translate('Subject') }}</th>
                            <th>{{ translate('Status') }}</th>
                            <th>{{ translate('Date') }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tickets as $ticket)
                            <tr>
                                <td>{{ $ticket->code }}</td>
                                <td>{{ $ticket->subject }}</td>
                                <td><span class="acc-badge acc-badge--info">{{ translate(ucfirst($ticket->status)) }}</span></td>
                                <td>{{ $ticket->created_at->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{ route('support_ticket.show', encrypt($ticket->id)) }}" class="mp-btn mp-btn--outline" style="padding:0.3rem 0.65rem;font-size:0.8rem;">{{ translate('View') }}</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div style="margin-top:1.5rem;">
                @include('modules.marketplace.components.pagination', ['paginator' => $tickets])
            </div>
        @else
            <p style="color:var(--mp-muted);">{{ translate('No tickets yet.') }}</p>
        @endif
    </div>
@endsection
