@extends('modules.delivery.layouts.app')

@section('panel_content')
<div class="dlv-page">
    <div class="dlv-page__head">
        <h1>{{ translate('COD Collection') }}</h1>
        <p>{{ translate('Track cash-on-delivery amounts collected from customers') }}</p>
    </div>

    @include('modules.delivery.components.cod-summary', ['cod' => $cod])
</div>
@endsection
