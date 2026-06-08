<section class="mp-policy-ribbon">
    <div class="mp-container">
        <div class="mp-policy-ribbon__grid">
            <a href="{{ route('terms') }}" class="mp-policy-ribbon__item">
                <i class="las la-file-alt" aria-hidden="true"></i>
                <span>{{ translate('Terms & Conditions') }}</span>
            </a>
            <a href="{{ route('returnpolicy') }}" class="mp-policy-ribbon__item">
                <i class="las la-undo-alt" aria-hidden="true"></i>
                <span>{{ translate('Return Policy') }}</span>
            </a>
            <a href="{{ route('supportpolicy') }}" class="mp-policy-ribbon__item">
                <i class="las la-headset" aria-hidden="true"></i>
                <span>{{ translate('Support Policy') }}</span>
            </a>
            <a href="{{ route('privacypolicy') }}" class="mp-policy-ribbon__item">
                <i class="las la-exclamation-circle" aria-hidden="true"></i>
                <span>{{ translate('Privacy Policy') }}</span>
            </a>
        </div>
    </div>
</section>
