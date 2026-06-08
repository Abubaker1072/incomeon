<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if(get_setting('site_icon'))
        <link rel="icon" href="{{ uploaded_asset(get_setting('site_icon')) }}">
    @endif
    <title>@yield('auth_title', translate('Sign In')) | {{ get_setting('site_name') }}</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;500;600;700&display=swap">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="{{ static_asset('assets/css/auth-login.css') }}?v=1.2.1">
    <link rel="stylesheet" href="{{ static_asset('assets/css/responsive-global.css') }}?v=1.0.0">
    <link rel="stylesheet" href="{{ static_asset('assets/modules/account/css/account.css') }}?v=1.1.0">
</head>
<body class="auth-body">
    <div class="auth-page-loader is-active" id="auth-page-loader" aria-hidden="false">
        <div class="auth-page-loader__inner">
            <div class="auth-spinner"></div>
            <span>{{ translate('Loading') }}...</span>
        </div>
    </div>

    @include('modules.account.layouts.partials.flash')
    <div class="auth-page">
        <div class="auth-card @yield('auth_card_class')" style="width:min(100%,@yield('auth_card_width','960px'));">
            <div class="auth-card__row">
                <div class="auth-card__hero">
                    <img src="{{ static_asset('assets/img/auth/login-hero.png') }}" alt="{{ translate('Login') }}">
                </div>
                <div class="auth-card__form acc-auth__card" style="width:100%;max-width:none;box-shadow:none;border:none;border-radius:0;">
                    @yield('auth_content')
                </div>
            </div>
            <div class="auth-back">
                <a href="{{ route('home') }}" class="auth-nav-link" data-auth-nav><i class="las la-arrow-left"></i> {{ translate('Back to Home') }}</a>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="{{ static_asset('assets/js/auth-ui.js') }}?v=1.0.0"></script>
    @stack('scripts')
</body>
</html>
