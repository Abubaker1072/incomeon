@php
    $menu_categories = $categories ?? \App\Models\Category::where('level', 0)->orderBy('order_level', 'desc')->take(12)->get();
@endphp
<nav class="mp-cat-menu" aria-label="{{ translate('Categories') }}">
    @foreach($menu_categories as $category)
        <a href="{{ route('products.category', $category->slug) }}">{{ $category->getTranslation('name') }}</a>
    @endforeach
</nav>
