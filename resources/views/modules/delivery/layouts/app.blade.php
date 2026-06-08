<!doctype html>
@if(\App\Models\Language::where('code', Session::get('locale', Config::get('app.locale')))->first()->rtl == 1)
<html dir="rtl" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@else
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@endif
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="app-url" content="{{ getBaseURL() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="{{ uploaded_asset(get_setting('site_icon')) }}">
    <title>{{ translate('Delivery') }} | {{ get_setting('site_name') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    @if(\App\Models\Language::where('code', Session::get('locale', Config::get('app.locale')))->first()->rtl == 1)
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-v4-rtl@4.6.2-1/dist/css/bootstrap-rtl.min.css">
    @endif
    <link rel="stylesheet" href="{{ static_asset('assets/modules/delivery/css/delivery.css') }}?v=1.0.0">
    <link rel="stylesheet" href="{{ static_asset('assets/css/responsive-global.css') }}?v=1.0.0">
    @stack('styles')
</head>
<body class="dlv-module">

    <div class="aiz-main-wrapper">
        @include('modules.delivery.layouts.partials.sidenav')
        <div class="aiz-content-wrapper">
            @include('modules.delivery.layouts.partials.nav')
            <div class="aiz-main-content">
                <div class="px-15px px-lg-25px">
                    @yield('panel_content')
                </div>
                <div class="dlv-footer text-center py-3 px-15px px-lg-25px mt-auto border-top">
                    <p class="mb-0 text-secondary">&copy; {{ get_setting('site_name') }} &middot; {{ translate('Delivery Management') }}</p>
                </div>
            </div>
        </div>
    </div>

    @yield('modal')

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ static_asset('assets/modules/delivery/js/delivery.js') }}?v=1.0.0"></script>
    @yield('script')
    @stack('scripts')

    <script>
        @foreach (session('flash_notification', collect())->toArray() as $message)
            if (typeof DLV !== 'undefined') {
                DLV.notify('{{ $message['level'] }}', '{{ $message['message'] }}');
            }
        @endforeach
    </script>
    <script src="{{ static_asset('assets/js/panel-mobile.js') }}?v=1.0.0"></script>
</body>
</html>
