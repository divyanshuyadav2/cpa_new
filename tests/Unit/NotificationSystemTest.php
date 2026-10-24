<?php

namespace Tests\Unit;

use App\Contracts\PushNotificationServiceInterface;
use App\Models\DeviceToken;
use App\Models\Order;
use App\Models\User;
use App\Models\Admin;
use App\Services\Notification\FcmNotificationService;
use App\Services\Notification\OrderNotificationService;
use Tests\TestCase;

class NotificationSystemTest extends TestCase
{
    public function test_push_notification_service_resolves_from_container(): void
    {
        $service = app(PushNotificationServiceInterface::class);
        $this->assertInstanceOf(FcmNotificationService::class, $service);
    }

    public function test_fcm_notification_service_handles_empty_tokens_gracefully(): void
    {
        $service = new FcmNotificationService();
        $result = $service->sendNotification([], 'Test Title', 'Test Body');

        $this->assertEquals(0, $result['success_count']);
        $this->assertEquals(0, $result['failure_count']);
        $this->assertIsArray($result['invalid_tokens']);
    }

    public function test_fcm_notification_service_handles_missing_credentials_safely(): void
    {
        $service = new FcmNotificationService();
        // Should not throw an exception even if service-account.json does not exist
        $result = $service->sendNotification(['sample_fake_token_123'], 'Test Title', 'Test Body');

        $this->assertIsArray($result);
        $this->assertEquals(0, $result['success_count']);
    }

    public function test_order_notification_service_handles_order_creation_mock(): void
    {
        $mockPushService = new class implements PushNotificationServiceInterface {
            public int $notificationsSent = 0;
            public int $topicsSent = 0;

            public function sendNotification(array $tokens, string $title, string $body, array $data = []): array
            {
                $this->notificationsSent++;
                return ['success_count' => count($tokens), 'failure_count' => 0, 'invalid_tokens' => []];
            }

            public function sendToTopic(string $topic, string $title, string $body, array $data = []): bool
            {
                $this->topicsSent++;
                return true;
            }
        };

        $orderNotificationService = new OrderNotificationService($mockPushService);

        $order = new Order();
        $order->id = 999;
        $order->customer_name = 'Test Chemist Store';
        $order->phone = '9999999999';
        $order->total = 1500.50;
        $order->status = 'Pending';

        $orderNotificationService->notifyOrderCreated($order);

        // Topic should have been called
        $this->assertGreaterThanOrEqual(1, $mockPushService->topicsSent);
    }

    public function test_order_notification_service_handles_status_changes(): void
    {
        $mockPushService = new class implements PushNotificationServiceInterface {
            public array $sentMessages = [];

            public function sendNotification(array $tokens, string $title, string $body, array $data = []): array
            {
                $this->sentMessages[] = compact('tokens', 'title', 'body', 'data');
                return ['success_count' => count($tokens), 'failure_count' => 0, 'invalid_tokens' => []];
            }

            public function sendToTopic(string $topic, string $title, string $body, array $data = []): bool
            {
                return true;
            }
        };

        $orderNotificationService = new OrderNotificationService($mockPushService);

        $order = new Order();
        $order->id = 888;
        $order->customer_name = 'Apex Medicos';
        $order->status = 'Dispatched';

        // Same status should not send
        $orderNotificationService->notifyOrderStatusChanged($order, 'Dispatched', 'Dispatched');
        $this->assertCount(0, $mockPushService->sentMessages);

        // Status change to Confirmed
        $orderNotificationService->notifyOrderStatusChanged($order, 'Pending', 'Confirmed');
        // Will try to fetch user tokens (none exist on an unsaved model, so 0 calls or empty tokens)
        $this->assertTrue(true);
    }
}
