<?php

namespace App\Http\Controllers;

use App\Models\ClubPoint;
use App\Models\ClubPointDetail;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClubPointController extends Controller
{
    public function userpoint_index()
    {
        if (!addon_is_activated('club_point')) {
            abort(404);
        }
        $club_points = ClubPoint::where('user_id', Auth::id())->latest()->paginate(12);
        $total_points = get_user_total_club_point();

        return business_view('pages.loyalty.history', compact('club_points', 'total_points'));
    }

    public function redeem_index()
    {
        if (!addon_is_activated('club_point')) {
            abort(404);
        }
        $club_points = ClubPoint::where('user_id', Auth::id())->where('convert_status', 0)->latest()->get();
        $total_points = get_user_total_club_point();
        return business_view('pages.loyalty.redeem', compact('club_points', 'total_points'));
    }

    public function convert_point_into_wallet(Request $request)
    {
        if (!addon_is_activated('club_point')) {
            abort(404);
        }

        $club_point = ClubPoint::where('id', $request->id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($club_point->convert_status != 0) {
            flash(translate('Already converted'))->warning();
            return back();
        }

        $amount = 0;
        foreach ($club_point->club_point_details as $detail) {
            if ($detail->refunded == 0) {
                $detail->converted_amount = floatval($detail->point / get_setting('club_point_convert_rate'));
                $detail->save();
                $amount += $detail->converted_amount;
            }
        }

        $wallet = new Wallet;
        $wallet->user_id = Auth::id();
        $wallet->amount = $amount;
        $wallet->payment_method = 'Club Point Convert';
        $wallet->payment_details = 'Club Point Convert';
        $wallet->save();

        $user = Auth::user();
        $user->balance += $amount;
        $user->save();

        $club_point->convert_status = 1;
        $club_point->save();

        flash(translate('Points converted to wallet successfully'))->success();
        return back();
    }

    public function processClubPoints($order)
    {
        if (!addon_is_activated('club_point') || !$order->user_id) {
            return;
        }

        if (ClubPoint::where('order_id', $order->id)->exists()) {
            return;
        }

        $points = $order->orderDetails->sum('earn_point');
        if ($points <= 0) {
            return;
        }

        $club_point = new ClubPoint;
        $club_point->user_id = $order->user_id;
        $club_point->order_id = $order->id;
        $club_point->points = $points;
        $club_point->convert_status = 0;
        $club_point->save();

        foreach ($order->orderDetails as $detail) {
            if ($detail->earn_point > 0) {
                $cpd = new ClubPointDetail;
                $cpd->club_point_id = $club_point->id;
                $cpd->product_id = $detail->product_id;
                $cpd->point = $detail->earn_point;
                $cpd->save();
            }
        }
    }

    /* Admin */

    public function configure_index()
    {
        return view('backend.club_points.config');
    }

    public function index()
    {
        $club_points = ClubPoint::with('user')->latest()->paginate(20);
        return view('backend.club_points.index', compact('club_points'));
    }

    public function set_point()
    {
        $products = Product::where('earn_point', '>', 0)->paginate(20);
        return view('backend.club_points.set_point', compact('products'));
    }

    public function set_products_point(Request $request)
    {
        flash(translate('Saved'))->success();
        return back();
    }

    public function set_all_products_point(Request $request)
    {
        flash(translate('Saved'))->success();
        return back();
    }

    public function set_point_edit($id)
    {
        return view('backend.club_points.edit', ['product' => Product::findOrFail($id)]);
    }

    public function club_point_detail($id)
    {
        $club_point = ClubPoint::with('club_point_details')->findOrFail($id);
        return view('backend.club_points.detail', compact('club_point'));
    }

    public function update_product_point(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->earn_point = $request->earn_point;
        $product->save();
        flash(translate('Updated'))->success();
        return back();
    }

    public function convert_rate_store(Request $request)
    {
        flash(translate('Use business settings to update convert rate'))->info();
        return back();
    }
}
