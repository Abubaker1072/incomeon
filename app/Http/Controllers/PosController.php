<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Utility\PosUtility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PosController extends Controller
{
    protected function posView(string $name, array $data = [])
    {
        return business_view('pages.pos.' . $name, array_merge($data, [
            'is_admin' => true,
            'search_route' => route('pos.search_product'),
            'add_route' => route('pos.addToCart'),
            'order_route' => route('pos.order_place'),
            'receipt_base' => route('admin.invoice.thermal_printer', ['order_id' => '__ID__']),
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

    public function search(Request $request)
    {
        $products = PosUtility::product_search($request->only('keyword', 'category', 'brand'));
        return response()->json(['products' => $products->map(fn ($p) => [
            'id' => $p->id,
            'name' => $p->getTranslation('name'),
            'price' => home_base_price($p),
            'image' => uploaded_asset($p->thumbnail_img),
            'barcode' => $p->barcode ?? optional($p->stocks->first())->sku,
        ])]);
    }

    public function addToCart(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $session = PosUtility::ensurePosSession();
        $ownerId = PosUtility::getOwnerId();

        $cart = Cart::firstOrNew([
            'owner_id' => $ownerId,
            'user_id' => $session['user_id'],
            'temp_user_id' => $session['temp_user_id'],
            'product_id' => $product->id,
            'variation' => '',
        ]);
        $cart->quantity = ($cart->quantity ?? 0) + ($request->quantity ?? 1);
        $cart->price = home_base_price($product);
        $cart->save();

        return response()->json(['result' => true]);
    }

    public function updateQuantity(Request $request)
    {
        $cart = Cart::findOrFail($request->cart_id);
        $cart->quantity = max(1, (int) $request->quantity);
        $cart->save();
        return response()->json(['result' => true]);
    }

    public function removeFromCart(Request $request)
    {
        Cart::destroy($request->cart_id);
        return response()->json(['result' => true]);
    }

    public function updateSessionUserCartData(Request $request)
    {
        Session::put('pos.user_id', $request->user_id);
        $carts = get_pos_user_cart();
        PosUtility::updatePosUserCartData($carts, $request->user_id, Session::get('pos.temp_user_id'));
        return response()->json(['result' => true]);
    }

    public function getShippingAddress(Request $request)
    {
        $addresses = Address::where('user_id', $request->user_id)->get();
        return response()->json(['addresses' => $addresses]);
    }

    public function setDiscount(Request $request)
    {
        Session::put('pos.discount', $request->discount);
        return response()->json(['result' => true]);
    }

    public function setShipping(Request $request)
    {
        Session::put('pos.shipping', $request->shipping);
        return response()->json(['result' => true]);
    }

    public function set_shipping_address(Request $request)
    {
        Session::put('pos.address_id', $request->address_id);
        return 1;
    }

    public function get_order_summary(Request $request)
    {
        $carts = get_pos_user_cart();
        return response()->json(['total' => PosUtility::cartTotal($carts)]);
    }

    public function order_store(Request $request)
    {
        flash(translate('Use full POS checkout integration for order placement'))->info();
        return back();
    }

    public function configuration()
    {
        return view('backend.pos.config');
    }

    public function invoice($order_id)
    {
        $order = Order::findOrFail($order_id);
        return business_view('pages.pos.receipt', compact('order'));
    }
}
