@extends('modules.account.layouts.app')

@section('account_content')
    <div class="acc-page-head">
        <h1>{{ translate('Shopping Cart') }}</h1>
    </div>

    <div class="acc-cart-grid">
        <div id="acc-cart-details">
            @include('modules.account.partials.cart.cart-details', ['carts' => $carts])
        </div>
        <div id="acc-cart-summary">
            @include('modules.account.partials.cart.cart-summary', ['carts' => $carts, 'proceed' => 0])
        </div>
    </div>
@endsection
