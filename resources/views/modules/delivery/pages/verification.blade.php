@extends('modules.delivery.layouts.app')

@section('panel_content')
@php $address = json_decode($order->shipping_address); @endphp
<div class="dlv-page">
    <div class="dlv-page__head">
        <h1>{{ translate('Delivery Verification') }}</h1>
        <p>{{ translate('Order') }} #{{ $order->code }}</p>
    </div>

    <div class="dlv-dash-grid dlv-dash-grid--2">
        <div class="dlv-panel">
            <div class="dlv-panel__head"><h2>{{ translate('Order Details') }}</h2></div>
            <ul class="dlv-detail-list">
                <li><span>{{ translate('Customer') }}</span><strong>{{ $address->name ?? '—' }}</strong></li>
                <li><span>{{ translate('Phone') }}</span><strong>{{ $address->phone ?? '—' }}</strong></li>
                <li><span>{{ translate('Address') }}</span><strong>{{ $address->address ?? '' }}, {{ $address->city ?? '' }}</strong></li>
                <li><span>{{ translate('Amount') }}</span><strong>{{ single_price($order->grand_total) }}</strong></li>
                <li><span>{{ translate('Payment') }}</span><strong>{{ ucfirst(str_replace('_', ' ', $order->payment_type)) }}</strong></li>
            </ul>

            <div class="mt-4">
                @include('modules.delivery.components.status-timeline', ['order' => $order])
            </div>
        </div>

        <div class="dlv-panel">
            @include('modules.delivery.components.proof-upload', ['order' => $order, 'histories' => $histories])

            @if ($order->delivery_status !== 'delivered')
                <div class="mt-4 pt-3 border-top">
                    <button type="button" class="dlv-btn dlv-btn--primary w-100 dlv-status-btn"
                        data-order="{{ $order->id }}" data-status="delivered">
                        <i class="las la-check-double"></i> {{ translate('Mark as Delivered') }}
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    DLV.initStatusUpdate('{{ route('delivery-boy.orders.update_delivery_status') }}', '{{ csrf_token() }}');
    DLV.initProofPreview();
</script>
@endsection
