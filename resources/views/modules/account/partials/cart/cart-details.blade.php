@php
    $carts = $carts instanceof \Illuminate\Support\Collection ? $carts : collect($carts);
    $active_carts = $carts->where('status', 1);
    $grouped = $active_carts->groupBy('owner_id');
@endphp
@if ($active_carts->count())
    @foreach ($grouped as $owner_id => $seller_carts)
        @php $shop = \App\Models\User::find($owner_id)?->shop; @endphp
        <div class="acc-card" style="margin-bottom:1rem;">
            @if ($shop)
                <p style="margin:0 0 1rem;font-weight:600;color:var(--mp-primary);">
                    <i class="las la-store"></i> {{ $shop->name }}
                </p>
            @endif
            @foreach ($seller_carts as $cartItem)
                @php
                    $product = $cartItem->product;
                    if (!$product) continue;
                    $price = cart_product_price($cartItem, $product);
                @endphp
                <div class="acc-cart-item" data-cart-id="{{ $cartItem->id }}">
                    <a href="{{ route('product', $product->slug) }}">
                        <img src="{{ uploaded_asset($product->thumbnail_img) }}" alt="{{ $product->getTranslation('name') }}">
                    </a>
                    <div>
                        <a href="{{ route('product', $product->slug) }}" style="font-weight:600;color:inherit;">{{ $product->getTranslation('name') }}</a>
                        @if ($cartItem->variation)
                            <p style="margin:0.25rem 0 0;font-size:0.8rem;color:var(--mp-muted);">{{ $cartItem->variation }}</p>
                        @endif
                        <p style="margin:0.5rem 0 0;font-weight:700;color:var(--mp-primary);">{{ $price }}</p>
                        <div class="acc-qty" style="margin-top:0.5rem;">
                            <button type="button" class="acc-qty-minus" data-id="{{ $cartItem->id }}" data-type="minus">−</button>
                            <input type="number" value="{{ $cartItem->quantity }}" min="{{ $product->min_qty }}" readonly>
                            <button type="button" class="acc-qty-plus" data-id="{{ $cartItem->id }}" data-type="plus">+</button>
                        </div>
                    </div>
                    <button type="button" class="acc-remove-cart" data-id="{{ $cartItem->id }}" style="background:none;border:none;color:#dc2626;cursor:pointer;font-size:1.1rem;" title="{{ translate('Remove') }}">
                        <i class="las la-trash"></i>
                    </button>
                </div>
            @endforeach
        </div>
    @endforeach
@else
    <p style="color:var(--mp-muted);">{{ translate('Your cart is empty.') }}</p>
@endif
