<aside class="mp-filters">
    <h3>{{ translate('Filters') }}</h3>
    <form id="mp-search-form" method="GET" action="{{ $form_action ?? route('search') }}">
        @if(request('keyword') || ($query ?? null))
            <input type="hidden" name="keyword" value="{{ $query ?? request('keyword') }}">
        @endif
        <label>{{ translate('Sort by') }}</label>
        <select name="sort_by" onchange="this.form.submit()">
            <option value="">{{ translate('Default') }}</option>
            <option value="newest" @selected(($sort_by ?? '') == 'newest')>{{ translate('Newest') }}</option>
            <option value="oldest" @selected(($sort_by ?? '') == 'oldest')>{{ translate('Oldest') }}</option>
            <option value="price-asc" @selected(($sort_by ?? '') == 'price-asc')>{{ translate('Price low to high') }}</option>
            <option value="price-desc" @selected(($sort_by ?? '') == 'price-desc')>{{ translate('Price high to low') }}</option>
        </select>
        <label>{{ translate('Min price') }}</label>
        <input type="number" name="min_price" value="{{ $min_price ?? request('min_price') }}" min="0" step="1">
        <label>{{ translate('Max price') }}</label>
        <input type="number" name="max_price" value="{{ $max_price ?? request('max_price') }}" min="0" step="1">
        @if(isset($categories) && count($categories))
            <label>{{ translate('Category') }}</label>
            <select name="category" onchange="this.form.submit()">
                <option value="">{{ translate('All') }}</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->slug }}" @selected(request('category') == $cat->slug)>{{ $cat->getTranslation('name') }}</option>
                @endforeach
            </select>
        @endif
        @if(addon_is_activated('auction'))
            <label><input type="checkbox" name="auction_product" value="1" @checked(request('auction_product'))> {{ translate('Auction only') }}</label>
        @endif
        @if(addon_is_activated('wholesale'))
            <label><input type="checkbox" name="wholesale_product" value="1" @checked(request('wholesale_product'))> {{ translate('Wholesale only') }}</label>
        @endif
        <button type="submit" class="mp-btn mp-btn--primary" style="width:100%;margin-top:0.5rem;">{{ translate('Apply') }}</button>
    </form>
</aside>
