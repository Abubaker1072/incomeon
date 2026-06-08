<div class="aiz-topbar px-15px px-lg-25px d-flex align-items-stretch justify-content-between">
    <div class="d-flex">
        <div class="aiz-topbar-nav-toggler d-flex align-items-center justify-content-start mr-2 mr-md-3 ml-0" data-toggle="aiz-mobile-nav">
            <button class="aiz-mobile-toggler" type="button" aria-label="{{ translate('Toggle menu') }}">
                <span></span>
            </button>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-stretch flex-grow-xl-1">
        <div class="d-flex align-items-center">
            <a class="btn btn-icon btn-circle btn-light" href="{{ route('home') }}" target="_blank" title="{{ translate('Browse Website') }}">
                <i class="las la-globe"></i>
            </a>
        </div>
        <div class="d-flex align-items-center">
            <div class="dropdown">
                <a class="btn btn-light dropdown-toggle" href="#" data-toggle="dropdown">
                    <i class="las la-user-circle"></i> {{ Auth::user()->name }}
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="{{ route('profile') }}">{{ translate('Profile') }}</a>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('dlv-logout').submit();">
                        {{ translate('Logout') }}
                    </a>
                    <form id="dlv-logout" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                </div>
            </div>
        </div>
    </div>
</div>
