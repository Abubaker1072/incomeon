@extends('modules.account.layouts.app')

@section('account_content')
    <div class="acc-page-head">
        <h1>{{ translate('Ticket') }} #{{ $ticket->code }}</h1>
        <a href="{{ route('support_ticket.index') }}" class="mp-btn mp-btn--outline">&larr; {{ translate('Back') }}</a>
    </div>

    <div class="acc-card">
        <h3 style="margin:0 0 0.5rem;">{{ $ticket->subject }}</h3>
        <p style="color:var(--mp-muted);font-size:0.85rem;margin:0 0 1rem;">{{ $ticket->created_at->format('M d, Y H:i') }} · <span class="acc-badge acc-badge--info">{{ translate(ucfirst($ticket->status)) }}</span></p>
        <p style="margin:0;line-height:1.6;">{{ $ticket->details }}</p>
    </div>

    @foreach ($ticket_replies as $reply)
        <div class="acc-card" style="margin-left:{{ $reply->user_id === auth()->id() ? '0' : '1.5rem' }};">
            <p style="margin:0 0 0.35rem;font-weight:600;">{{ $reply->user->name }}</p>
            <p style="margin:0 0 0.35rem;font-size:0.8rem;color:var(--mp-muted);">{{ $reply->created_at->format('M d, Y H:i') }}</p>
            <p style="margin:0;">{{ $reply->reply }}</p>
        </div>
    @endforeach

    <div class="acc-card">
        <form action="{{ route('support_ticket.seller_store') }}" method="POST">
            @csrf
            <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
            <input type="hidden" name="user_id" value="{{ auth()->id() }}">
            <div class="acc-field">
                <label>{{ translate('Your Reply') }}</label>
                <textarea name="reply" rows="3" required></textarea>
            </div>
            <button type="submit" class="mp-btn mp-btn--primary">{{ translate('Send Reply') }}</button>
        </form>
    </div>
@endsection
