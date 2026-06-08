<?php

namespace App\Http\Controllers\Preorder;

use App\Http\Controllers\Controller;
use App\Models\PreorderProduct;
use App\Services\BusinessService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function all_preorder_products()
    {
        if (!addon_is_activated('preorder')) {
            abort(404);
        }
        $products = BusinessService::preorderProducts(12);
        return business_view('pages.preorder.listing', compact('products'));
    }

    public function product_details($slug)
    {
        if (!addon_is_activated('preorder')) {
            abort(404);
        }
        $product = PreorderProduct::where('slug', $slug)->firstOrFail();
        return business_view('pages.preorder.detail', compact('product'));
    }

    public function listingByCategory($category_slug)
    {
        $products = PreorderProduct::where('is_published', 1)
            ->whereHas('category', fn ($q) => $q->where('slug', $category_slug))
            ->paginate(12);
        return business_view('pages.preorder.listing', compact('products'));
    }

    public function how_to_preorder()
    {
        return business_view('pages.preorder.how-to');
    }

    public function product_search(Request $request)
    {
        return response()->json(['result' => true]);
    }

    public function get_selected_products(Request $request)
    {
        return response()->json(['result' => true]);
    }
}
