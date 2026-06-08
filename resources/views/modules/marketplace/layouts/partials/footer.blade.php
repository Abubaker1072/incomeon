@php
    $social_links = [
        'facebook' => get_setting('facebook_link'),
        'instagram' => get_setting('instagram_link'),
        'youtube' => get_setting('youtube_link'),
        'linkedin' => get_setting('linkedin_link'),
    ];
    $has_social = get_setting('show_social_links') == 'on' && collect($social_links)->filter()->isNotEmpty();
@endphp
@include('modules.marketplace.layouts.partials.policy-ribbon')

<footer class="mp-footer">
    <div class="mp-container">
        <div class="mp-footer__top">
            <div class="mp-footer__brand">
                <a href="{{ route('home') }}" class="mp-footer__logo">
                    @if (get_setting('footer_logo') || get_setting('header_logo'))
                        <img src="{{ uploaded_asset(get_setting('footer_logo') ?: get_setting('header_logo')) }}" alt="{{ get_setting('website_name') }}">
                    @else
                        <span class="mp-footer__logo-text">{{ get_setting('website_name') }}</span>
                    @endif
                </a>
                <p class="mp-footer__motto">{{ get_setting('site_motto') }}</p>
                <div class="mp-footer__newsletter">
                    <p>{{ translate('Subscribe to our newsletter for regular updates about Offers, Coupons & more') }}</p>
                    <form action="{{ route('subscribers.store') }}" method="POST" class="mp-footer__newsletter-form">
                        @csrf
                        <input type="email" name="email" placeholder="{{ translate('Your Email Address') }}" required>
                        <button type="submit" class="mp-btn mp-btn--primary">{{ translate('Subscribe') }}</button>
                    </form>
                </div>
            </div>
            @if ($has_social)
                <div class="mp-footer__social">
                    <h4>{{ translate('FOLLOW US') }}</h4>
                    <div class="mp-footer__social-icons">
                        @if ($social_links['facebook'])
                            <a href="{{ $social_links['facebook'] }}" target="_blank" rel="noopener" class="mp-footer__social-icon mp-footer__social-icon--fb" title="Facebook"><i class="lab la-facebook-f"></i></a>
                        @endif
                        @if ($social_links['instagram'])
                            <a href="{{ $social_links['instagram'] }}" target="_blank" rel="noopener" class="mp-footer__social-icon mp-footer__social-icon--ig" title="Instagram"><i class="lab la-instagram"></i></a>
                        @endif
                        @if ($social_links['youtube'])
                            <a href="{{ $social_links['youtube'] }}" target="_blank" rel="noopener" class="mp-footer__social-icon mp-footer__social-icon--yt" title="YouTube"><i class="lab la-youtube"></i></a>
                        @endif
                        @if ($social_links['linkedin'])
                            <a href="{{ $social_links['linkedin'] }}" target="_blank" rel="noopener" class="mp-footer__social-icon mp-footer__social-icon--li" title="LinkedIn"><i class="lab la-linkedin-in"></i></a>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <div class="mp-footer__columns">
            <div class="mp-footer__col">
                <h4>{{ translate('QUICK LINKS') }}</h4>
                <ul>
                    <li><a href="{{ route('supportpolicy') }}">{{ translate('Support Policy') }}</a></li>
                    <li><a href="{{ route('returnpolicy') }}">{{ translate('Return Policy') }}</a></li>
                    <li><a href="{{ url('/about-us') }}">{{ translate('About Us') }}</a></li>
                    <li><a href="{{ route('privacypolicy') }}">{{ translate('Privacy Policy') }}</a></li>
                    <li><a href="{{ route('sellerpolicy') }}">{{ translate('Seller Policy') }}</a></li>
                    <li><a href="{{ route('terms') }}">{{ translate('Terms & Conditions') }}</a></li>
                </ul>
            </div>
            <div class="mp-footer__col">
                <h4>{{ translate('CONTACTS') }}</h4>
                <ul>
                    @if (get_setting('helpline_number'))
                        <li><i class="las la-phone"></i> {{ translate('UAN') }}: {{ get_setting('helpline_number') }}</li>
                    @endif
                    @if (get_setting('contact_email'))
                        <li><i class="las la-envelope"></i> <a href="mailto:{{ get_setting('contact_email') }}">{{ get_setting('contact_email') }}</a></li>
                    @endif
                </ul>
            </div>
            <div class="mp-footer__col">
                <h4>{{ translate('MY ACCOUNT') }}</h4>
                <ul>
                    @auth
                        <li><a href="{{ route('dashboard') }}">{{ translate('My Account') }}</a></li>
                    @else
                        <li><a href="{{ route('user.login') }}">{{ translate('Login') }}</a></li>
                    @endauth
                    <li><a href="{{ route('purchase_history.index') }}">{{ translate('Order History') }}</a></li>
                    <li><a href="{{ route('wishlists.index') }}">{{ translate('My Wishlist') }}</a></li>
                    <li><a href="{{ route('orders.track') }}">{{ translate('Track Order') }}</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="mp-footer__bar">
        <div class="mp-container">
            @php
                $site_label = get_setting('website_name');
                if (filter_var($site_label, FILTER_VALIDATE_URL)) {
                    $site_label = config('app.name', 'Get Technologies');
                }
            @endphp
            <p>{{ translate('All rights reserved.') }} {{ translate('Copyright') }} &copy; {{ date('Y') }}-{{ date('y', strtotime('+1 year')) }} {{ $site_label }}.</p>
        </div>
    </div>
</footer>

<div class="mp-side-fab" aria-label="{{ translate('Quick actions') }}">
    <button type="button" class="mp-side-fab__btn" id="mp-side-menu" title="{{ translate('Menu') }}"><i class="las la-bars"></i></button>
    <a href="{{ route('flash-deals') }}" class="mp-side-fab__btn" title="{{ translate('Flash Sale') }}"><i class="las la-bolt"></i></a>
    <a href="{{ route('orders.track') }}" class="mp-side-fab__btn" title="{{ translate('Track Order') }}"><i class="las la-clock"></i></a>
</div>

@if (get_setting('whatsapp_link'))
    <a href="{{ get_setting('whatsapp_link') }}" class="mp-whatsapp-fab" target="_blank" rel="noopener" title="WhatsApp">
        <i class="lab la-whatsapp"></i>
    </a>
@endif
