<?php

namespace App\Http\Controllers;

use App\Models\AffiliateConfig;
use App\Models\AffiliateLog;
use App\Models\AffiliateOption;
use App\Models\AffiliatePayment;
use App\Models\AffiliateStats;
use App\Models\AffiliateUser;
use App\Models\AffiliateWithdrawRequest;
use App\Models\Order;
use App\Models\User;
use App\Services\BusinessService;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AffiliateController extends Controller
{
    public function processAffiliateStats($affiliate_user_id, $no_of_click = 0, $no_of_order_item = 0, $no_of_delivered = 0, $no_of_cancel = 0)
    {
        if (!addon_is_activated('affiliate_system')) {
            return;
        }

        $stats = AffiliateStats::firstOrNew(['affiliate_user_id' => $affiliate_user_id]);
        $stats->no_of_click = ($stats->no_of_click ?? 0) + $no_of_click;
        $stats->no_of_order_item = ($stats->no_of_order_item ?? 0) + $no_of_order_item;
        $stats->no_of_delivered = ($stats->no_of_delivered ?? 0) + $no_of_delivered;
        $stats->no_of_cancel = ($stats->no_of_cancel ?? 0) + $no_of_cancel;
        $stats->save();
    }

    public function processAffiliatePoints(Order $order)
    {
        if (!addon_is_activated('affiliate_system')) {
            return;
        }

        foreach ($order->orderDetails as $detail) {
            if (!$detail->product_referral_code) {
                continue;
            }

            $referrer = User::where('referral_code', $detail->product_referral_code)->first();
            if (!$referrer || !$referrer->affiliate_user) {
                continue;
            }

            $option = AffiliateOption::where('type', 'product_sharing')->first();
            $amount = $option ? ($detail->price * $detail->quantity * ($option->percentage / 100)) : 0;

            $log = new AffiliateLog;
            $log->user_id = $order->user_id;
            $log->referred_by_user = $referrer->id;
            $log->order_id = $order->id;
            $log->order_detail_id = $detail->id;
            $log->amount = $amount;
            $log->save();

            $referrer->affiliate_user->balance += $amount;
            $referrer->affiliate_user->save();
        }
    }

    /* Customer */

    public function user_index()
    {
        if (!addon_is_activated('affiliate_system')) {
            abort(404);
        }
        $stats = BusinessService::affiliateStats();
        $affiliate_user = Auth::user()->affiliate_user;

        return business_view('pages.affiliate.dashboard', compact('stats', 'affiliate_user'));
    }

    public function user_referrals()
    {
        $logs = AffiliateLog::where('referred_by_user', Auth::id())->latest()->paginate(15);
        return business_view('pages.affiliate.referrals', compact('logs'));
    }

    public function user_commissions()
    {
        $logs = AffiliateLog::where('referred_by_user', Auth::id())->latest()->paginate(15);
        $total = $logs->sum('amount');
        return business_view('pages.affiliate.commissions', compact('logs', 'total'));
    }

    public function user_payment_history()
    {
        $payments = AffiliatePayment::where('user_id', Auth::id())->latest()->paginate(15);
        return business_view('pages.affiliate.payment-history', compact('payments'));
    }

    public function user_withdraw_request_history()
    {
        $requests = AffiliateWithdrawRequest::where('user_id', Auth::id())->latest()->paginate(15);
        return business_view('pages.affiliate.withdraw-history', compact('requests'));
    }

    public function payment_settings()
    {
        return business_view('pages.affiliate.payment-settings', [
            'affiliate_user' => Auth::user()->affiliate_user,
        ]);
    }

    public function payment_settings_store(Request $request)
    {
        $au = Auth::user()->affiliate_user;
        if ($au) {
            $au->paypal_email = $request->paypal_email;
            $au->bank_information = $request->bank_information;
            $au->save();
        }
        flash(translate('Payment settings saved'))->success();
        return back();
    }

    public function withdraw_request_store(Request $request)
    {
        $req = new AffiliateWithdrawRequest;
        $req->user_id = Auth::id();
        $req->amount = $request->amount;
        $req->status = 0;
        $req->save();
        flash(translate('Withdraw request submitted'))->success();
        return back();
    }

    public function apply_for_affiliate()
    {
        return business_view('pages.affiliate.apply');
    }

    public function store_affiliate_user(Request $request)
    {
        if (AffiliateUser::where('user_id', Auth::id())->exists()) {
            return redirect()->route('affiliate.user.index');
        }
        $au = new AffiliateUser;
        $au->user_id = Auth::id();
        $au->status = 0;
        $au->save();
        flash(translate('Application submitted'))->success();
        return redirect()->route('affiliate.user.index');
    }

    /* Admin stubs */

    public function index()
    {
        return view('backend.affiliate.index');
    }

    public function affiliate_option_store(Request $request)
    {
        flash(translate('Saved'))->success();
        return back();
    }

    public function configs()
    {
        return view('backend.affiliate.configs', ['configs' => AffiliateConfig::all()]);
    }

    public function config_store(Request $request)
    {
        flash(translate('Saved'))->success();
        return back();
    }

    public function users()
    {
        return view('backend.affiliate.users', ['users' => AffiliateUser::with('user')->paginate(20)]);
    }

    public function show_verification_request($id)
    {
        return view('backend.affiliate.verify', ['user' => AffiliateUser::findOrFail($id)]);
    }

    public function approve_user($id)
    {
        $u = AffiliateUser::findOrFail($id);
        $u->status = 1;
        $u->save();
        return back();
    }

    public function reject_user($id)
    {
        AffiliateUser::destroy($id);
        return back();
    }

    public function updateApproved(Request $request)
    {
        return back();
    }

    public function payment_modal(Request $request)
    {
        return view('backend.affiliate.payment_modal');
    }

    public function payment_store(Request $request)
    {
        flash(translate('Payment recorded'))->success();
        return back();
    }

    public function payment_history($id)
    {
        return view('backend.affiliate.payment_history');
    }

    public function refferal_users()
    {
        return view('backend.affiliate.referrals');
    }

    public function affiliate_withdraw_requests()
    {
        return view('backend.affiliate.withdraw_requests', [
            'requests' => AffiliateWithdrawRequest::latest()->paginate(20),
        ]);
    }

    public function affiliate_withdraw_modal(Request $request)
    {
        return view('backend.affiliate.withdraw_modal');
    }

    public function withdraw_request_payment_store(Request $request)
    {
        flash(translate('Processed'))->success();
        return back();
    }

    public function reject_withdraw_request($id)
    {
        AffiliateWithdrawRequest::destroy($id);
        return back();
    }

    public function affiliate_logs_admin()
    {
        return view('backend.affiliate.logs', ['logs' => AffiliateLog::latest()->paginate(30)]);
    }
}
