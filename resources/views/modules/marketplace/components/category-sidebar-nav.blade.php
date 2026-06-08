@php
    $nav_categories = $nav_categories ?? \App\Models\Category::with(['catIcon'])
        ->where('level', 0)->orderBy('order_level', 'desc')->take(20)->get();
@endphp
<div class="mp-nav-categories__panel-head">
    <a href="{{ route('categories.all') }}">{{ translate('See All Categories') }} &rarr;</a>
</div>
<ul class="mp-nav-categories__list">
    @foreach ($nav_categories as $category)
        @php $name = $category->getTranslation('name'); @endphp
        <li>
            <a href="{{ route('products.category', $category->slug) }}" class="mp-nav-categories__link">
                @if ($category->catIcon && $category->catIcon->file_name)
                    <img src="{{ uploaded_asset($category->catIcon->file_name) }}" alt="" width="20" height="20">
                @else
                    <i class="las la-tag" aria-hidden="true"></i>
                @endif
                <span>{{ $name }}</span>
            </a>
        </li>
    @endforeach
</ul>
