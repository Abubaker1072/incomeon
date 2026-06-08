@php
    $loginHero = get_setting('admin_login_page_image')
        ? uploaded_asset(get_setting('admin_login_page_image'))
        : static_asset('assets/img/auth/login-hero.png');
@endphp

<div class="auth-page">
    <div class="auth-card">
        <div class="auth-card__row">
            {{-- Left: attached hero image --}}
            <div class="auth-card__hero">
                <img src="{{ $loginHero }}" alt="{{ translate('Login') }}">
            </div>

            {{-- Right: login form --}}
            <div class="auth-card__form">
                <div class="auth-card__logo">
                    <img src="{{ uploaded_asset(get_setting('site_icon')) }}" alt="{{ translate('Site Icon') }}">
                </div>

                <h1 class="auth-card__title">{{ translate('Welcome to') }} {{ env('APP_NAME') }}</h1>
                <p class="auth-card__sub">{{ translate('Login to your account.') }}</p>

                <form action="{{ route('login') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="email" class="fs-12 fw-700 text-muted">{{ translate('Email') }}</label>
                        <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                            value="{{ old('email') }}" placeholder="{{ translate('johndoe@example.com') }}"
                            name="email" id="email" autocomplete="email" autofocus>
                        @if ($errors->has('email'))
                            <span class="invalid-feedback d-block"><strong>{{ $errors->first('email') }}</strong></span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="password" class="fs-12 fw-700 text-muted">{{ translate('Password') }}</label>
                        <div class="position-relative">
                            <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                placeholder="{{ translate('Password') }}" name="password" id="password" autocomplete="current-password">
                            <i class="password-toggle las la-eye"></i>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <label class="mb-0 d-flex align-items-center gap-1" style="gap:0.4rem;font-size:0.875rem;">
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            {{ translate('Remember Me') }}
                        </label>
                        <a href="{{ route('password.request') }}" class="text-primary" style="font-size:0.875rem;">{{ translate('Forgot password?') }}</a>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">{{ translate('Login') }}</button>
                </form>

                @if (env('DEMO_MODE') == 'On')
                    <div class="mt-4">
                        <table class="table table-bordered table-sm">
                            <tbody>
                                <tr>
                                    <td>admin@example.com</td>
                                    <td>123456</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-info btn-sm" onclick="autoFillAdmin()">{{ translate('Copy') }}</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        <div class="auth-back">
            <a href="{{ url()->previous() }}"><i class="las la-arrow-left"></i> {{ translate('Back to Previous Page') }}</a>
        </div>
    </div>
</div>
