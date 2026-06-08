<?php

namespace App\Http\Controllers;

use App\Models\AuctionProductBid;
use App\Models\Order;
use App\Models\Product;
use App\Services\BusinessService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuctionProductController extends Controller
{
    /* ── Customer (Module 6) ─────────────────────────────────── */

    public function all_auction_products()
    {
        if (!addon_is_activated('auction')) {
            abort(404);
        }
        $products = BusinessService::activeAuctions(12);
        return business_view('pages.auction.index', compact('products'));
    }

    public function auction_product_details($slug)
    {
        if (!addon_is_activated('auction')) {
            abort(404);
        }
        $product = Product::where('slug', $slug)->where('auction_product', 1)->firstOrFail();
        $highest_bid = AuctionProductBid::where('product_id', $product->id)->orderBy('amount', 'desc')->first();
        $user_bid = Auth::check()
            ? AuctionProductBid::where('product_id', $product->id)->where('user_id', Auth::id())->first()
            : null;
        $bid_history = AuctionProductBid::where('product_id', $product->id)
            ->with('user')
            ->orderBy('amount', 'desc')
            ->take(20)
            ->get();

        return business_view('pages.auction.detail', compact('product', 'highest_bid', 'user_bid', 'bid_history'));
    }

    public function purchase_history_user()
    {
        if (!addon_is_activated('auction') || !Auth::check()) {
            abort(404);
        }
        $orders = DB::table('orders')
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->where('orders.user_id', Auth::id())
            ->where('products.auction_product', 1)
            ->select('orders.*')
            ->distinct()
            ->orderBy('orders.date', 'desc')
            ->paginate(12);

        return business_view('pages.auction.winners', compact('orders'));
    }

    public function bid_history_user()
    {
        if (!addon_is_activated('auction') || !Auth::check()) {
            abort(404);
        }
        $products = BusinessService::userBidHistory();
        return business_view('pages.auction.bid-history', compact('products'));
    }

    /* ── Admin / Seller stubs ────────────────────────────────── */

    public function all_auction_product_list()
    {
        return view('backend.auction.index', ['products' => Product::where('auction_product', 1)->paginate(15)]);
    }

    public function inhouse_auction_products()
    {
        return view('backend.auction.index', ['products' => Product::where('auction_product', 1)->where('added_by', 'admin')->paginate(15)]);
    }

    public function seller_auction_products()
    {
        return view('backend.auction.index', ['products' => Product::where('auction_product', 1)->where('added_by', 'seller')->paginate(15)]);
    }

    public function product_create_admin()
    {
        return view('backend.auction.form', ['product' => null]);
    }

    public function product_store_admin(Request $request)
    {
        flash(translate('Use product management to create auction products'))->info();
        return back();
    }

    public function product_edit_admin($id)
    {
        return view('backend.auction.form', ['product' => Product::findOrFail($id)]);
    }

    public function product_update_admin(Request $request, $id)
    {
        flash(translate('Updated'))->success();
        return back();
    }

    public function product_destroy_admin($id)
    {
        Product::destroy($id);
        flash(translate('Deleted'))->success();
        return back();
    }

    public function admin_auction_product_orders()
    {
        return view('backend.auction.orders', ['orders' => Order::latest()->paginate(15)]);
    }

    public function auction_product_list_seller()
    {
        $products = Product::where('auction_product', 1)->where('user_id', Auth::id())->paginate(15);
        return view('seller.auction.index', compact('products'));
    }

    public function product_create_seller()
    {
        return view('seller.auction.form', ['product' => null]);
    }

    public function product_store_seller(Request $request)
    {
        flash(translate('Use seller product management'))->info();
        return back();
    }

    public function product_edit_seller($id)
    {
        return view('seller.auction.form', ['product' => Product::findOrFail($id)]);
    }

    public function product_update_seller(Request $request, $id)
    {
        flash(translate('Updated'))->success();
        return back();
    }

    public function product_destroy_seller($id)
    {
        Product::where('id', $id)->where('user_id', Auth::id())->delete();
        flash(translate('Deleted'))->success();
        return back();
    }

    public function seller_auction_product_orders()
    {
        return view('seller.auction.orders', ['orders' => Order::where('seller_id', Auth::id())->paginate(15)]);
    }
}
