@php
    $home_categories = isset($featured_categories) && count($featured_categories)
        ? $featured_categories
        : \App\Models\Category::with(['childrenCategories.childrenCategories', 'bannerImage'])
            ->where('featured', 1)->limit(10)->get();
@endphp
@if ($home_categories->count())
<section class="mp-section mp-section--white mp-home-categories">
    <div class="mp-container">
        <div class="mp-section__head mp-animate">
            <h2 class="mp-section__title">{{ translate('Shop by Category') }}</h2>
            <a href="{{ route('categories.all') }}" class="mp-section__link">{{ translate('View All') }} &rarr;</a>
        </div>
        <div class="mp-home-cat-bar">
            @foreach ($home_categories as $category)
                @php
                    $name = $category->getTranslation('name');
                    $has_children = $category->childrenCategories->isNotEmpty();
                @endphp
                <div class="mp-home-cat-item {{ $has_children ? 'has-dropdown' : '' }}">
                    <a href="{{ route('products.category', $category->slug) }}" class="mp-home-cat-link">
                        @if ($category->banner)
                            <img src="{{ uploaded_asset($category->banner) }}" alt="{{ $name }}"
                                onerror="this.style.display='none'">
                        @endif
                        <span>{{ $name }}</span>
                        @if ($has_children)
                            <i class="las la-angle-down mp-home-cat-chevron"></i>
                        @endif
                    </a>
                    @if ($has_children)
                        <div class="mp-home-cat-dropdown">
                            <div class="mp-home-cat-dropdown__panel">
                                @foreach ($category->childrenCategories as $child)
                                    <a href="{{ route('products.category', $child->slug) }}" class="mp-home-cat-dropdown__link">
                                        {{ $child->getTranslation('name') }}
                                    </a>
                                    @foreach ($child->childrenCategories as $grandchild)
                                        <a href="{{ route('products.category', $grandchild->slug) }}" class="mp-home-cat-dropdown__sublink">
                                            {{ $grandchild->getTranslation('name') }}
                                        </a>
                                    @endforeach
                                @endforeach
                                <a href="{{ route('products.category', $category->slug) }}" class="mp-home-cat-dropdown__all">
                                    {{ translate('View all in') }} {{ $name }} &rarr;
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
