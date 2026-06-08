@extends('modules.marketplace.layouts.app')

@section('meta_title'){{ translate('Stores') }} | {{ get_setting('website_name') }}@stop

@section('content')
<div class="mp-container" style="padding:2rem 0 3rem;">
    <div class="mp-section__head">
        <h1 class="mp-section__title">{{ translate('Popular Stores') }}</h1>
    </div>
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:1rem;margin-top:1.5rem;">
        @foreach($shops as $shop)
            @include('modules.marketplace.components.store-card', ['seller' => $shop])
        @endforeach
    </div>
    @include('modules.marketplace.components.pagination', ['paginator' => $shops])
</div>
@endsection
