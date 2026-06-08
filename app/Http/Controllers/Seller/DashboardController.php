<?php

namespace App\Http\Controllers\Seller;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\ProductStock;
use Auth;
use Carbon\Carbon;
use DB;

class DashboardController extends Controller
{
    public function index()
    {
        $authUser = Auth::user();
        $authUserId = $authUser->id;

        $data['total_revenue'] = Order::where('seller_id', $authUserId)
            ->where('payment_status', 'paid')
            ->sum('grand_total');

        $data['total_orders'] = Order::where('seller_id', $authUserId)->count();

        $data['pending_orders'] = Order::where('seller_id', $authUserId)
            ->where('delivery_status', 'pending')
            ->count();

        $data['confirmed_orders'] = Order::where('seller_id', $authUserId)
            ->where('delivery_status', 'confirmed')
            ->count();

        $data['packed_orders'] = Order::where('seller_id', $authUserId)
            ->where('delivery_status', 'picked_up')
            ->count();

        $data['delivered_orders'] = Order::where('seller_id', $authUserId)
            ->where('delivery_status', 'delivered')
            ->count();

        $data['store_rating'] = optional($authUser->shop)->rating
            ?? Product::where('user_id', $authUserId)->where('rating', '>', 0)->avg('rating')
            ?? 0;

        $data['wallet_balance'] = $authUser->balance ?? 0;

        $data['this_month_pending_orders'] = OrderDetail::whereSellerId($authUserId)
            ->whereDeliveryStatus('pending')
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();

        $data['this_month_cancelled_orders'] = OrderDetail::whereSellerId($authUserId)
            ->whereDeliveryStatus('cancelled')
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();

        $data['this_month_on_the_way_orders'] = OrderDetail::whereSellerId($authUserId)
            ->whereDeliveryStatus('on_the_way')
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();

        $data['this_month_delivered_orders'] = OrderDetail::whereSellerId($authUserId)
            ->whereDeliveryStatus('delivered')
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();

        $data['this_month_sold_amount'] = Order::where('seller_id', $authUserId)
            ->wherePaymentStatus('paid')
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->sum('grand_total');

        $data['previous_month_sold_amount'] = Order::where('seller_id', $authUserId)
            ->wherePaymentStatus('paid')
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month - 1)
            ->sum('grand_total');

        $data['products'] = filter_products(
            Product::where('user_id', $authUserId)->orderBy('num_of_sale', 'desc')
        )->limit(8)->get();

        $data['low_stock_products'] = Product::where('user_id', $authUserId)
            ->where('digital', 0)
            ->whereHas('stocks', function ($q) {
                $q->where('qty', '<=', 5);
            })
            ->with(['stocks' => function ($q) {
                $q->orderBy('qty');
            }])
            ->limit(6)
            ->get();

        $data['recent_orders'] = Order::where('seller_id', $authUserId)
            ->latest()
            ->limit(6)
            ->get();

        $data['last_7_days_sales'] = Order::where('created_at', '>=', Carbon::now()->subDays(7))
            ->where('seller_id', $authUserId)
            ->where('delivery_status', 'delivered')
            ->select(DB::raw('sum(grand_total) as total, DATE_FORMAT(created_at, "%d %b") as date'))
            ->groupBy(DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d")'))
            ->get()
            ->pluck('total', 'date');

        $data['total_products'] = Product::where('user_id', $authUserId)->count();

        return view('seller.dashboard', $data);
    }
}
