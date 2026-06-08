<div class="acc-table-wrap">
    <table class="acc-table">
        <thead>
            <tr>
                <th>{{ translate('Order') }}</th>
                <th>{{ translate('Date') }}</th>
                <th>{{ translate('Amount') }}</th>
                <th>{{ translate('Delivery') }}</th>
                <th>{{ translate('Payment') }}</th>
                @empty($compact)
                    <th></th>
                @endempty
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td><strong>#{{ $order->code }}</strong></td>
                    <td>{{ date('M d, Y', $order->date) }}</td>
                    <td>{{ single_price($order->grand_total) }}</td>
                    <td>
                        @php
                            $dClass = match($order->delivery_status) {
                                'delivered' => 'success',
                                'cancelled' => 'danger',
                                'pending' => 'warning',
                                default => 'info',
                            };
                        @endphp
                        <span class="acc-badge acc-badge--{{ $dClass }}">{{ translate(ucfirst(str_replace('_', ' ', $order->delivery_status))) }}</span>
                    </td>
                    <td>
                        <span class="acc-badge acc-badge--{{ $order->payment_status === 'paid' ? 'success' : 'warning' }}">{{ translate(ucfirst($order->payment_status)) }}</span>
                    </td>
                    @empty($compact)
                        <td>
                            <a href="{{ route('purchase_history.details', encrypt($order->id)) }}" class="mp-btn mp-btn--outline" style="padding:0.35rem 0.75rem;font-size:0.8rem;">{{ translate('Details') }}</a>
                        </td>
                    @endempty
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
