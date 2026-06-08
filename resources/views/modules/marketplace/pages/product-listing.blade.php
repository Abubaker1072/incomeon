@extends('modules.marketplace.layouts.app')

@section('meta_title'){{ $meta_title ?? get_setting('meta_title') }}@stop
@section('meta_description'){{ $meta_description ?? get_setting('meta_description') }}@stop

@section('content')
<div class="mp-container mp-listing">
    @include('modules.marketplace.components.filters', [
        'categories' => $categories ?? [],
        'query' => $query ?? null,
        'sort_by' => $sort_by ?? null,
        'min_price' => $min_price ?? null,
        'max_price' => $max_price ?? null,
    ])
    <div>
        <div class="mp-section__head">
            <h1 class="mp-section__title">
                @if(isset($category) && $category)
                    {{ $category->getTranslation('name') }}
                @elseif(isset($brand_id) && $brand_id)
                    {{ get_single_brand($brand_id)->getTranslation('name') }}
                @elseif($query ?? request('keyword'))
                    {{ translate('Search') }}: {{ $query ?? request('keyword') }}
                @else
                    {{ translate('Products') }}
                @endif
            </h1>
            <span style="color:var(--mp-muted);font-size:0.875rem;">{{ $products->total() }} {{ translate('items') }}</span>
        </div>
        @if($products->count())
            <div class="mp-product-grid">
                @foreach($products as $product)
                    @include('modules.marketplace.components.product-card', ['product' => $product])
                @endforeach
            </div>
            @include('modules.marketplace.components.pagination', ['paginator' => $products])
        @else
            <p>{{ translate('No products found.') }}</p>
        @endif
    </div>
</div>
@endsection
