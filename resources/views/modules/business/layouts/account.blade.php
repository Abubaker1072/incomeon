{{-- Extend modules.account.layouts.app and use @section('account_content') in child views. --}}
@push('styles')
<link rel="stylesheet" href="{{ static_asset('assets/modules/business/css/business.css') }}?v=1.0.0">
@endpush
