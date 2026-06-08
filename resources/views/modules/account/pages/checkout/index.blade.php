@extends('modules.account.layouts.app')

@section('content_class') acc-checkout-page @endsection

@section('account_content')
    <div class="acc-page-head">
        <h1>{{ translate('Checkout') }}</h1>
    </div>

    @include('modules.account.components.checkout-wizard', ['step' => 1])

    <div class="acc-checkout-grid">
        <div>
            @auth
                @php $addresses = auth()->user()->addresses; @endphp
                <div class="acc-card">
                    <h3 style="margin:0 0 1rem;">{{ translate('Select Delivery Address') }}</h3>
                    @forelse ($addresses as $address)
                        <label class="acc-address-card {{ $address_id == $address->id ? 'is-selected' : '' }}">
                            <input type="radio" name="address_id" value="{{ $address->id }}" class="acc-address-radio"
                                {{ $address_id == $address->id ? 'checked' : '' }} style="margin-right:0.5rem;">
                            <strong>{{ $address->address }}</strong>
                            <p style="margin:0.35rem 0 0;font-size:0.85rem;color:var(--mp-muted);">
                                {{ $address->city?->getTranslation('name') }}, {{ $address->state?->name }} — {{ $address->phone }}
                            </p>
                        </label>
                    @empty
                        <p style="color:var(--mp-muted);">{{ translate('No address found.') }}</p>
                    @endforelse
                    <button type="button" class="mp-btn mp-btn--outline" id="acc-add-address-btn" style="margin-top:0.5rem;">
                        <i class="las la-plus"></i> {{ translate('Add New Address') }}
                    </button>
                </div>
            @else
                <div class="acc-card">
                    <h3 style="margin:0 0 1rem;">{{ translate('Guest Checkout') }}</h3>
                    <p style="color:var(--mp-muted);font-size:0.9rem;">
                        <a href="{{ route('user.login') }}" style="color:var(--mp-primary);">{{ translate('Login') }}</a>
                        {{ translate('for a faster checkout experience.') }}
                    </p>
                </div>
            @endauth

            <div id="acc-delivery-info" class="acc-card" style="margin-top:1rem;">
                @include('modules.account.partials.cart.delivery-info', ['carts' => $carts, 'carrier_list' => $carrier_list ?? [], 'shipping_info' => $shipping_info ?? []])
            </div>

            <div class="acc-card" style="margin-top:1rem;">
                <h3 style="margin:0 0 1rem;">{{ translate('Payment Method') }}</h3>
                <form action="{{ route('payment.checkout') }}" method="POST" id="acc-checkout-form">
                    @csrf
                    @foreach (get_activate_payment_methods() as $method)
                        <label class="acc-payment-option">
                            <input type="radio" name="payment_option" value="{{ $method->name }}" {{ $loop->first ? 'checked' : '' }} required>
                            <span>{{ ucfirst(str_replace('_', ' ', $method->name)) }}</span>
                        </label>
                    @endforeach
                    @if (get_setting('wallet_system') == 1 && auth()->check() && auth()->user()->balance > 0)
                        <label class="acc-payment-option">
                            <input type="radio" name="payment_option" value="wallet">
                            <span>{{ translate('Wallet') }} ({{ single_price(auth()->user()->balance) }})</span>
                        </label>
                    @endif
                    <button type="submit" class="mp-btn mp-btn--primary" style="width:100%;justify-content:center;margin-top:1rem;">
                        {{ translate('Complete Order') }}
                    </button>
                </form>
            </div>
        </div>

        <div id="acc-checkout-summary">
            @include('modules.account.partials.cart.cart-summary', ['carts' => $carts, 'proceed' => 1])
        </div>
    </div>

    @auth
        @include('modules.account.partials.address.address-modal')
    @endauth
@endsection
