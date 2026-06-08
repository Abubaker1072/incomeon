@php $step = $step ?? 1; @endphp
<div class="acc-checkout-steps">
    <span class="acc-checkout-step {{ $step >= 1 ? ($step === 1 ? 'is-active' : 'is-done') : '' }}">
        <i class="las la-map-marker"></i> {{ translate('Address') }}
    </span>
    <span class="acc-checkout-step {{ $step >= 2 ? ($step === 2 ? 'is-active' : 'is-done') : '' }}">
        <i class="las la-truck"></i> {{ translate('Shipping') }}
    </span>
    <span class="acc-checkout-step {{ $step >= 3 ? ($step === 3 ? 'is-active' : 'is-done') : '' }}">
        <i class="las la-credit-card"></i> {{ translate('Payment') }}
    </span>
</div>
