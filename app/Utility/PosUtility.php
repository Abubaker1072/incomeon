<?php

namespace App\Utility;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

class PosUtility
{
    public static function product_search(array $filters = [])
    {
        $query = Product::isApprovedPublished();

        if (!empty($filters['keyword'])) {
            $keyword = $filters['keyword'];
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', '%' . $keyword . '%')
                    ->orWhere('barcode', 'like', '%' . $keyword . '%')
                    ->orWhereHas('stocks', function ($s) use ($keyword) {
                        $s->where('sku', 'like', '%' . $keyword . '%');
                    });
            });
        }

        if (!empty($filters['category'])) {
            $query->where('category_id', $filters['category']);
        }

        if (!empty($filters['brand'])) {
            $query->where('brand_id', $filters['brand']);
        }

        $authUser = auth()->user();
        if ($authUser && $authUser->user_type === 'seller') {
            $query->where('user_id', $authUser->id);
        }

        return $query->limit(24)->get();
    }

    public static function updatePosUserCartData($carts, $userId = null, $tempUserId = null)
    {
        foreach ($carts as $cart) {
            $cart->user_id = $userId;
            $cart->temp_user_id = $tempUserId;
            $cart->save();
        }
    }

    public static function ensurePosSession(): array
    {
        if (!Session::has('pos.temp_user_id')) {
            Session::put('pos.temp_user_id', bin2hex(random_bytes(8)));
        }

        return [
            'user_id' => Session::get('pos.user_id'),
            'temp_user_id' => Session::get('pos.temp_user_id'),
        ];
    }

    public static function getOwnerId()
    {
        $authUser = auth()->user();
        return in_array($authUser->user_type, ['admin', 'staff']) ? get_admin()->id : $authUser->id;
    }

    public static function cartTotal($carts)
    {
        $total = 0;
        foreach ($carts as $cart) {
            $total += cart_product_price($cart, $cart->product, false, false) * $cart->quantity;
        }
        return $total;
    }
}
