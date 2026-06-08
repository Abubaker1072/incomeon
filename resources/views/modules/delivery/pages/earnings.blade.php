@extends('modules.delivery.layouts.app')

@section('panel_content')
<div class="dlv-page">
    <div class="dlv-page__head">
        <h1>{{ translate('Earnings') }}</h1>
        <p>{{ translate('Total') }}: <strong>{{ single_price($total_earning) }}</strong></p>
    </div>

    <div class="dlv-table-wrap">
        <table class="dlv-table">
            <thead>
                <tr>
                    <th>{{ translate('Order') }}</th>
                    <th>{{ translate('Earning') }}</th>
                    <th>{{ translate('Date') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($earnings as $item)
                    <tr>
                        <td>#{{ optional($item->order)->code ?? $item->order_id }}</td>
                        <td>{{ single_price($item->earning) }}</td>
                        <td>{{ $item->created_at->format('M d, Y') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="text-center py-4">{{ translate('No earnings yet') }}</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $earnings->links() }}
    </div>
</div>
@endsection
