@if(get_setting('vendor_system_activation') == 1 && count(get_best_sellers(12)) > 0)
    <div class="mp-section__head">
        <h2 class="mp-section__title">{{ translate('Popular Stores') }}</h2>
        <a href="{{ route('sellers') }}" class="mp-section__link">{{ translate('View All') }}</a>
    </div>
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:1rem;">
        @foreach(get_best_sellers(12) as $seller)
            @include('modules.marketplace.components.store-card', ['seller' => $seller])
        @endforeach
    </div>
@endif
