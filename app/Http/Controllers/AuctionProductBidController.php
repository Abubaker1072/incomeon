<?php

namespace App\Http\Controllers;

use App\Mail\AuctionBidMailManager;
use App\Models\AuctionProductBid;
use App\Models\Product;
use Auth;
use Illuminate\Http\Request;
use Mail;

class AuctionProductBidController extends Controller
{
    public function index()
    {
        return redirect()->route('auction.bid-history');
    }

    public function create()
    {
        return redirect()->route('auction_products.all');
    }

    public function store(Request $request)
    {
        if (!addon_is_activated('auction')) {
            abort(404);
        }

        $request->validate([
            'product_id' => 'required|integer',
            'amount' => 'required|numeric|min:0.01',
        ]);

        $product = Product::findOrFail($request->product_id);
        $minBid = max(
            (float) ($product->starting_bid ?? 0),
            (float) optional(AuctionProductBid::where('product_id', $product->id)->orderBy('amount', 'desc')->first())->amount ?? 0
        );

        if ($request->amount <= $minBid) {
            flash(translate('Bid must be higher than current highest bid'))->error();
            return back();
        }

        $bid = AuctionProductBid::where('product_id', $request->product_id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$bid) {
            $bid = new AuctionProductBid;
            $bid->user_id = Auth::id();
        }

        $bid->product_id = $request->product_id;
        $bid->amount = $request->amount;
        $bid->save();

        $secondMax = AuctionProductBid::where('product_id', $request->product_id)
            ->orderBy('amount', 'desc')
            ->skip(1)
            ->first();

        if ($secondMax && $secondMax->user && $secondMax->user->email) {
            try {
                Mail::to($secondMax->user->email)->queue(new AuctionBidMailManager([
                    'view' => 'emails.auction_bid',
                    'subject' => translate('Auction Bid'),
                    'from' => env('MAIL_FROM_ADDRESS'),
                    'content' => translate('A new user bid higher than you for') . ' ' . $product->name,
                    'link' => route('auction-product', $product->slug),
                ]));
            } catch (\Exception $e) {
            }
        }

        flash(translate('Bid placed successfully'))->success();
        return back();
    }

    public function show($id)
    {
        return redirect()->route('auction-product', Product::findOrFail($id)->slug);
    }

    public function edit($id)
    {
        return back();
    }

    public function update(Request $request, $id)
    {
        return $this->store($request);
    }

    public function destroy($id)
    {
        AuctionProductBid::destroy($id);
        flash(translate('Bid removed'))->success();
        return back();
    }

    public function product_bids_admin($id)
    {
        $product = Product::findOrFail($id);
        $bids = AuctionProductBid::where('product_id', $id)->orderBy('amount', 'desc')->paginate(20);
        return view('backend.auction.bids', compact('product', 'bids'));
    }

    public function bid_destroy_admin($id)
    {
        AuctionProductBid::destroy($id);
        return back();
    }

    public function product_bids_seller($id)
    {
        return $this->product_bids_admin($id);
    }

    public function bid_destroy_seller($id)
    {
        return $this->bid_destroy_admin($id);
    }
}
