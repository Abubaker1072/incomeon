@php $user = auth()->user(); @endphp
<aside class="acc-sidebar">
    <div class="acc-sidebar__user">
        <strong>{{ $user->name }}</strong>
        <span>{{ $user->email ?? $user->phone }}</span>
    </div>
    <nav class="acc-nav">
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'is-active' : '' }}">
            <i class="las la-tachometer-alt"></i> {{ translate('Dashboard') }}
        </a>
        <a href="{{ route('purchase_history.index') }}" class="{{ request()->routeIs('purchase_history.*', 'digital_purchase_history.*') ? 'is-active' : '' }}">
            <i class="las la-shopping-bag"></i> {{ translate('Orders') }}
        </a>
        <a href="{{ route('orders.track') }}" class="{{ request()->routeIs('orders.track') ? 'is-active' : '' }}">
            <i class="las la-shipping-fast"></i> {{ translate('Track Order') }}
        </a>
        <a href="{{ route('wishlists.index') }}" class="{{ request()->routeIs('wishlists.*') ? 'is-active' : '' }}">
            <i class="las la-heart"></i> {{ translate('Wishlist') }}
        </a>
        @if (get_setting('wallet_system') == 1)
            <a href="{{ route('wallet.index') }}" class="{{ request()->routeIs('wallet.*') ? 'is-active' : '' }}">
                <i class="las la-wallet"></i> {{ translate('Wallet') }}
            </a>
        @endif
        <a href="{{ route('profile') }}" class="{{ request()->routeIs('profile') ? 'is-active' : '' }}">
            <i class="las la-user"></i> {{ translate('Profile') }}
        </a>
        <a href="{{ route('conversations.index') }}" class="{{ request()->routeIs('conversations.*') ? 'is-active' : '' }}">
            <i class="las la-comments"></i> {{ translate('Chat With Sellers') }}
        </a>
        <a href="{{ route('support_ticket.index') }}" class="{{ request()->routeIs('support_ticket.*') ? 'is-active' : '' }}">
            <i class="las la-headset"></i> {{ translate('Support Tickets') }}
        </a>
        @if (addon_is_activated('affiliate_system'))
            <a href="{{ route('affiliate.user.index') }}" class="{{ request()->routeIs('affiliate.user.*') ? 'is-active' : '' }}">
                <i class="las la-link"></i> {{ translate('Affiliate') }}
            </a>
        @endif
        <a href="{{ route('logout') }}">
            <i class="las la-sign-out-alt"></i> {{ translate('Logout') }}
        </a>
    </nav>
</aside>
