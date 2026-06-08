<section class="mp-section">
    <div class="mp-container">
        <div class="mp-newsletter">
            <h2 style="margin:0 0 0.5rem;">{{ translate('Subscribe to our newsletter') }}</h2>
            <p style="margin:0;opacity:0.8;">{{ translate('Get updates on deals and new arrivals.') }}</p>
            <form action="{{ route('subscribers.store') }}" method="POST">
                @csrf
                <input type="email" name="email" placeholder="{{ translate('Your email address') }}" required>
                <button type="submit" class="mp-btn mp-btn--primary">{{ translate('Subscribe') }}</button>
            </form>
        </div>
    </div>
</section>
