<?php

namespace App\Services;

use App\Models\DeliveryBoy;
use App\Models\DeliveryBoyCollection;
use App\Models\DeliveryBoyPayment;
use App\Models\DeliveryHistory;
use App\Models\Order;
use App\Models\SmsTemplate;
use App\Models\User;
use App\Utility\SmsUtility;
use Illuminate\Support\Facades\Auth;

class DeliveryService
{
    public static function timelineSteps(): array
    {
        return [
            ['key' => 'assigned', 'label' => translate('Assigned'), 'statuses' => ['pending', 'confirmed']],
            ['key' => 'picked_up', 'label' => translate('Picked Up'), 'statuses' => ['picked_up']],
            ['key' => 'in_transit', 'label' => translate('In Transit'), 'statuses' => ['picked_up']],
            ['key' => 'out_for_delivery', 'label' => translate('Out For Delivery'), 'statuses' => ['on_the_way']],
            ['key' => 'delivered', 'label' => translate('Delivered'), 'statuses' => ['delivered']],
            ['key' => 'failed', 'label' => translate('Failed'), 'statuses' => ['cancelled']],
        ];
    }

    public static function dashboardStats(int $userId): array
    {
        $deliveryBoy = DeliveryBoy::where('user_id', $userId)->first();

        return [
            'assigned' => Order::where('assign_delivery_boy', $userId)
                ->whereIn('delivery_status', ['pending', 'confirmed'])
                ->where('cancel_request', '0')->count(),
            'picked_up' => Order::where('assign_delivery_boy', $userId)
                ->where('delivery_status', 'picked_up')
                ->where('cancel_request', '0')->count(),
            'in_transit' => Order::where('assign_delivery_boy', $userId)
                ->where('delivery_status', 'picked_up')
                ->where('cancel_request', '0')->count(),
            'out_for_delivery' => Order::where('assign_delivery_boy', $userId)
                ->where('delivery_status', 'on_the_way')
                ->where('cancel_request', '0')->count(),
            'delivered' => Order::where('assign_delivery_boy', $userId)
                ->where('delivery_status', 'delivered')->count(),
            'failed' => Order::where('assign_delivery_boy', $userId)
                ->where('delivery_status', 'cancelled')->count(),
            'pending' => get_delivery_boy_total_pending_delivery(),
            'completed' => get_delivery_boy_total_completed_delivery(),
            'cancelled' => get_delivery_boy_total_cancelled_delivery(),
            'total_collection' => $deliveryBoy->total_collection ?? 0,
            'total_earning' => $deliveryBoy->total_earning ?? 0,
            'cod_today' => DeliveryHistory::where('delivery_boy_id', $userId)
                ->where('delivery_status', 'delivered')
                ->where('payment_type', 'cash_on_delivery')
                ->whereDate('created_at', today())
                ->sum('collection'),
        ];
    }

    public static function ordersForBoy(int $userId, string $filter = 'assigned')
    {
        $query = Order::where('assign_delivery_boy', $userId);

        switch ($filter) {
            case 'assigned':
                $query->where(function ($q) {
                    $q->where(function ($inner) {
                        $inner->where('delivery_status', 'pending')->where('cancel_request', '0');
                    })->orWhere(function ($inner) {
                        $inner->where('delivery_status', 'confirmed')->where('cancel_request', '0');
                    });
                });
                break;
            case 'picked_up':
                $query->where('delivery_status', 'picked_up')->where('cancel_request', '0');
                break;
            case 'in_transit':
                $query->where('delivery_status', 'picked_up')->where('cancel_request', '0');
                break;
            case 'on_the_way':
            case 'out_for_delivery':
                $query->where('delivery_status', 'on_the_way')->where('cancel_request', '0');
                break;
            case 'delivered':
            case 'completed':
                $query->where('delivery_status', 'delivered');
                break;
            case 'failed':
            case 'cancelled':
                $query->where('delivery_status', 'cancelled');
                break;
            case 'pending':
                $query->where('delivery_status', '!=', 'delivered')
                    ->where('delivery_status', '!=', 'cancelled')
                    ->where('cancel_request', '0');
                break;
            case 'active_route':
                $query->whereIn('delivery_status', ['pending', 'confirmed', 'picked_up', 'on_the_way'])
                    ->where('cancel_request', '0');
                break;
        }

        return $query->latest('delivery_history_date')->paginate(12);
    }

