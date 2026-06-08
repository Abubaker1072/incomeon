@extends('modules.marketplace.layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ static_asset('assets/modules/account/css/account.css') }}?v=1.0.0">
@endpush

@section('content')
    @include('modules.account.layouts.partials.flash')
    <div class="mp-container acc-layout">
        @auth
            @if (in_array(Route::currentRouteName(), ['dashboard', 'profile', 'purchase_history.index', 'purchase_history.details', 'digital_purchase_history.index', 'wallet.index', 'support_ticket.index', 'support_ticket.show', 'conversations.index', 'conversations.show', 'wishlists.index']))
                @include('modules.account.layouts.partials.sidebar')
            @endif
        @endauth
        <div class="acc-content @yield('content_class')">
            @yield('account_content')
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ static_asset('assets/modules/account/js/account.js') }}?v=1.0.0"></script>
@endpush
