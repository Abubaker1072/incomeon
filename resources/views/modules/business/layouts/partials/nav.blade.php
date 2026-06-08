<nav class="biz-nav">
    <a href="{{ route('business.hub') }}" class="biz-nav__brand">{{ translate('Business Modules') }}</a>
    <div class="biz-nav__links">
        @if(addon_is_activated('auction'))
            <a href="{{ route('auction_products.all') }}">{{ translate('Auctions') }}</a>
        @endif
        @if(addon_is_activated('wholesale'))
            <a href="{{ route('business.wholesale') }}">{{ translate('Wholesale') }}</a>
        @endif
        @if(addon_is_activated('preorder'))
            <a href="{{ route('all_preorder_products') }}">{{ translate('Pre-Order') }}</a>
        @endif
        @auth
            @if(addon_is_activated('club_point'))
                <a href="{{ route('earnng_point_for_user') }}">{{ translate('Loyalty') }}</a>
            @endif
            @if(addon_is_activated('affiliate_system'))
                <a href="{{ route('affiliate.user.index') }}">{{ translate('Affiliate') }}</a>
            @endif
        @endauth
    </div>
</nav>
