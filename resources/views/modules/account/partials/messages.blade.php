@foreach ($conversation->messages as $message)
    <div class="acc-msg {{ $message->user_id === auth()->id() ? 'acc-msg--mine' : 'acc-msg--theirs' }}">
        <div class="acc-msg__bubble">{{ $message->message }}</div>
        <small>{{ $message->created_at->format('M d, H:i') }}</small>
    </div>
@endforeach
