@extends('modules.account.layouts.auth')

@section('auth_title', translate('Create Account'))

@section('auth_content')
    <h1 class="auth-card__title">{{ translate('Create Account') }}</h1>
    <p class="acc-auth__sub">{{ translate('Join us and start shopping today.') }}</p>

    <form method="POST" action="{{ route('register') }}" id="register-form" data-auth-form>
        @csrf
        <input type="hidden" name="account_type" id="account_type" value="{{ old('account_type', 'customer') }}">

        <div class="acc-field">
            <label>{{ translate('Register as') }} <span class="text-danger">*</span></label>
            <div class="acc-role-toggle" role="group" aria-label="{{ translate('Account type') }}">
                <button type="button" class="acc-role-btn {{ old('account_type', 'customer') === 'customer' ? 'is-active' : '' }}" data-role="customer">
                    <span class="acc-role-btn__bulb" aria-hidden="true"></span>
                    <i class="las la-user"></i>
                    <span>{{ translate('Customer') }}</span>
                </button>
                <button type="button" class="acc-role-btn {{ old('account_type') === 'vendor' ? 'is-active' : '' }}" data-role="vendor">
                    <span class="acc-role-btn__bulb" aria-hidden="true"></span>
                    <i class="las la-store"></i>
                    <span>{{ translate('Vendor') }}</span>
                </button>
            </div>
            @error('account_type')
                <span class="acc-field-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="acc-field">
            <label for="name">{{ translate('Full Name') }} <span class="text-danger">*</span></label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required>
            @error('name')
                <span class="acc-field-error">{{ $message }}</span>
            @enderror
        </div>
        <div class="acc-field">
            <label for="email">{{ translate('Email') }} <span class="text-danger">*</span></label>
            <input type="email" id="email" name="email" value="{{ old('email', $email ?? '') }}" required>
            @error('email')
                <span class="acc-field-error">{{ $message }}</span>
            @enderror
        </div>
        <div class="acc-field">
            <label for="password">{{ translate('Password') }} <span class="text-danger">*</span></label>
            <input type="password" id="password" name="password" required>
            @error('password')
                <span class="acc-field-error">{{ $message }}</span>
            @enderror
        </div>
        <div class="acc-field">
            <label for="password_confirmation">{{ translate('Confirm Password') }} <span class="text-danger">*</span></label>
            <input type="password" id="password_confirmation" name="password_confirmation" required>
        </div>

        <div id="vendor-fields" class="acc-vendor-collapse {{ old('account_type') === 'vendor' ? 'is-open' : '' }}">
            <div class="acc-vendor-fields">
                <p class="acc-vendor-fields__title">
                    <i class="las la-store"></i> {{ translate('Vendor / Brand Details') }}
                </p>
                <div class="acc-field">
                    <label for="shop_name">{{ translate('Brand Name') }} <span class="text-danger">*</span></label>
                    <input type="text" id="shop_name" name="shop_name" value="{{ old('shop_name') }}">
                    @error('shop_name')
                        <span class="acc-field-error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="acc-field">
                    <label for="address">{{ translate('Brand Address') }} <span class="text-danger">*</span></label>
                    <textarea id="address" name="address" rows="3">{{ old('address') }}</textarea>
                    @error('address')
                        <span class="acc-field-error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="acc-field">
                    <label for="phone">{{ translate('Brand Phone Number') }} <span class="text-danger">*</span></label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone', $phone ?? '') }}">
                    @error('phone')
                        <span class="acc-field-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        @if (get_setting('google_recaptcha') == 1)
            <div class="acc-field">
                <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
                @error('g-recaptcha-response')
                    <span class="acc-field-error">{{ $message }}</span>
                @enderror
            </div>
        @endif

        <button type="submit" class="auth-btn auth-btn--primary auth-btn--block" id="register-submit">
            <i class="las la-user-check"></i> {{ translate('Register as Customer') }}
        </button>
    </form>

    <div class="auth-actions">
        <p class="auth-actions__label">{{ translate('Already have an account?') }}</p>
        <div class="auth-actions__buttons auth-actions__buttons--single">
            <a href="{{ route('user.login') }}" class="auth-btn auth-btn--outline" data-auth-nav>
                <i class="las la-sign-in-alt"></i> {{ translate('Sign In') }}
            </a>
        </div>
    </div>

    @if (get_setting('google_recaptcha') == 1)
        @push('scripts')
            <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        @endpush
    @endif

    @push('scripts')
        <script>
            (function () {
                var typeInput = document.getElementById('account_type');
                var vendorFields = document.getElementById('vendor-fields');
                var submitBtn = document.getElementById('register-submit');
                var shopName = document.getElementById('shop_name');
                var phone = document.getElementById('phone');
                var address = document.getElementById('address');

                function setVendorRequired(isVendor) {
                    [shopName, phone, address].forEach(function (el) {
                        if (!el) return;
                        el.required = isVendor;
                    });
                }

                function setRole(role) {
                    typeInput.value = role;
                    document.querySelectorAll('.acc-role-btn').forEach(function (btn) {
                        btn.classList.toggle('is-active', btn.getAttribute('data-role') === role);
                    });

                    var isVendor = role === 'vendor';
                    vendorFields.classList.toggle('is-open', isVendor);
                    setVendorRequired(isVendor);

                    var label = isVendor
                        ? @json(translate('Register as Vendor'))
                        : @json(translate('Register as Customer'));
                    submitBtn.innerHTML = '<i class="las la-user-check"></i> ' + label;
                }

                document.querySelectorAll('.acc-role-btn').forEach(function (btn) {
                    btn.addEventListener('click', function () {
                        setRole(btn.getAttribute('data-role'));
                    });
                });

                setRole(typeInput.value || 'customer');
            })();
        </script>
    @endpush
@endsection
