@php $top_brands = \App\Models\Brand::where('top', 1)->take(12)->get(); @endphp
@if($top_brands->count())
<section class="mp-section mp-section--white">
    <div class="mp-container">
        <div class="mp-section__head">
            <h2 class="mp-section__title">{{ translate('Brands') }}</h2>
            <a href="{{ route('brands.all') }}" class="mp-section__link">{{ translate('View All') }}</a>
        </div>
        <div class="mp-brand-grid">
            @foreach($top_brands as $brand)
                <a href="{{ route('products.brand', $brand->slug) }}" class="mp-brand-item">
                    @if($brand->logo)
                        <img src="{{ uploaded_asset($brand->logo) }}" alt="{{ $brand->getTranslation('name') }}">
                    @endif
                    {{ $brand->getTranslation('name') }}
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif
