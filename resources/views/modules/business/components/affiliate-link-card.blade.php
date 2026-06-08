<div class="biz-affiliate-link">
    <h4>{{ translate('Your Referral Link') }}</h4>
    <div class="biz-affiliate-link__row">
        <input type="text" readonly value="{{ $link }}" id="biz-ref-link" class="form-control">
        <button type="button" class="mp-btn mp-btn--primary" onclick="BIZ.copyReferral()">{{ translate('Copy') }}</button>
    </div>
    <p class="biz-affiliate-link__code">{{ translate('Referral Code') }}: <strong>{{ auth()->user()->referral_code }}</strong></p>
</div>
