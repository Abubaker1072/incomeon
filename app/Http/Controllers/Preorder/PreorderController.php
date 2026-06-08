<?php

namespace App\Http\Controllers\Preorder;

use App\Http\Controllers\Controller;
use App\Models\Preorder;
use App\Services\BusinessService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PreorderController extends Controller
{
    public function order_list()
    {
        if (!addon_is_activated('preorder')) {
            abort(404);
        }
        $orders = BusinessService::userPreorders();
        return business_view('pages.preorder.orders', compact('orders'));
    }

    public function order_details($id)
    {
        $order = Preorder::where('id', $id)->where('user_id', Auth::id())
            ->with('preorder_product')
            ->firstOrFail();
        return business_view('pages.preorder.order-detail', compact('order'));
    }

    public function updateDeliveryAddress(Request $request)
    {
        return back();
    }

    public function place_order(Request $request)
    {
        flash(translate('Preorder placement requires payment gateway configuration'))->info();
        return back();
    }

    public function order_update(Request $request, $id)
    {
        flash(translate('Order updated'))->success();
        return back();
    }

    public function apply_coupon_code(Request $request)
    {
        return response()->json(['result' => false]);
    }

    public function remove_coupon_code(Request $request)
    {
        return response()->json(['result' => true]);
    }

    public function preorderSettings()
    {
        return view('preorder.backend.settings.index');
    }
}
