@extends('modules.account.layouts.app')

@section('account_content')
<div class="acc-page-head">
    <h1>{{ translate('Notifications') }}</h1>
</div>
<div class="acc-card">
    <ul class="biz-notif-list">
        @forelse($notifications as $notification)
            <li class="{{ $notification->read_at ? '' : 'is-unread' }}">
                <div>
                    <strong>{{ $notification->data['title'] ?? class_basename($notification->type) }}</strong>
                    <p>{{ $notification->data['message'] ?? ($notification->data['body'] ?? '') }}</p>
                    <small>{{ $notification->created_at->diffForHumans() }}</small>
                </div>
            </li>
        @empty
            <li class="biz-empty">{{ translate('No notifications') }}</li>
        @endforelse
    </ul>
    {{ $notifications->links() }}
</div>
@endsection
