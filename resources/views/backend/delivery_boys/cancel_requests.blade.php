@extends('backend.layouts.app')

@section('content')
<div class="aiz-titlebar text-left mt-2 mb-3">
    <h1 class="h3">{{ translate('Cancel Requests') }}</h1>
</div>
<div class="card">
    <div class="card-body">
        <table class="table aiz-table mb-0">
            <thead>
                <tr>
                    <th>{{ translate('Order') }}</th>
                    <th>{{ translate('Delivery Boy') }}</th>
                    <th>{{ translate('Status') }}</th>
                    <th>{{ translate('Requested At') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    <tr>
                        <td><a href="{{ route('orders.show', $order->id) }}">#{{ $order->code }}</a></td>
                        <td>{{ optional($order->delivery_boy)->name }}</td>
                        <td>{{ delivery_status_label($order->delivery_status) }}</td>
                        <td>{{ $order->cancel_request_at }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center">{{ translate('No cancel requests') }}</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="aiz-pagination">{{ $orders->links() }}</div>
    </div>
</div>
@endsection
