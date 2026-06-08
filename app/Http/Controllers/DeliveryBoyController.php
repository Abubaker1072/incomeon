<?php

namespace App\Http\Controllers;

use App\Models\DeliveryBoy;
use App\Models\DeliveryBoyCollection;
use App\Models\DeliveryBoyPayment;
use App\Models\DeliveryHistory;
use App\Models\Order;
use App\Models\User;
use App\Services\DeliveryService;
use App\Models\Upload;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class DeliveryBoyController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:view_all_delivery_boy'])->only('index');
        $this->middleware(['permission:add_delivery_boy'])->only(['create', 'store']);
        $this->middleware(['permission:view_all_delivery_boy'])->only(['edit', 'update']);
        $this->middleware(['permission:view_all_delivery_boy'])->only('destroy');
    }

    /* ── Admin: Delivery Boy CRUD ─────────────────────────────── */

    public function index()
    {
        $delivery_boys = DeliveryBoy::with('user')->paginate(15);
        return view('backend.delivery_boys.index', compact('delivery_boys'));
    }

    public function create()
    {
        return view('backend.delivery_boys.create');
    }

    public function store(Request $request)
    {
        if (User::where('email', $request->email)->exists()) {
            flash(translate('Email already exists'))->error();
            return back();
        }

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->city = $request->city;
        $user->user_type = 'delivery_boy';
        $user->password = Hash::make($request->password);
        $user->email_verified_at = date('Y-m-d H:i:s');

        if ($user->save()) {
            $deliveryBoy = new DeliveryBoy;
            $deliveryBoy->user_id = $user->id;
            $deliveryBoy->save();
            flash(translate('Delivery boy has been created successfully'))->success();
            return redirect()->route('delivery-boys.index');
        }

        flash(translate('Something went wrong'))->error();
        return back();
    }

    public function show($id)
    {
        return redirect()->route('delivery-boys.edit', $id);
    }

    public function edit($id)
    {
        $delivery_boy = DeliveryBoy::findOrFail($id);
        return view('backend.delivery_boys.edit', compact('delivery_boy'));
    }

    public function update(Request $request, $id)
    {
        $delivery_boy = DeliveryBoy::findOrFail($id);
        $user = $delivery_boy->user;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->city = $request->city;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();
        flash(translate('Delivery boy has been updated successfully'))->success();
        return redirect()->route('delivery-boys.index');
    }

    public function destroy($id)
    {
        $delivery_boy = DeliveryBoy::findOrFail($id);
        $user = $delivery_boy->user;
        DeliveryHistory::where('delivery_boy_id', $user->id)->delete();
        $delivery_boy->delete();
        $user->delete();
        flash(translate('Delivery boy has been deleted successfully'))->success();
        return redirect()->route('delivery-boys.index');
    }

    public function ban($id)
    {
        $user = User::findOrFail($id);
        $user->banned = $user->banned ? 0 : 1;
        $user->save();
        flash(translate('Updated successfully'))->success();
        return back();
    }

    public function delivery_boy_configure()
    {
        return view('backend.delivery_boys.configuration');
    }

    public function order_collection_form(Request $request)
    {
        $delivery_boy = DeliveryBoy::where('user_id', $request->delivery_boy_id)->firstOrFail();
        return view('backend.delivery_boys.collection_form', compact('delivery_boy'));
    }

    public function collection_from_delivery_boy(Request $request)
    {
        $delivery_boy = DeliveryBoy::where('user_id', $request->delivery_boy_id)->firstOrFail();
        $amount = (float) $request->amount;

        if ($amount > $delivery_boy->total_collection) {
            flash(translate('Collection amount exceeds available balance'))->error();
            return back();
        }

        $collection = new DeliveryBoyCollection;
        $collection->user_id = $delivery_boy->user_id;
        $collection->collection_amount = $amount;
        $collection->save();

        $delivery_boy->total_collection -= $amount;
        $delivery_boy->save();

        flash(translate('Collection recorded successfully'))->success();
        return redirect()->route('delivery-boys-collection-histories');
    }

    public function delivery_earning_form(Request $request)
    {
        $delivery_boy = DeliveryBoy::where('user_id', $request->delivery_boy_id)->firstOrFail();
        return view('backend.delivery_boys.earning_form', compact('delivery_boy'));
    }

    public function paid_to_delivery_boy(Request $request)
    {
        $delivery_boy = DeliveryBoy::where('user_id', $request->delivery_boy_id)->firstOrFail();
        $amount = (float) $request->amount;

        if ($amount > $delivery_boy->total_earning) {
            flash(translate('Payment amount exceeds available earnings'))->error();
            return back();
        }

        $payment = new DeliveryBoyPayment;
        $payment->user_id = $delivery_boy->user_id;
        $payment->paid_amount = $amount;
        $payment->save();

        $delivery_boy->total_earning -= $amount;
        $delivery_boy->save();

        flash(translate('Payment recorded successfully'))->success();
        return redirect()->route('delivery-boys-payment-histories');
    }

    public function delivery_boys_payment_histories()
    {
        $payments = DeliveryBoyPayment::with('user')->latest()->paginate(15);
        return view('backend.delivery_boys.payment_histories', compact('payments'));
    }

    public function delivery_boys_collection_histories()
    {
        $collections = DeliveryBoyCollection::with('user')->latest()->paginate(15);
        return view('backend.delivery_boys.collection_histories', compact('collections'));
    }

    public function cancel_request_list()
    {
        $orders = Order::where('cancel_request', 1)->latest('cancel_request_at')->paginate(15);
        return view('backend.delivery_boys.cancel_requests', compact('orders'));
    }

    /* ── Delivery Boy Portal ──────────────────────────────────── */

    public function dashboard()
    {
        $this->ensureDeliveryBoy();
        $stats = DeliveryService::dashboardStats(Auth::id());
        $recent_orders = DeliveryService::ordersForBoy(Auth::id(), 'pending');
        $recent_orders = $recent_orders->setCollection($recent_orders->getCollection()->take(5));

        return delivery_view('pages.dashboard', compact('stats', 'recent_orders'));
    }

    public function assigned_delivery()
    {
        $this->ensureDeliveryBoy();
        $orders = DeliveryService::ordersForBoy(Auth::id(), 'assigned');
        $page_title = translate('Assigned Deliveries');
        $status_filter = 'assigned';

        return delivery_view('pages.deliveries', compact('orders', 'page_title', 'status_filter'));
    }

    public function pickup_delivery()
    {
        $this->ensureDeliveryBoy();
        $orders = DeliveryService::ordersForBoy(Auth::id(), 'picked_up');
        $page_title = translate('Picked Up');
        $status_filter = 'picked_up';

        return delivery_view('pages.deliveries', compact('orders', 'page_title', 'status_filter'));
    }

    public function on_the_way_deliveries()
    {
        $this->ensureDeliveryBoy();
        $orders = DeliveryService::ordersForBoy(Auth::id(), 'on_the_way');
        $page_title = translate('Out For Delivery');
        $status_filter = 'on_the_way';

        return delivery_view('pages.deliveries', compact('orders', 'page_title', 'status_filter'));
    }

    public function completed_delivery()
    {
        $this->ensureDeliveryBoy();
        $orders = DeliveryService::ordersForBoy(Auth::id(), 'delivered');
        $page_title = translate('Delivered');
        $status_filter = 'delivered';

        return delivery_view('pages.deliveries', compact('orders', 'page_title', 'status_filter'));
    }

    public function pending_delivery()
    {
        $this->ensureDeliveryBoy();
        $orders = DeliveryService::ordersForBoy(Auth::id(), 'pending');
        $page_title = translate('Active Deliveries');
        $status_filter = 'pending';

        return delivery_view('pages.deliveries', compact('orders', 'page_title', 'status_filter'));
    }

    public function cancelled_delivery()
    {
        $this->ensureDeliveryBoy();
        $orders = DeliveryService::ordersForBoy(Auth::id(), 'cancelled');
        $page_title = translate('Failed Deliveries');
        $status_filter = 'cancelled';

        return delivery_view('pages.deliveries', compact('orders', 'page_title', 'status_filter'));
    }

    public function route_info()
    {
        $this->ensureDeliveryBoy();
        $orders = DeliveryService::ordersForBoy(Auth::id(), 'active_route');
        $pickup_lat = get_setting('delivery_pickup_latitude');
        $pickup_lng = get_setting('delivery_pickup_longitude');

        return delivery_view('pages.route-info', compact('orders', 'pickup_lat', 'pickup_lng'));
    }

    public function cod_collection()
    {
        $this->ensureDeliveryBoy();
        $cod = DeliveryService::codSummary(Auth::id());

        return delivery_view('pages.cod-collection', compact('cod'));
    }

    public function delivery_history()
    {
        $this->ensureDeliveryBoy();
        $histories = DeliveryService::deliveryHistories(Auth::id());

        return delivery_view('pages.history', compact('histories'));
    }

    public function total_collection()
    {
        return $this->cod_collection();
    }

    public function total_earning()
    {
        $this->ensureDeliveryBoy();
        $earnings = DeliveryHistory::where('delivery_boy_id', Auth::id())
            ->where('delivery_status', 'delivered')
            ->with('order')
            ->latest()
            ->paginate(15);
        $total_earning = get_delivery_boy_info()->total_earning ?? 0;

        return delivery_view('pages.earnings', compact('earnings', 'total_earning'));
    }

    public function order_detail($id)
    {
        $this->ensureDeliveryBoy();
        $order = Order::where('id', $id)
            ->where('assign_delivery_boy', Auth::id())
            ->with('orderDetails.product')
            ->firstOrFail();
        $histories = DeliveryHistory::where('order_id', $order->id)->orderBy('created_at')->get();
        $next_status = DeliveryService::nextStatus($order->delivery_status);

        return delivery_view('pages.orders.show', compact('order', 'histories', 'next_status'));
    }

    public function verification($id)
    {
        $this->ensureDeliveryBoy();
        $order = Order::where('id', $id)
            ->where('assign_delivery_boy', Auth::id())
            ->with('orderDetails.product')
            ->firstOrFail();
        $histories = DeliveryHistory::where('order_id', $order->id)->orderBy('created_at')->get();

        return delivery_view('pages.verification', compact('order', 'histories'));
    }

    public function upload_proof(Request $request)
    {
        $this->ensureDeliveryBoy();
        $request->validate([
            'order_id' => 'required|integer',
            'proof_image' => 'required|image|max:5120',
        ]);

        $order = Order::where('id', $request->order_id)
            ->where('assign_delivery_boy', Auth::id())
            ->firstOrFail();

        $upload = new Upload;
        $upload->file_original_name = $request->file('proof_image')->getClientOriginalName();
        $upload->file_name = $request->file('proof_image')->store('uploads/all', 'local');
        $upload->user_id = Auth::id();
        $upload->extension = $request->file('proof_image')->getClientOriginalExtension();
        $upload->type = 'image';
        $upload->file_size = $request->file('proof_image')->getSize();
        $upload->save();

        if (Schema::hasColumn('delivery_histories', 'proof_image')) {
            $history = DeliveryHistory::where('order_id', $order->id)
                ->where('delivery_status', $order->delivery_status)
                ->latest()
                ->first();

            if (!$history) {
                $history = new DeliveryHistory;
                $history->order_id = $order->id;
                $history->delivery_boy_id = Auth::id();
                $history->delivery_status = $order->delivery_status;
                $history->payment_type = $order->payment_type;
            }

            $history->proof_image = $upload->id;
            $history->save();
        }

        flash(translate('Delivery proof uploaded successfully'))->success();
        return redirect()->route('delivery-boy.order-detail', $order->id);
    }

    public function cancel_request($id)
    {
        $this->ensureDeliveryBoy();
        $order = Order::where('id', $id)
            ->where('assign_delivery_boy', Auth::id())
            ->firstOrFail();
        $order->cancel_request = 1;
        $order->cancel_request_at = date('Y-m-d H:i:s');
        $order->save();

        flash(translate('Cancellation request submitted'))->success();
        return back();
    }

    public function delivery_boys_cancel_request_list()
    {
        $this->ensureDeliveryBoy();
        $orders = Order::where('assign_delivery_boy', Auth::id())
            ->where('cancel_request', 1)
            ->latest('cancel_request_at')
            ->paginate(15);

        return delivery_view('pages.cancel-requests', compact('orders'));
    }

    public function profile()
    {
        $this->ensureDeliveryBoy();
        $delivery_boy = get_delivery_boy_info();

        return delivery_view('pages.profile', compact('delivery_boy'));
    }

    /* ── Shared ───────────────────────────────────────────────── */

    public function store_delivery_history(Order $order)
    {
        DeliveryService::storeDeliveryHistory($order, Auth::id());
    }

    protected function ensureDeliveryBoy(): void
    {
        if (!addon_is_activated('delivery_boy')) {
            abort(404);
        }
        if (Auth::user()->user_type !== 'delivery_boy') {
            abort(403);
        }
    }
}
