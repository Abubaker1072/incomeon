<form action="{{ route('search') }}" method="GET">
    <input type="text" name="keyword" value="{{ $query ?? request('keyword') }}"
        placeholder="{{ translate('Search products, brands, stores...') }}" autocomplete="off">
    <button type="submit" aria-label="{{ translate('Search') }}"><i class="las la-search"></i></button>
</form>
