<?php

use App\Http\Controllers\AuctionProductController;
use App\Http\Controllers\Business\BusinessHubController;
use Illuminate\Support\Facades\Route;

Route::get('/business', [BusinessHubController::class, 'index'])->name('business.hub');
Route::get('/business/wholesale', [BusinessHubController::class, 'wholesaleCatalog'])->name('business.wholesale');

Route::middleware(['auth'])->group(function () {
    Route::get('/auction/bid-history', [AuctionProductController::class, 'bid_history_user'])->name('auction.bid-history');
    Route::get('/auction/winners', function () {
        if (!addon_is_activated('auction')) {
            abort(404);
        }
        $winners = \App\Services\BusinessService::auctionWinners();
        return business_view('pages.auction.winners-list', compact('winners'));
    })->name('auction.winners');

    Route::get('/loyalty/points', fn () => redirect()->route('earnng_point_for_user'))->name('business.loyalty');
    Route::get('/loyalty/redeem', [\App\Http\Controllers\ClubPointController::class, 'redeem_index'])->name('business.loyalty.redeem');
    Route::get('/affiliate/referrals', [\App\Http\Controllers\AffiliateController::class, 'user_referrals'])->name('affiliate.user.referrals');
    Route::get('/affiliate/commissions', [\App\Http\Controllers\AffiliateController::class, 'user_commissions'])->name('affiliate.user.commissions');
});
