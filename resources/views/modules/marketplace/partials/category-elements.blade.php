<div class="mp-nav-dropdown__grid">
    @foreach ($categories->childrenCategories as $category)
        <div class="mp-nav-dropdown__col">
            <a href="{{ route('products.category', $category->slug) }}" class="mp-nav-dropdown__parent">
                {{ $category->getTranslation('name') }}
            </a>
            @foreach ($category->childrenCategories as $child)
                <a href="{{ route('products.category', $child->slug) }}" class="mp-nav-dropdown__child">
                    {{ $child->getTranslation('name') }}
                </a>
            @endforeach
        </div>
    @endforeach
</div>
