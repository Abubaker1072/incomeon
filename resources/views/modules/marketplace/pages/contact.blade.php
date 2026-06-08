@php
    $details = json_decode($page->getTranslation('content'), true) ?? [];
@endphp
@extends('modules.marketplace.layouts.app')

@section('meta_title', translate('Contact Us') . ' | ' . get_setting('website_name'))

@section('content')
<section class="mp-section mp-section--white">
    <div class="mp-container mp-contact-page">
        <h1 class="mp-policy-page__title">{{ $page->getTranslation('title') }}</h1>
        @if (!empty($details['description']))
            <p class="mp-contact-page__intro">{{ $details['description'] }}</p>
        @endif
        <div class="mp-contact-page__grid">
            <div class="mp-contact-page__info">
                @if (!empty($details['phone']) || get_setting('helpline_number'))
                    <div class="mp-contact-page__item">
                        <i class="las la-phone" aria-hidden="true"></i>
                        <div>
                            <strong>{{ translate('Phone') }}</strong>
                            <p>{{ $details['phone'] ?? get_setting('helpline_number') }}</p>
                        </div>
                    </div>
                @endif
                @if (!empty($details['email']) || get_setting('contact_email'))
                    <div class="mp-contact-page__item">
                        <i class="las la-envelope" aria-hidden="true"></i>
                        <div>
                            <strong>{{ translate('Email') }}</strong>
                            <p><a href="mailto:{{ $details['email'] ?? get_setting('contact_email') }}">{{ $details['email'] ?? get_setting('contact_email') }}</a></p>
                        </div>
                    </div>
                @endif
                @if (!empty($details['address']))
                    <div class="mp-contact-page__item">
                        <i class="las la-map-marker" aria-hidden="true"></i>
                        <div>
                            <strong>{{ translate('Address') }}</strong>
                            <p>{{ $details['address'] }}</p>
                        </div>
                    </div>
                @endif
            </div>
            <form action="{{ route('contact') }}" method="POST" class="mp-contact-page__form">
                @csrf
                <input type="hidden" name="form_timestamp" value="{{ time() }}">
                <input type="text" name="website_url" value="" tabindex="-1" autocomplete="off" style="position:absolute;left:-9999px;" aria-hidden="true">
                <div class="mp-contact-page__field">
                    <label for="mp-contact-name">{{ translate('Name') }}</label>
                    <input type="text" id="mp-contact-name" name="name" value="{{ old('name') }}" required>
                </div>
                <div class="mp-contact-page__field">
                    <label for="mp-contact-email">{{ translate('Email') }}</label>
                    <input type="email" id="mp-contact-email" name="email" value="{{ old('email') }}" required>
                </div>
                <div class="mp-contact-page__field">
                    <label for="mp-contact-phone">{{ translate('Phone') }}</label>
                    <input type="text" id="mp-contact-phone" name="phone" value="{{ old('phone') }}">
                </div>
                <div class="mp-contact-page__field">
                    <label for="mp-contact-message">{{ translate('Message') }}</label>
                    <textarea id="mp-contact-message" name="content" rows="5" required>{{ old('content') }}</textarea>
                </div>
                @if (get_setting('google_recaptcha') == 1)
                    <div class="mp-contact-page__field">
                        <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
                    </div>
                    @push('scripts')
                        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
                    @endpush
                @endif
                <button type="submit" class="mp-btn mp-btn--primary">{{ translate('Send Message') }}</button>
            </form>
        </div>
    </div>
</section>
@endsection
