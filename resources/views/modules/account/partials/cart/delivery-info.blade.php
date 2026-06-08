@php
    $grouped = $carts->where('status', 1)->groupBy('owner_id');
@endphp
@foreach ($grouped as $owner_id => $seller_carts)
    @php
        $shop = \App\Models\User::find($owner_id)?->shop;
        $first = $seller_carts->first();
    @endphp
    <div class="acc-card" style="margin-bottom:1rem;">
        <p style="margin:0 0 0.75rem;font-weight:600;">{{ $shop?->name ?? translate('Inhouse Products') }}</p>
        @if (get_setting('shipping_type') == 'carrier_wise_shipping' && !empty($carrier_list) && count($carrier_list) > 0)
            <p style="font-size:0.85rem;color:var(--mp-muted);margin:0 0 0.5rem;">{{ translate('Select carrier') }}</p>
            @foreach ($carrier_list as $carrier)
                <label class="acc-payment-option">
                    <input type="radio" name="shipping_{{ $owner_id }}" value="carrier_{{ $carrier->id }}"
                        data-user-id="{{ $owner_id }}" data-type="carrier" data-type-id="{{ $carrier->id }}"
                        class="acc-shipping-radio" {{ $first->carrier_id == $carrier->id ? 'checked' : '' }}>
                    <span>{{ $carrier->name }} — {{ single_price(getShippingCost($carts, 0, $shipping_info ?? [], $carrier->id)) }}</span>
                </label>
            @endforeach
        @else
            <label class="acc-payment-option">
                <input type="radio" name="shipping_{{ $owner_id }}" value="home_delivery"
                    data-user-id="{{ $owner_id }}" data-type="home_delivery" data-type-id="0"
                    class="acc-shipping-radio" checked>
                <span>{{ translate('Home Delivery') }}</span>
            </label>
        @endif
    </div>
@endforeach
