@extends('modules.delivery.layouts.app')

@section('panel_content')
<div class="dlv-page">
    <div class="dlv-page__head">
        <h1>{{ $page_title }}</h1>
        <p>{{ translate('Manage and update your delivery assignments') }}</p>
    </div>

    <div class="dlv-card-grid">
        @forelse ($orders as $order)
            @include('modules.delivery.components.delivery-card', ['order' => $order])
        @empty
            <div class="dlv-empty-state">
                <i class="las la-inbox"></i>
                <p>{{ translate('No deliveries found for this status') }}</p>
            </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $orders->links() }}
    </div>
</div>
@endsection

@section('script')
<script>
    DLV.initStatusUpdate('{{ route('delivery-boy.orders.update_delivery_status') }}', '{{ csrf_token() }}');
</script>
@endsection
