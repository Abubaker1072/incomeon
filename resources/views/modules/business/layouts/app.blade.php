@extends('modules.marketplace.layouts.app')

@section('content')
<div class="biz-wrap">
    @hasSection('biz_nav')
        @yield('biz_nav')
    @else
        @include('modules.business.layouts.partials.nav')
    @endif
    <div class="biz-content">
        @yield('biz_content')
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ static_asset('assets/modules/business/css/business.css') }}?v=1.0.0">
@endpush

@push('scripts')
<script src="{{ static_asset('assets/modules/business/js/business.js') }}?v=1.0.0"></script>
@endpush
