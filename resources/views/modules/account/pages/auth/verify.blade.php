@extends('modules.account.layouts.auth')

@section('auth_content')
    <h1>{{ translate('Verify Your Email') }}</h1>
    <p class="acc-auth__sub">{{ translate('Please verify your email address before continuing.') }}</p>

    @if (session('resent'))
        <div class="acc-flash acc-flash--success">{{ translate('A fresh verification link has been sent to your email.') }}</div>
    @endif

    <p style="font-size:0.9rem;color:var(--mp-muted);margin-bottom:1.25rem;">
        {{ translate('Before proceeding, please check your email for a verification link.') }}
    </p>

    <form method="POST" action="{{ route('verification.resend') }}">
        @csrf
        <button type="submit" class="mp-btn mp-btn--outline" style="width:100%;justify-content:center;">{{ translate('Resend Verification Email') }}</button>
    </form>
@endsection
