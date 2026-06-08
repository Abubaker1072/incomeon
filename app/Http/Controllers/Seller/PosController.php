<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\PosController as BasePosController;
use App\Utility\PosUtility;
use Illuminate\Http\Request;

class PosController extends BasePosController
{
    protected function posView(string $name, array $data = [])
    {
        return business_view('pages.pos.' . $name, array_merge($data, [
            'is_admin' => false,
            'search_route' => route('pos.search_seller_product'),
            'add_route' => route('seller.pos.addToCart'),
            'order_route' => route('seller.pos.order_place'),
            'receipt_base' => route('seller.invoice.thermal_printer', ['order_id' => '__ID__']),
        ]));
    }

    public function index()
    {
        if (!addon_is_activated('pos_system')) {
            abort(404);
        }
        PosUtility::ensurePosSession();
        $carts = get_pos_user_cart();
        return $this->posView('counter', ['carts' => $carts, 'total' => PosUtility::cartTotal($carts)]);
    }
}
