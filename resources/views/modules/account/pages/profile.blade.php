@extends('modules.account.layouts.app')

@section('account_content')
    <div class="acc-page-head">
        <h1>{{ translate('My Profile') }}</h1>
    </div>

    <div class="acc-card">
        <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="acc-field">
                <label>{{ translate('Name') }}</label>
                <input type="text" name="name" value="{{ auth()->user()->name }}" required>
            </div>
            <div class="acc-field">
                <label>{{ translate('Email') }}</label>
                <input type="email" name="email" value="{{ auth()->user()->email }}" required>
            </div>
            <div class="acc-field">
                <label>{{ translate('Phone') }}</label>
                <input type="text" name="phone" value="{{ auth()->user()->phone }}">
            </div>
            <div class="acc-field">
                <label>{{ translate('New Password') }} <small style="font-weight:400;color:var(--mp-muted);">({{ translate('leave blank to keep current') }})</small></label>
                <input type="password" name="new_password">
            </div>
            <div class="acc-field">
                <label>{{ translate('Confirm Password') }}</label>
                <input type="password" name="confirm_password">
            </div>
            <button type="submit" class="mp-btn mp-btn--primary">{{ translate('Update Profile') }}</button>
        </form>
    </div>

    @auth
        <div class="acc-card">
            <div class="acc-page-head" style="margin-bottom:1rem;">
                <h3 style="margin:0;font-size:1.1rem;">{{ translate('My Addresses') }}</h3>
                <button type="button" class="mp-btn mp-btn--outline" id="acc-add-address-btn">
                    <i class="las la-plus"></i> {{ translate('Add Address') }}
                </button>
            </div>
            <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:1rem;">
                @foreach (auth()->user()->addresses as $address)
                    <div class="acc-address-card {{ $address->set_default ? 'is-selected' : '' }}">
                        @if ($address->set_default)
                            <span class="acc-badge acc-badge--info" style="margin-bottom:0.5rem;">{{ translate('Default') }}</span>
                        @endif
                        <p style="margin:0;font-weight:600;">{{ $address->address }}</p>
                        <p style="margin:0.35rem 0 0;font-size:0.85rem;color:var(--mp-muted);">
                            {{ $address->city?->getTranslation('name') }}, {{ $address->state?->name }}<br>
                            {{ $address->phone }}
                        </p>
                        <div style="margin-top:0.75rem;display:flex;gap:0.5rem;">
                            @if (!$address->set_default)
                                <a href="{{ route('addresses.set_default', $id = $address->id) }}" class="mp-btn mp-btn--outline" style="padding:0.3rem 0.6rem;font-size:0.75rem;">{{ translate('Set Default') }}</a>
                            @endif
                            <button type="button" class="mp-btn mp-btn--outline acc-edit-address" data-id="{{ $address->id }}" style="padding:0.3rem 0.6rem;font-size:0.75rem;">{{ translate('Edit') }}</button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @include('modules.account.partials.address.address-modal')
        @include('modules.account.partials.address.address-edit-modal')
    @endauth
@endsection
