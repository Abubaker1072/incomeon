@extends('modules.account.layouts.auth')

@section('auth_content')
    <h1>{{ translate('Reset Password') }}</h1>
    <p class="acc-auth__sub">{{ translate('Enter your email to receive a password reset link.') }}</p>

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="acc-field">
            <label for="email">{{ translate('Email') }}</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
        </div>
        <button type="submit" class="mp-btn mp-btn--primary" style="width:100%;justify-content:center;">{{ translate('Send Reset Link') }}</button>
    </form>

    <p style="margin:1.25rem 0 0;text-align:center;font-size:0.875rem;">
        <a href="{{ route('user.login') }}" style="color:var(--mp-primary);font-weight:600;">&larr; {{ translate('Back to Login') }}</a>
    </p>
@endsection
