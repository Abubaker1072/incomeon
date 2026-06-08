<div class="aiz-sidebar-wrap">
    <div class="aiz-sidebar left c-scrollbar">
        <div class="aiz-side-nav-logo-wrap">
            <div class="d-block text-center my-3">
                <div class="dlv-avatar mx-auto mb-2">
                    <i class="las la-shipping-fast"></i>
                </div>
                <h3 class="fs-16 m-0 text-primary">{{ Auth::user()->name }}</h3>
                <p class="text-primary mb-0">{{ translate('Delivery Partner') }}</p>
            </div>
        </div>
        <div class="aiz-side-nav-wrap">
            <div class="px-20px mb-3">
                <input class="form-control bg-soft-secondary border-0 form-control-sm" type="text"
                    placeholder="{{ translate('Search in menu') }}" id="menu-search" onkeyup="menuSearch()">
            </div>
            <ul class="aiz-side-nav-list" id="search-menu"></ul>
            <ul class="aiz-side-nav-list" id="main-menu">
                <li class="aiz-side-nav-item">
                    <a href="{{ route('dashboard') }}" class="aiz-side-nav-link">
                        <i class="las la-home aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">{{ translate('Delivery Dashboard') }}</span>
                    </a>
                </li>
                <li class="aiz-side-nav-item">
                    <a href="{{ route('assigned-deliveries') }}" class="aiz-side-nav-link">
                        <i class="las la-clipboard-list aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">{{ translate('Assigned Deliveries') }}</span>
                    </a>
                </li>
                <li class="aiz-side-nav-item">
                    <a href="{{ route('delivery.route-info') }}" class="aiz-side-nav-link">
                        <i class="las la-route aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">{{ translate('Route Information') }}</span>
                    </a>
                </li>
                <li class="aiz-side-nav-item">
                    <a href="#" class="aiz-side-nav-link">
                        <i class="las la-truck aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">{{ translate('Delivery Status') }}</span>
                        <span class="aiz-side-nav-arrow"></span>
                    </a>
                    <ul class="aiz-side-nav-list level-2">
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('pickup-deliveries') }}" class="aiz-side-nav-link">
                                <span class="aiz-side-nav-text">{{ translate('Picked Up') }}</span>
                            </a>
                        </li>
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('on-the-way-deliveries') }}" class="aiz-side-nav-link">
                                <span class="aiz-side-nav-text">{{ translate('Out For Delivery') }}</span>
                            </a>
                        </li>
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('completed-deliveries') }}" class="aiz-side-nav-link">
                                <span class="aiz-side-nav-text">{{ translate('Delivered') }}</span>
                            </a>
                        </li>
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('cancelled-deliveries') }}" class="aiz-side-nav-link">
                                <span class="aiz-side-nav-text">{{ translate('Failed') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="aiz-side-nav-item">
                    <a href="{{ route('delivery.cod-collection') }}" class="aiz-side-nav-link">
                        <i class="las la-money-bill-wave aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">{{ translate('COD Collection') }}</span>
                    </a>
                </li>
                <li class="aiz-side-nav-item">
                    <a href="{{ route('delivery.history') }}" class="aiz-side-nav-link">
                        <i class="las la-history aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">{{ translate('Delivery History') }}</span>
                    </a>
                </li>
                <li class="aiz-side-nav-item">
                    <a href="{{ route('total-earnings') }}" class="aiz-side-nav-link">
                        <i class="las la-wallet aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">{{ translate('Earnings') }}</span>
                    </a>
                </li>
                <li class="aiz-side-nav-item">
                    <a href="{{ route('profile') }}" class="aiz-side-nav-link">
                        <i class="las la-user aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">{{ translate('Profile') }}</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
