<?php

namespace App\Services;

use App\Models\AffiliateLog;
use App\Models\AuctionProductBid;
use App\Models\Preorder;
use App\Models\PreorderProduct;
use App\Models\Product;
use App\Models\WholesalePrice;
use Illuminate\Support\Facades\Auth;

class BusinessService
{
    public static function activeAuctions($paginate = 12)
    {
        if (!addon_is_activated('auction')) {
            return collect();
        }
        return get_auction_products(null, $paginate);
    }

    public static function auctionWinners($limit = 20)
    {
        if (!addon_is_activated('auction')) {
            return collect();
        }

        return Product::where('auction_product', 1)
            ->where('auction_end_date', '<', strtotime('now'))
            ->latest()
            ->limit($limit)
            ->get()
            ->map(function ($product) {
                $product->winning_bid = AuctionProductBid::where('product_id', $product->id)
                    ->orderBy('amount', 'desc')
                    ->with('user')
                    ->first();
                return $product;
            });
    }

    public static function userBidHistory()
    {
        $productIds = AuctionProductBid::where('user_id', Auth::id())->pluck('product_id');
        return Product::whereIn('id', $productIds)
            ->with(['bids' => function ($q) {
                $q->where('user_id', Auth::id())->orderBy('amount', 'desc');
            }])
            ->paginate(12);
    }

    public static function wholesaleProducts($paginate = 12)
    {
        if (!addon_is_activated('wholesale')) {
            return collect();
        }

        return Product::isApprovedPublished()
            ->where('wholesale_product', 1)
            ->latest()
            ->paginate($paginate);
    }

    public static function wholesaleTiers(Product $product)
    {
        $stock = $product->stocks->first();
        if (!$stock) {
            return collect();
        }
        return WholesalePrice::where('product_stock_id', $stock->id)
            ->orderBy('min_qty')
            ->get();
    }

    public static function preorderProducts($paginate = 12)
    {
        if (!addon_is_activated('preorder')) {
            return collect();
        }

        return PreorderProduct::where('is_published', 1)
            ->latest()
            ->paginate($paginate);
    }

    public static function userPreorders()
    {
        return Preorder::where('user_id', Auth::id())
            ->with('preorder_product')
            ->latest()
            ->paginate(12);
    }

    public static function affiliateStats()
    {
        $user = Auth::user();
        return [
            'referral_link' => route('home') . '?ref=' . ($user->referral_code ?? ''),
            'total_earnings' => AffiliateLog::where('referred_by_user', $user->id)->sum('amount'),
            'total_referrals' => AffiliateLog::where('referred_by_user', $user->id)->distinct('user_id')->count('user_id'),
            'recent_logs' => AffiliateLog::where('referred_by_user', $user->id)->latest()->take(10)->get(),
        ];
    }
}
