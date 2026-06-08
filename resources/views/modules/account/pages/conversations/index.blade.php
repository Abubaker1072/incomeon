@extends('modules.account.layouts.app')

@section('account_content')
    <div class="acc-page-head">
        <h1>{{ translate('Chat With Sellers') }}</h1>
    </div>

    <div class="acc-card">
        @if ($conversations->count())
            @foreach ($conversations as $conversation)
                @php $other = $conversation->sender_id == auth()->id() ? $conversation->receiver : $conversation->sender; @endphp
                <a href="{{ route('conversations.show', encrypt($conversation->id)) }}" style="display:flex;align-items:center;gap:1rem;padding:1rem 0;border-bottom:1px solid var(--mp-border);color:inherit;">
                    <div style="width:44px;height:44px;border-radius:50%;background:var(--mp-primary);color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;">
                        {{ strtoupper(substr($other->name ?? 'S', 0, 1)) }}
                    </div>
                    <div style="flex:1;">
                        <strong>{{ $other->name ?? translate('Seller') }}</strong>
                        <p style="margin:0.2rem 0 0;font-size:0.85rem;color:var(--mp-muted);">{{ Str::limit($conversation->title, 60) }}</p>
                    </div>
                    <i class="las la-angle-right" style="color:var(--mp-muted);"></i>
                </a>
            @endforeach
        @else
            <p style="color:var(--mp-muted);">{{ translate('No conversations yet.') }}</p>
        @endif
    </div>
@endsection
