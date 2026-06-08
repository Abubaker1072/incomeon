@php
    $user = auth()->user();
    $cart_count = count(get_user_cart());
    $nav_categories = \App\Models\Category::with(['catIcon'])
        ->where('level', 0)->orderBy('order_level', 'desc')->take(20)->get();
    $menu_labels = get_setting('header_menu_labels') ? json_decode(get_setting('header_menu_labels'), true) : [];
    $menu_links = get_setting('header_menu_links') ? json_decode(get_setting('header_menu_links'), true) : [];
@endphp

<div class="mp-promo">
    <div class="mp-container">
        {{ translate('Free shipping on orders over') }} $50
        <a href="{{ route('search') }}">{{ translate('Shop now') }} &rarr;</a>
        @if (get_setting('helpline_number'))
            &nbsp;|&nbsp; {{ translate('Call') }}: <strong>{{ get_setting('helpline_number') }}</strong>
        @endif
    </div>
</div>

<header class="mp-header">
    <div class="mp-container mp-header__inner">
        <button type="button" class="mp-mobile-toggle" id="mp-mobile-toggle" aria-expanded="false" aria-controls="mp-main-nav" aria-label="{{ translate('Menu') }}">
            <i class="las la-bars"></i>
        </button>
        <a href="{{ route('home') }}" class="mp-logo">
            @if (get_setting('header_logo'))
                <img src="{{ uploaded_asset(get_setting('header_logo')) }}" alt="{{ get_setting('website_name') }}">
            @else
                <strong>{{ get_setting('website_name') }}</strong>
            @endif
        </a>
        <div class="mp-search">
            @include('modules.marketplace.components.search-bar')
        </div>
        <div class="mp-header__actions">
            @auth
                <a href="{{ route('dashboard') }}" class="mp-btn mp-btn--outline"><i class="las la-user"></i> <span>{{ $user->name }}</span></a>
            @else
                <a href="{{ route('user.login') }}" class="mp-btn mp-btn--dark"><i class="las la-user"></i> <span>{{ translate('Sign In') }}</span></a>
            @endauth
            <a href="{{ route('wishlists.index') }}" class="mp-btn mp-btn--outline" title="{{ translate('Wishlist') }}">
                <i class="las la-heart"></i>
                <span id="mp-wishlist-count">@auth{{ get_user_wishlist()->count() }}@else 0 @endauth</span>
            </a>
            <a href="{{ route('cart') }}" class="mp-btn mp-btn--primary" title="{{ translate('Cart') }}">
                <i class="las la-shopping-cart"></i> <span>{{ $cart_count }}</span>
            </a>
        </div>
    </div>
    <nav class="mp-nav mp-nav--primary" id="mp-main-nav">
        <div class="mp-container mp-nav__inner">
            <div class="mp-nav-categories" id="mp-nav-categories">
                <button type="button" class="mp-nav-categories__trigger" aria-expanded="false" aria-controls="mp-nav-categories-panel">
                    <span class="mp-nav-categories__label">{{ translate('Categories') }}</span>
                    <span class="mp-nav-categories__see-all">({{ translate('See All') }})</span>
                    <i class="las la-angle-down mp-nav-categories__chevron" aria-hidden="true"></i>
                </button>
                <div class="mp-nav-categories__panel" id="mp-nav-categories-panel">
                    @include('modules.marketplace.components.category-sidebar-nav', ['nav_categories' => $nav_categories])
                </div>
            </div>
            <div class="mp-nav__links" id="mp-nav-links">
                @if (!empty($menu_labels))
                    @foreach ($menu_labels as $key => $label)
                        <a href="{{ $menu_links[$key] ?? '#' }}" class="mp-nav-link mp-nav-link--menu">{{ translate($label) }}</a>
                    @endforeach
                @else
                    <a href="{{ route('home') }}" class="mp-nav-link mp-nav-link--menu">{{ translate('Home') }}</a>
                    <a href="{{ route('flash-deals') }}" class="mp-nav-link mp-nav-link--menu">{{ translate('Flash Sale') }}</a>
                    <a href="{{ route('brands.all') }}" class="mp-nav-link mp-nav-link--menu">{{ translate('Brand') }}</a>
                    <a href="{{ route('supportpolicy') }}" class="mp-nav-link mp-nav-link--menu">{{ translate('Service & Support') }}</a>
                    <a href="{{ url('/contact-us') }}" class="mp-nav-link mp-nav-link--menu">{{ translate('Contact US') }}</a>
                @endif
            </div>
        </div>
    </nav>
</header>
<div class="mp-nav-overlay" id="mp-nav-overlay" aria-hidden="true"></div>
