<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ translate('POS') }} | {{ get_setting('site_name') }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ static_asset('assets/modules/business/css/business.css') }}?v=1.0.0">
</head>
<body class="biz-pos">
    <div class="biz-pos__layout">
        <aside class="biz-pos__sidebar">
            <h2>{{ translate('POS System') }}</h2>
            <div class="biz-pos__scan">
                <label>{{ translate('Barcode / SKU Scanner') }}</label>
                <input type="text" id="pos-barcode" class="form-control" placeholder="{{ translate('Scan or type barcode...') }}" autofocus>
            </div>
            <div class="biz-pos__search">
                <label>{{ translate('Product Search') }}</label>
                <input type="text" id="pos-search" class="form-control" placeholder="{{ translate('Search products...') }}">
            </div>
            <div id="pos-results" class="biz-pos__results"></div>
        </aside>

        <main class="biz-pos__main">
            <h3>{{ translate('Counter Checkout') }}</h3>
            <table class="biz-table" id="pos-cart">
                <thead><tr><th>{{ translate('Product') }}</th><th>{{ translate('Qty') }}</th><th>{{ translate('Price') }}</th><th></th></tr></thead>
                <tbody>
                    @foreach($carts as $cart)
                        <tr data-id="{{ $cart->id }}">
                            <td>{{ optional($cart->product)->getTranslation('name') }}</td>
                            <td>{{ $cart->quantity }}</td>
                            <td>{{ single_price($cart->price * $cart->quantity) }}</td>
                            <td><button class="btn btn-sm btn-danger pos-remove" data-id="{{ $cart->id }}">×</button></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="biz-pos__total">
                <strong>{{ translate('Total') }}: {{ single_price($total) }}</strong>
            </div>
            <div class="biz-pos__actions">
                <button class="btn btn-primary" id="pos-checkout">{{ translate('Complete Sale') }}</button>
                <button class="btn btn-outline-secondary" onclick="window.print()">{{ translate('Receipt Printing') }}</button>
            </div>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script>
        window.POS_CONFIG = {
            searchUrl: '{{ $search_route }}',
            addUrl: '{{ $add_route }}',
            removeUrl: '{{ $is_admin ? route("pos.removeFromCart") : route("seller.pos.removeFromCart") }}',
            token: '{{ csrf_token() }}'
        };
    </script>
    <script src="{{ static_asset('assets/modules/business/js/business.js') }}?v=1.0.0"></script>
</body>
</html>
