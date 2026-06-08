@php
    $proceed = $proceed ?? 0;
    $carts = $carts instanceof \Illuminate\Support\Collection ? $carts : collect($carts);
    $active_carts = $carts->where('status', 1);
    $subtotal = 0;
    $tax = 0;
    $shipping = 0;
    foreach ($active_carts as $cartItem) {
        $product = $cartItem->product;
        if (!$product) continue;
        $subtotal += cart_product_price($cartItem, $product, false, false) * $cartItem->quantity;
        $tax += cart_product_tax($cartItem, $product, false) * $cartItem->quantity;
        $shipping += $cartItem->shipping_cost;
    }
    $discount = $active_carts->sum('discount');
    $total = $subtotal + $tax + $shipping - $discount;
@endphp
<div class="acc-card acc-cart-summary">
    <h3 style="margin:0 0 1rem;font-size:1.1rem;">{{ translate('Order Summary') }}</h3>
    <div class="acc-summary-row"><span>{{ translate('Subtotal') }}</span><span>{{ single_price($subtotal) }}</span></div>
    <div class="acc-summary-row"><span>{{ translate('Tax') }}</span><span>{{ single_price($tax) }}</span></div>
    <div class="acc-summary-row"><span>{{ translate('Shipping') }}</span><span>{{ single_price($shipping) }}</span></div>
    @if ($discount > 0)
        <div class="acc-summary-row" style="color:#16a34a;"><span>{{ translate('Coupon Discount') }}</span><span>-{{ single_price($discount) }}</span></div>
    @endif
    <div class="acc-summary-row acc-summary-row--total"><span>{{ translate('Total') }}</span><span>{{ single_price($total) }}</span></div>

    @if ($proceed == 0 && Route::currentRouteName() === 'cart')
        <div style="margin-top:1rem;">
            <input type="text" id="acc-coupon-code" placeholder="{{ translate('Coupon code') }}" style="width:100%;padding:0.6rem;border:1px solid var(--mp-border);border-radius:8px;margin-bottom:0.5rem;">
            <button type="button" id="acc-apply-coupon" class="mp-btn mp-btn--outline" style="width:100%;justify-content:center;margin-bottom:0.75rem;">{{ translate('Apply Coupon') }}</button>
        </div>
        @if ($active_carts->count())
            <a href="{{ route('checkout') }}" class="mp-btn mp-btn--primary" style="width:100%;justify-content:center;">{{ translate('Proceed to Checkout') }}</a>
        @endif
    @endif
</div>
