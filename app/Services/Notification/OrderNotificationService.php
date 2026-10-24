<?php

namespace App\Services\Notification;

use App\Contracts\PushNotificationServiceInterface;
use App\Models\Admin;
use App\Models\DeviceToken;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class OrderNotificationService
{
    protected PushNotificationServiceInterface $pushService;

    public function __construct(PushNotificationServiceInterface $pushService)
    {
        $this->pushService = $pushService;
    }

    /**
     * Notify Admin and Billers when a new order is placed.
     */
    public function notifyOrderCreated(Order $order): void
    {
        try {
            $tokens = $this->getAdminAndBillerTokens();

            $title = "🛒 Naya Order Aaya! (#{$order->id})";
            $customer = $order->customer_name ?: 'Retailer';
            $amount = '₹' . number_format((float)$order->total, 2);
            $body = "{$customer} dwara naya order place kiya gaya. Total: {$amount}";

            $data = [
                'type' => 'new_order',
                'order_id' => (string) $order->id,
                'customer_name' => (string) $order->customer_name,
                'phone' => (string) $order->phone,
                'total' => (string) $order->total,
                'status' => (string) $order->status_label,
                'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
            ];

            // 1. Send to all registered Admin device tokens
            if (!empty($tokens)) {
                $this->pushService->sendNotification($tokens, $title, $body, $data);
            }

            // 2. Also broadcast to admin_orders topic for any subscribed listener
            $this->pushService->sendToTopic('admin_orders', $title, $body, $data);

            // 3. If Retailer is registered with device token, send them a quick confirmation push
            if ($order->user_id) {
                $retailerTokens = $this->getUserTokens($order->user_id, User::class);
                if (!empty($retailerTokens)) {
                    $this->pushService->sendNotification(
                        $retailerTokens,
                        "Order Placed! (#{$order->id})",
                        "Aapka order successfully place ho gaya hai. Abhi review chal raha hai.",
                        $data
                    );
                }
            }
        } catch (\Throwable $e) {
            // Never break order flow on notification failure
            Log::error('[OrderNotificationService] notifyOrderCreated failed: ' . $e->getMessage(), [
                'order_id' => $order->id,
            ]);
        }
    }

    /**
     * Notify Retailer (and Salesman if applicable) when order status changes.
     */
    public function notifyOrderStatusChanged(Order $order, ?string $oldStatus, string $newStatus): void
    {
        try {
            $canonicalOld = Order::canonicalStatus($oldStatus);
            $canonicalNew = Order::canonicalStatus($newStatus);

            if ($canonicalOld === $canonicalNew) {
                return;
            }

            $messages = [
                'Confirmed' => [
                    'title' => "✅ Order Confirmed! (#{$order->id})",
                    'body' => "Aapka order confirm ho gaya hai aur warehouse me pack ho raha hai.",
                ],
                'Dispatched' => [
                    'title' => "🚚 Order Dispatched! (#{$order->id})",
                    'body' => "Aapka order dispatch ho gaya hai aur delivery ke liye nikal chuka hai.",
                ],
                'Delivered' => [
                    'title' => "🎉 Order Delivered! (#{$order->id})",
                    'body' => "Order #{$order->id} successfully deliver ho gaya. Dhanyawad!",
                ],
                'Cancelled' => [
                    'title' => "❌ Order Cancelled (#{$order->id})",
                    'body' => "Order #{$order->id} cancel ho gaya hai. Kripya agency se sampark karein.",
                ],
            ];

            $msg = $messages[$canonicalNew] ?? [
                'title' => "Order Update (#{$order->id})",
                'body' => "Order status badal kar {$canonicalNew} ho gaya hai.",
            ];

            $data = [
                'type' => 'status_update',
                'order_id' => (string) $order->id,
                'old_status' => (string) $canonicalOld,
                'new_status' => (string) $canonicalNew,
                'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
            ];

            // 1. Notify Retailer
            if ($order->user_id) {
                $retailerTokens = $this->getUserTokens($order->user_id, User::class);
                if (!empty($retailerTokens)) {
                    $this->pushService->sendNotification($retailerTokens, $msg['title'], $msg['body'], $data);
                }
            }

            // 2. Notify Salesman when Dispatched
            if ($canonicalNew === 'Dispatched') {
                $salesman = $order->salesman;
                if ($salesman) {
                    $salesmanTokens = $this->getUserTokens($salesman->id, User::class);
                    if (!empty($salesmanTokens)) {
                        $this->pushService->sendNotification(
                            $salesmanTokens,
                            "📦 Delivery Alert (#{$order->id})",
                            "Order for {$order->customer_name} is dispatched for delivery.",
                            $data
                        );
                    }
                }
            }
        } catch (\Throwable $e) {
            Log::error('[OrderNotificationService] notifyOrderStatusChanged failed: ' . $e->getMessage(), [
                'order_id' => $order->id,
            ]);
        }
    }

    /**
     * Get tokens for all Admin users and billers.
     *
     * @return array<string>
     */
    protected function getAdminAndBillerTokens(): array
    {
        $tokens = [];

        try {
            // Tokens from DeviceToken table for Admins
            $adminTokens = DeviceToken::where('tokenable_type', Admin::class)
                ->pluck('token')
                ->all();
            $tokens = array_merge($tokens, $adminTokens);

            // Admins direct fcm_token column (if present)
            $directAdminTokens = Admin::whereNotNull('fcm_token')->pluck('fcm_token')->all();
            $tokens = array_merge($tokens, $directAdminTokens);

            // Users with role 'admin' or 'biller'
            $staffUserIds = User::whereIn('role', ['admin', 'biller'])->pluck('id');
            if ($staffUserIds->isNotEmpty()) {
                $userDeviceTokens = DeviceToken::where('tokenable_type', User::class)
                    ->whereIn('tokenable_id', $staffUserIds)
                    ->pluck('token')
                    ->all();
                $directUserTokens = User::whereIn('id', $staffUserIds)
                    ->whereNotNull('fcm_token')
                    ->pluck('fcm_token')
                    ->all();
                $tokens = array_merge($tokens, $userDeviceTokens, $directUserTokens);
            }
        } catch (\Throwable $e) {
            Log::warning('[OrderNotificationService] Error collecting admin tokens: ' . $e->getMessage());
        }

        return array_values(array_filter(array_unique($tokens)));
    }

    /**
     * Get device tokens for a specific user.
     *
     * @param  int  $userId
     * @param  string  $type
     * @return array<string>
     */
    protected function getUserTokens(int $userId, string $type = User::class): array
    {
        $tokens = [];

        try {
            $deviceTokens = DeviceToken::where('tokenable_type', $type)
                ->where('tokenable_id', $userId)
                ->pluck('token')
                ->all();
            $tokens = array_merge($tokens, $deviceTokens);

            $directToken = $type::where('id', $userId)->value('fcm_token');
            if (!empty($directToken)) {
                $tokens[] = $directToken;
            }
        } catch (\Throwable $e) {
            Log::warning("[OrderNotificationService] Error getting tokens for user {$userId}: " . $e->getMessage());
        }

        return array_values(array_filter(array_unique($tokens)));
    }
}