    public static function codSummary(int $userId): array
    {
        $today = today();
        $yesterday = today()->subDay();

        return [
            'total_collection' => DeliveryBoy::where('user_id', $userId)->value('total_collection') ?? 0,
            'today_collection' => DeliveryHistory::where('delivery_boy_id', $userId)
                ->where('delivery_status', 'delivered')
                ->where('payment_type', 'cash_on_delivery')
                ->whereDate('created_at', $today)
                ->sum('collection'),
            'yesterday_collection' => DeliveryHistory::where('delivery_boy_id', $userId)
                ->where('delivery_status', 'delivered')
                ->where('payment_type', 'cash_on_delivery')
                ->whereDate('created_at', $yesterday)
                ->sum('collection'),
            'cod_orders_today' => DeliveryHistory::where('delivery_boy_id', $userId)
                ->where('delivery_status', 'delivered')
                ->where('payment_type', 'cash_on_delivery')
                ->whereDate('created_at', $today)
                ->count(),
            'recent_collections' => DeliveryHistory::where('delivery_boy_id', $userId)
                ->where('delivery_status', 'delivered')
                ->where('payment_type', 'cash_on_delivery')
                ->with('order')
                ->latest()
                ->take(10)
                ->get(),
        ];
    }

    public static function deliveryHistories(int $userId)
    {
        return DeliveryHistory::where('delivery_boy_id', $userId)
            ->with('order')
            ->latest()
            ->paginate(15);
    }

    public static function storeDeliveryHistory(Order $order, ?int $deliveryBoyId = null): void
    {
        if (!addon_is_activated('delivery_boy')) {
            return;
        }

        $deliveryBoyId = $deliveryBoyId ?? Auth::id();

        $deliveryHistory = DeliveryHistory::where('order_id', $order->id)
            ->where('delivery_status', $order->delivery_status)
            ->first();

        if (!$deliveryHistory) {
            $deliveryHistory = new DeliveryHistory;
            $deliveryHistory->order_id = $order->id;
            $deliveryHistory->delivery_boy_id = $deliveryBoyId;
            $deliveryHistory->delivery_status = $order->delivery_status;
            $deliveryHistory->payment_type = $order->payment_type;
        }

        if ($order->delivery_status == 'delivered') {
            $deliveryBoy = DeliveryBoy::where('user_id', $deliveryBoyId)->first();
            if ($deliveryBoy) {
                if (get_setting('delivery_boy_payment_type') == 'commission') {
                    $commission = (float) get_setting('delivery_boy_commission');
                    $deliveryHistory->earning = $commission;
                    $deliveryBoy->total_earning += $commission;
                }
                if ($order->payment_type == 'cash_on_delivery') {
                    $deliveryHistory->collection = $order->grand_total;
                    $deliveryBoy->total_collection += $order->grand_total;

                    $order->payment_status = 'paid';
                    if ($order->commission_calculated == 0) {
                        calculateCommissionAffilationClubPoint($order);
                        $order->commission_calculated = 1;
                    }
                    $order->save();
                }
                $deliveryBoy->save();
            }
        }

        $order->delivery_history_date = date('Y-m-d H:i:s');
        $order->save();
        $deliveryHistory->save();

        if (addon_is_activated('otp_system') && optional(SmsTemplate::where('identifier', 'delivery_status_change')->first())->status == 1) {
            try {
                $phone = optional(json_decode($order->shipping_address))->phone ?? optional($order->user)->phone;
                if ($phone) {
                    SmsUtility::delivery_status_change($phone, $order);
                }
            } catch (\Exception $e) {
            }
        }
    }

    public static function nextStatus(?string $current): ?string
    {
        $flow = [
            'pending' => 'picked_up',
            'confirmed' => 'picked_up',
            'picked_up' => 'on_the_way',
            'on_the_way' => 'delivered',
        ];

        return $flow[$current] ?? null;
    }
}
