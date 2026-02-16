<div class="mb-4">
    <h3 class="fs-16 fw-700 text-dark">
        {{ translate('Any additional info?') }}
    </h3>
    <textarea name="additional_info" rows="5" class="form-control rounded-0"
        placeholder="{{ translate('Type your text...') }}"></textarea>
</div>
<div>
    <h3 class="fs-16 fw-700 text-dark">
        {{ translate('Select a payment option') }}
    </h3>
    <div class="row gutters-10">
        @foreach (get_activate_payment_methods() as $payment_method)
            <div class="col-xl-4 col-md-6">
                <label class="aiz-megabox d-block mb-3">
                    <input value="{{ $payment_method->name }}" class="online_payment" type="radio"
                        name="payment_option" checked>
                    <span class="d-flex align-items-center justify-content-between aiz-megabox-elem rounded-0 p-3">
                        <span class="d-block fw-400 fs-14">{{ ucfirst(translate($payment_method->name)) }}</span>
                        <span class="rounded-1 h-40px overflow-hidden">
                            <img src="{{ static_asset('assets/img/cards/'.$payment_method->name.'.png') }}"
                            class="img-fit h-100">
                        </span>
                    </span>
                </label>
            </div>
        @endforeach

        <!-- Cash Payment -->
        @if (get_setting('cash_payment') == 1)
            @php
                $digital = 0;
                $cod_on = 1;
                foreach ($carts as $cartItem) {
                    $product = get_single_product($cartItem['product_id']);
                    if ($product['digital'] == 1) {
                        $digital = 1;
                    }
                    if ($product['cash_on_delivery'] == 0) {
                        $cod_on = 0;
                    }
                }
            @endphp
            @if ($digital != 1 && $cod_on == 1)
                <div class="col-xl-4 col-md-6">
                    <label class="aiz-megabox d-block mb-3">
                        <input value="cash_on_delivery" class="online_payment" type="radio"
                            name="payment_option" checked>
                        <span class="d-flex align-items-center justify-content-between aiz-megabox-elem rounded-0 p-3">
                            <span class="d-block fw-400 fs-14">{{ translate('Cash on Delivery') }}</span>
                            <span class="rounded-1 h-40px w-70px overflow-hidden">
                                <img src="{{ static_asset('assets/img/cards/cod.png') }}"
                                class="img-fit h-100">
                            </span>
                        </span>
                    </label>
                </div>
            @endif
        @endif

        @if (Auth::check())
            <!-- Offline Payment -->
            @if (addon_is_activated('offline_payment'))
                @foreach (get_all_manual_payment_methods() as $method)
                    <div class="col-xl-4 col-md-6">
                        <label class="aiz-megabox d-block mb-3">
                            <input value="{{ $method->heading }}" type="radio"
                                name="payment_option" class="offline_payment_option"
                                onchange="toggleManualPaymentData({{ $method->id }})"
                                data-id="{{ $method->id }}" checked>
                            <span class="d-flex align-items-center justify-content-between aiz-megabox-elem rounded-0 p-3">
                                <span class="d-block fw-400 fs-14">{{ $method->heading }}</span>
                                <span class="rounded-1 h-40px w-70px overflow-hidden">
                                    <img src="{{ uploaded_asset($method->photo) }}"
                                    class="img-fit h-100">
                                </span>
                            </span>
                        </label>
                    </div>
                @endforeach

                @foreach (get_all_manual_payment_methods() as $method)
                    <div id="manual_payment_info_{{ $method->id }}" class="d-none">
                        @php echo $method->description @endphp
                        @if ($method->bank_info != null)
                            <ul>
                                @foreach (json_decode($method->bank_info) as $key => $info)
                                    <li>{{ translate('Bank Name') }} -
                                        {{ $info->bank_name }},
                                        {{ translate('Account Name') }} -
                                        {{ $info->account_name }},
                                        {{ translate('Account Number') }} -
                                        {{ $info->account_number }},
                                        {{ translate('Routing Number') }} -
                                        {{ $info->routing_number }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                @endforeach
            @endif
        @endif
    </div>

    <!-- Offline Payment Fields -->
    @if (addon_is_activated('offline_payment') && count(get_all_manual_payment_methods())>0)
        <div class="d-none mb-3 rounded border bg-white p-3 text-left">
            <div id="manual_payment_description">

            </div>
            <br>
            <div class="row">
                <div class="col-md-3">
                    <label>{{ translate('Transaction ID') }} <span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control mb-3" name="trx_id" onchange="stepCompletionPaymentInfo()"
                        id="trx_id" placeholder="{{ translate('Transaction ID') }}"
                        required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 col-form-label">{{ translate('Photo') }}</label>
                <div class="col-md-9">
                    <div class="input-group" data-toggle="aizuploader" data-type="image">
                        <div class="input-group-prepend">
                            <div class="input-group-text bg-soft-secondary font-weight-medium">
                                {{ translate('Browse') }}</div>
                        </div>
                        <div class="form-control file-amount">{{ translate('Choose image') }}
                        </div>
                        <input type="hidden" name="photo" class="selected-files">
                    </div>
                    <div class="file-preview box sm">
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Card Number -->
    <div class="row">
        <div class="col-md-2 d-flex align-items-center">
            <label class="mb-0">{{ translate('Card number') }} <span class="text-danger">*</span></label>
        </div>
        <div class="col-md-10">
            <div class="position-relative">
                <input type="text"
                       class="form-control stripe-input"
                       placeholder="1234 1234 1234 1234"
                       name="card_number"
                       id="cardNumber"
                       autocomplete="cc-number"
                       inputmode="numeric"
                       maxlength="19"
                       required>
                <div class="input-icon">
                    <img src="https://js.stripe.com/v3/fingerprinted/img/visa-729c05c240c4bdb47b03ac81d9945bfe.svg" alt="Visa">
                    <img src="https://js.stripe.com/v3/fingerprinted/img/mastercard-4d8844094130711885b5e41b28c9848f.svg" alt="MasterCard">
                </div>
            </div>
        </div>
    </div>
    
    <div class="mb-3"></div>
    
    <!-- Expiry + CVC -->
    <div class="row">
        <div class="col-md-2 d-flex align-items-center">
            <label class="mb-0">{{ translate('Expiry') }} <span class="text-danger">*</span></label>
        </div>
        <div class="col-md-4">
            <input type="text"
                   id="expiry"
                   class="form-control stripe-input"
                   placeholder="{{ translate('MM / YY') }}"
                   maxlength="7"
                   name="card_expiry"
                   autocomplete="cc-exp"
                   inputmode="numeric"
                   required>
        </div>
    
        <div class="col-md-2 d-flex align-items-center justify-content-end">
            <label class="mb-0">{{ translate('CVC') }} <span class="text-danger">*</span></label>
        </div>
        <div class="col-md-4">
            <div class="position-relative w-100">
                <input type="text"
                       id="cvc"
                       class="form-control stripe-input"
                       placeholder="{{ translate('CVC') }}"
                       maxlength="4"
                       name="card_cvv"
                       autocomplete="cc-csc"
                       inputmode="numeric"
                       required>
                       <div class="input-icon cvc-icon">
                            <svg class="Icon Icon--md" width="30" height="20" viewBox="0 0 30 20" xmlns="http://www.w3.org/2000/svg" fill="var(--colorIconCardCvc)" role="img" aria-labelledby="cvcIconTitle"><title id="cvcIconTitle">Credit or debit card CVC</title><g opacity="0.74"><path fill-rule="evenodd" clip-rule="evenodd" d="M25.2061 0.00488281C27.3194 0.112115 29 1.85996 29 4V11.3291C28.5428 11.0304 28.0336 10.8304 27.5 10.7188V8H1.5V16C1.5 17.3807 2.61929 18.5 4 18.5H10.1104V20H4L3.79395 19.9951C1.7488 19.8913 0.108652 18.2512 0.00488281 16.2061L0 16V4C0 1.85996 1.68056 0.112115 3.79395 0.00488281L4 0H25L25.2061 0.00488281ZM4 1.5C2.61929 1.5 1.5 2.61929 1.5 4V5H27.5V4C27.5 2.61929 26.3807 1.5 25 1.5H4Z"></path><path d="M27.5 12.7988C28.3058 13.1128 28.7725 13.7946 28.7725 14.6406C28.7722 15.4002 28.2721 15.9399 27.6523 16.1699C28.1601 16.3319 28.6072 16.6732 28.8086 17.2207C28.3597 18.6222 27.1605 19.6862 25.6826 19.9404C24.8389 19.7707 24.1662 19.2842 23.834 18.5H25C25.0914 18.5 25.1816 18.4939 25.2705 18.4844C25.5434 18.7862 25.9284 18.9501 26.3623 18.9502C27.142 18.9501 27.6922 18.5297 27.6924 17.79C27.6923 17.4212 27.5473 17.1544 27.2998 16.9795C27.4281 16.6786 27.5 16.3478 27.5 16V15.0527C27.5397 14.9481 27.5625 14.8309 27.5625 14.7002C27.5625 14.5657 27.5399 14.4422 27.5 14.3311V12.7988Z"></path><path d="M15.2207 18.5V18.8301H16.8799V19.9004H12.1104V18.8301H13.9902V18.5H15.2207Z"></path><path d="M19.9307 18.5L19.5762 18.7803H22.8369V19.9004H17.8164V18.8604L18.2549 18.5H19.9307Z"></path></g><path d="M26.3822 20.01C24.9722 20.01 23.8522 19.25 23.6422 17.81L24.8722 17.58C24.9922 18.45 25.6022 18.95 26.3622 18.95C27.1422 18.95 27.6922 18.53 27.6922 17.79C27.6922 17.05 27.1122 16.72 26.2822 16.72H25.5722V15.67H26.3022C27.0622 15.67 27.5622 15.34 27.5622 14.7C27.5622 14.07 27.1022 13.68 26.3922 13.68C25.6422 13.68 25.1322 14.18 24.9822 14.92L23.8122 14.76C24.0022 13.55 24.9822 12.61 26.4322 12.61C27.8822 12.61 28.7722 13.47 28.7722 14.64C28.7722 15.4 28.2722 15.94 27.6522 16.17C28.3422 16.39 28.9222 16.94 28.9222 17.89C28.9222 19.04 27.9522 20.01 26.3822 20.01Z"></path><path d="M17.8161 18.86L19.6161 17.38C20.5961 16.58 21.4761 15.87 21.4761 14.97C21.4761 14.23 21.0161 13.7 20.2561 13.7C19.5061 13.7 19.0161 14.29 19.0161 15C19.0161 15.23 19.0561 15.46 19.1361 15.68H17.9461C17.8461 15.39 17.8161 15.2 17.8161 14.93C17.8161 13.58 18.9261 12.61 20.2861 12.61C21.7861 12.61 22.7461 13.54 22.7461 14.89C22.7461 16.16 21.7861 17.03 20.7761 17.83L19.5761 18.78H22.8361V19.9H17.8161V18.86Z"></path><path d="M14.25 12.67H15.22V18.83H16.88V19.9H12.11V18.83H13.99V14.92H12.15V13.99L12.88 13.93C13.78 13.86 14.18 13.58 14.25 12.67Z"></path></svg>
                    </div>
            </div>
        </div>
    </div>
    <!-- Wallet Payment -->
    @if (Auth::check() && get_setting('wallet_system') == 1)
        <div class="py-4 px-4 text-center bg-soft-secondary-base mt-4">
            <div class="fs-14 mb-3">
                <span class="opacity-80">{{ translate('Or, Your wallet balance :') }}</span>
                <span class="fw-700">{{ single_price(Auth::user()->balance) }}</span>
            </div>
            @if (Auth::user()->balance < $total)
                <button type="button" class="btn btn-secondary" disabled>
                    {{ translate('Insufficient balance') }}
                </button>
            @else
                <button type="button" onclick="use_wallet()"
                    class="btn btn-primary fs-14 fw-700 px-5 rounded-0">
                    {{ translate('Pay with wallet') }}
                </button>
            @endif
        </div>
    @endif
</div>
