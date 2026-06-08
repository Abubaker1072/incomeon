<!DOCTYPE html>
@php $rtl = get_session_language()->rtl ?? 0; @endphp
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" @if($rtl) dir="rtl" @endif>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="app-url" content="{{ getBaseURL() }}">
    <title>@yield('meta_title', get_setting('website_name') . ' | ' . get_setting('site_motto'))</title>
    <meta name="description" content="@yield('meta_description', get_setting('meta_description'))">
    @yield('meta')
    <link rel="icon" href="{{ uploaded_asset(get_setting('site_icon')) }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="{{ static_asset('assets/modules/marketplace/css/marketplace.css') }}?v=2.3.0">
    <link rel="stylesheet" href="{{ static_asset('assets/css/responsive-global.css') }}?v=1.0.0">
    <style>:root {
        --mp-primary: {{ get_setting('base_color', '#2557aa') }};
        --mp-primary-dark: color-mix(in srgb, {{ get_setting('base_color', '#2557aa') }} 82%, #000);
        --mp-accent: #00b4d8;
        --mp-accent-glow: rgba(0, 180, 216, 0.35);
    }</style>
    @stack('styles')
</head>
<body class="mp-body">
    @include('modules.marketplace.layouts.partials.header')

    <main>
        @yield('content')
    </main>

    @include('modules.marketplace.layouts.partials.footer')

    <script src="{{ static_asset('assets/modules/marketplace/js/marketplace.js') }}?v=2.2.0"></script>
    @stack('scripts')
    @if(Route::currentRouteName() == 'home')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const token = document.querySelector('meta[name="csrf-token"]').content;
            const sections = [
                { url: '{{ route('home.section.todays_deal') }}', el: '#mp-todays-deal' },
                { url: '{{ route('home.section.featured') }}', el: '#mp-featured' },
                { url: '{{ route('home.section.best_selling') }}', el: '#mp-best-selling' },
                { url: '{{ route('home.section.newest_products') }}', el: '#mp-new-arrivals' },
                { url: '{{ route('home.section.best_sellers') }}', el: '#mp-popular-stores' },
            ];
            sections.forEach(function (s) {
                const target = document.querySelector(s.el);
                if (!target) return;
                fetch(s.url, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': token, 'Accept': 'text/html' },
                }).then(r => r.text()).then(html => { target.innerHTML = html; }).catch(() => {});
            });
        });
    </script>
    @endif
</body>
</html>
