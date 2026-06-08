@extends('modules.account.layouts.app')

@section('account_content')
    <div class="acc-page-head">
        <h1>{{ $conversation->title }}</h1>
        <a href="{{ route('conversations.index') }}" class="mp-btn mp-btn--outline">&larr; {{ translate('Back') }}</a>
    </div>

    <div class="acc-card" id="acc-messages" style="max-height:400px;overflow-y:auto;">
        @foreach ($conversation->messages as $message)
            <div style="margin-bottom:1rem;{{ $message->user_id === auth()->id() ? 'text-align:right;' : '' }}">
                <div style="display:inline-block;max-width:80%;padding:0.75rem 1rem;border-radius:12px;{{ $message->user_id === auth()->id() ? 'background:var(--mp-primary);color:#fff;' : 'background:#f1f5f9;' }}">
                    <p style="margin:0;">{{ $message->message }}</p>
                </div>
                <p style="margin:0.25rem 0 0;font-size:0.75rem;color:var(--mp-muted);">{{ $message->created_at->format('M d, H:i') }}</p>
            </div>
        @endforeach
    </div>

    <div class="acc-card">
        <form action="{{ route('conversations.update', $conversation->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="acc-field">
                <textarea name="message" rows="2" placeholder="{{ translate('Type your message...') }}" required></textarea>
            </div>
            <button type="submit" class="mp-btn mp-btn--primary">{{ translate('Send') }}</button>
        </form>
    </div>
@endsection
