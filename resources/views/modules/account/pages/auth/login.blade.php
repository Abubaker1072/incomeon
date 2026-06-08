@extends('modules.account.layouts.auth')

@section('auth_title', translate('Sign In'))

@section('auth_content')
    <h1 class="auth-card__title" style="text-transform:uppercase;">{{ translate('Welcome to') }} {{ get_setting('site_name') }}</h1>
    <p class="auth-card__sub">{{ translate('Login to your account.') }}</p>

    <form method="POST" action="{{ route('login') }}" data-auth-form>
        @csrf
        <div class="form-group">
            <label for="email" class="fs-12 fw-700 text-muted">{{ translate('Email') }}</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="{{ translate('johndoe@example.com') }}" required autofocus>
        </div>
        <div class="form-group">
            <label for="password" class="fs-12 fw-700 text-muted">{{ translate('Password') }}</label>
            <div class="position-relative">
                <input type="password" class="form-control" id="password" name="password" placeholder="{{ translate('Password') }}" required>
                <i class="password-toggle las la-eye"></i>
            </div>
        </div>
        <div class="acc-field" style="display:flex;align-items:center;justify-content:space-between;gap:0.5rem;">
            <label style="display:flex;align-items:center;gap:0.4rem;font-weight:400;margin:0;">
                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                {{ translate('Remember Me') }}
            </label>
            <a href="{{ route('password.request') }}" class="auth-link" data-auth-nav>{{ translate('Forgot Password?') }}</a>
        </div>
        <button type="submit" class="auth-btn auth-btn--primary auth-btn--block">
            <i class="las la-sign-in-alt"></i> {{ translate('Login') }}
        </button>
    </form>

    <div class="auth-actions">
        <p class="auth-actions__label">{{ translate('Dont have an account?') }}</p>
        <div class="auth-actions__buttons auth-actions__buttons--single">
            <a href="{{ route('user.registration') }}" class="auth-btn auth-btn--outline" data-auth-nav>
                <i class="las la-user-plus"></i> {{ translate('Register') }}
            </a>
        </div>
    </div>
@endsection
