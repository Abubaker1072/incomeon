@extends('modules.business.layouts.app')

@section('biz_content')
<div class="biz-page">
    <h1>{{ translate('My Pre-Orders') }}</h1>
    @forelse($orders as $order)
        <div class="biz-panel mb-3">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <strong>#{{ $order->order_code ?? $order->id }}</strong>
                <a href="{{ route('preorder.order_details', $order->id) }}">{{ translate('Details') }}</a>
            </div>
            @include('modules.business.components.preorder-status-steps', ['order' => $order])
        </div>
    @empty
        <p class="biz-empty">{{ translate('No pre-orders yet') }}</p>
    @endforelse
    {{ $orders->links() }}
</div>
@endsection
