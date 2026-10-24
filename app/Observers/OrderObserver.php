<?php

namespace App\Observers;

use App\Models\Order;
use App\Services\Notification\OrderNotificationService;

class OrderObserver
{
    protected OrderNotificationService $notificationService;

    public function __construct(OrderNotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Handle the Order "created" event.
     */
    public function created(Order $order): void
    {
        $this->notificationService->notifyOrderCreated($order);
    }

    /**
     * Handle the Order "updated" event.
     */
    public function updated(Order $order): void
    {
        if ($order->wasChanged('status')) {
            $oldStatus = $order->getOriginal('status');
            $newStatus = $order->status;
            $this->notificationService->notifyOrderStatusChanged($order, $oldStatus, $newStatus);
        }
    }
}
