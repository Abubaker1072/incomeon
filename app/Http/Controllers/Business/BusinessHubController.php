<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Services\BusinessService;
use Illuminate\Support\Facades\Auth;

class BusinessHubController extends Controller
{
    public function index()
    {
        $modules = [
            'auction' => addon_is_activated('auction'),
            'wholesale' => addon_is_activated('wholesale'),
            'preorder' => addon_is_activated('preorder'),
            'club_point' => addon_is_activated('club_point'),
            'affiliate_system' => addon_is_activated('affiliate_system'),
            'pos_system' => addon_is_activated('pos_system'),
        ];

        return business_view('pages.hub', compact('modules'));
    }

    public function wholesaleCatalog()
    {
        if (!addon_is_activated('wholesale')) {
            abort(404);
        }
        $products = BusinessService::wholesaleProducts(12);
        return business_view('pages.wholesale.catalog', compact('products'));
    }
}
