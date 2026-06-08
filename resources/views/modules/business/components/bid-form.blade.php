<form action="{{ route('auction_product_bids.store') }}" method="POST" class="biz-bid-form">
    @csrf
    <input type="hidden" name="product_id" value="{{ $product->id }}">
    <label>{{ translate('Your Bid') }}</label>
    <div class="biz-bid-form__row">
        <input type="number" step="0.01" name="amount" class="form-control"
            min="{{ ($highest_bid->amount ?? $product->starting_bid ?? 0) + 0.01 }}"
            placeholder="{{ translate('Enter amount') }}" required>
        <button type="submit" class="mp-btn mp-btn--primary">{{ translate('Place Bid') }}</button>
    </div>
    <small>{{ translate('Minimum') }}: {{ single_price(($highest_bid->amount ?? $product->starting_bid ?? 0) + 0.01) }}</small>
</form>
