<div class="acc-card" style="background:linear-gradient(135deg,var(--mp-primary),var(--mp-accent));color:#fff;margin-bottom:1.5rem;">
    <p style="margin:0 0 0.35rem;opacity:0.85;font-size:0.85rem;">{{ translate('Available Balance') }}</p>
    <p style="margin:0 0 1.25rem;font-size:2rem;font-weight:800;">{{ single_price($balance) }}</p>
    <form action="{{ route('wallet.recharge') }}" method="POST" style="display:flex;gap:0.5rem;flex-wrap:wrap;">
        @csrf
        <input type="number" name="amount" min="1" step="0.01" placeholder="{{ translate('Recharge amount') }}" required
            style="flex:1;min-width:140px;padding:0.6rem;border:none;border-radius:8px;">
        <input type="hidden" name="payment_option" value="stripe">
        <button type="submit" class="mp-btn" style="background:#fff;color:var(--mp-primary);">{{ translate('Recharge') }}</button>
    </form>
</div>
