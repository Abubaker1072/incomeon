<div data-mp-scroll>
    <div class="mp-section__head">
        <h2 class="mp-section__title">{{ $title }}</h2>
        <div>
            <button type="button" class="mp-btn mp-btn--outline" data-scroll-prev><i class="las la-angle-left"></i></button>
            <button type="button" class="mp-btn mp-btn--outline" data-scroll-next><i class="las la-angle-right"></i></button>
            @if(!empty($view_all_url))
                <a href="{{ $view_all_url }}" class="mp-section__link" style="margin-left:0.5rem;">{{ translate('View All') }}</a>
            @endif
        </div>
    </div>
    <div class="mp-product-scroll" data-scroll-track>
        @foreach($products as $product)
            @include('modules.marketplace.components.product-card', ['product' => $product])
        @endforeach
    </div>
</div>
