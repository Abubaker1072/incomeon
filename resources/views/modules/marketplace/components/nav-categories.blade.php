@php
    $nav_categories = $nav_categories ?? \App\Models\Category::with([
        'childrenCategories.childrenCategories',
        'catIcon',
    ])->where('level', 0)->orderBy('order_level', 'desc')->take(14)->get();
@endphp
@foreach ($nav_categories as $category)
    @php
        $name = $category->getTranslation('name');
        $has_children = $category->childrenCategories->isNotEmpty();
        $cat_url = route('products.category', $category->slug);
    @endphp
    <div class="mp-nav-item {{ $has_children ? 'has-dropdown' : '' }}">
        <a href="{{ $cat_url }}" class="mp-nav-link">
            <span>{{ strtoupper($name) }}</span>
            @if ($has_children)
                <i class="las la-angle-down mp-nav-chevron" aria-hidden="true"></i>
            @endif
        </a>
        @if ($has_children)
            <div class="mp-nav-dropdown">
                <div class="mp-nav-dropdown__inner mp-container">
                    <div class="mp-nav-dropdown__head">
                        <strong>{{ $name }}</strong>
                        <a href="{{ $cat_url }}">{{ translate('View all') }} &rarr;</a>
                    </div>
                    <div class="mp-nav-dropdown__grid">
                        @foreach ($category->childrenCategories as $child)
                            <div class="mp-nav-dropdown__col">
                                <a href="{{ route('products.category', $child->slug) }}" class="mp-nav-dropdown__parent">
                                    {{ $child->getTranslation('name') }}
                                </a>
                                @foreach ($child->childrenCategories as $grandchild)
                                    <a href="{{ route('products.category', $grandchild->slug) }}" class="mp-nav-dropdown__child">
                                        {{ $grandchild->getTranslation('name') }}
                                    </a>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>
@endforeach
