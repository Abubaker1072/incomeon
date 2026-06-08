@extends('modules.delivery.layouts.app')

@section('panel_content')
<div class="dlv-page">
    <div class="dlv-page__head">
        <h1>{{ translate('Delivery History') }}</h1>
        <p>{{ translate('Complete log of your delivery status changes') }}</p>
    </div>

    <div class="dlv-table-wrap">
        <table class="dlv-table">
            <thead>
                <tr>
                    <th>{{ translate('Order') }}</th>
                    <th>{{ translate('Status') }}</th>
                    <th>{{ translate('Payment') }}</th>
                    <th>{{ translate('Collection') }}</th>
                    <th>{{ translate('Earning') }}</th>
                    <th>{{ translate('Date') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($histories as $history)
                    <tr>
                        <td>
                            <a href="{{ route('delivery-boy.order-detail', $history->order_id) }}">
                                #{{ optional($history->order)->code ?? $history->order_id }}
                            </a>
                        </td>
                        <td>
                            <span class="dlv-badge dlv-badge--{{ delivery_status_badge_class($history->delivery_status) }}">
                                {{ delivery_status_label($history->delivery_status) }}
                            </span>
                        </td>
                        <td>{{ ucfirst(str_replace('_', ' ', $history->payment_type)) }}</td>
                        <td>{{ $history->collection ? single_price($history->collection) : '—' }}</td>
                        <td>{{ $history->earning ? single_price($history->earning) : '—' }}</td>
                        <td>{{ $history->created_at->format('M d, Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">{{ translate('No delivery history yet') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $histories->links() }}
    </div>
</div>
@endsection
