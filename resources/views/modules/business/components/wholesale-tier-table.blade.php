@php $tiers = \App\Services\BusinessService::wholesaleTiers($product); @endphp
@if($tiers->count())
<div class="biz-tier-table">
    <h4>{{ translate('Wholesale Tier Pricing') }}</h4>
    <table>
        <thead>
            <tr>
                <th>{{ translate('Min Qty') }}</th>
                <th>{{ translate('Max Qty') }}</th>
                <th>{{ translate('Unit Price') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tiers as $tier)
                <tr>
                    <td>{{ $tier->min_qty }}</td>
                    <td>{{ $tier->max_qty ?: '∞' }}</td>
                    <td>{{ single_price($tier->price) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <p class="biz-tier-table__note">{{ translate('Bulk purchase rules apply automatically at checkout based on quantity.') }}</p>
</div>
@endif
