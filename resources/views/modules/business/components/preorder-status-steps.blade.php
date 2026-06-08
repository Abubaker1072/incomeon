@php
    $steps = [
        ['label' => translate('Reserved'), 'done' => true],
        ['label' => translate('Deposit Paid'), 'done' => in_array($order->prepayment_status ?? '', ['paid', 'completed'])],
        ['label' => translate('In Production'), 'done' => ($order->status ?? '') !== 'pending'],
        ['label' => translate('Final Payment'), 'done' => ($order->final_payment_status ?? '') === 'paid'],
        ['label' => translate('Delivered'), 'done' => ($order->delivery_status ?? '') === 'delivered'],
    ];
@endphp
<div class="biz-preorder-steps">
    @foreach($steps as $i => $step)
        <div class="biz-preorder-steps__item {{ $step['done'] ? 'is-done' : '' }} {{ $loop->last ? '' : '' }}">
            <div class="biz-preorder-steps__dot">{{ $i + 1 }}</div>
            <span>{{ $step['label'] }}</span>
        </div>
        @if(!$loop->last)<div class="biz-preorder-steps__line {{ $step['done'] ? 'is-done' : '' }}"></div>@endif
    @endforeach
</div>
