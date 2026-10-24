<?php

namespace App\Console\Commands;

use App\Contracts\PushNotificationServiceInterface;
use App\Models\DeviceToken;
use App\Services\Notification\FcmNotificationService;
use Illuminate\Console\Command;

class TestFcmNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fcm:test 
                            {--token= : Specific device FCM token to send to}
                            {--topic= : Topic name to send to (e.g. admin_orders)}
                            {--title= : Custom notification title}
                            {--body= : Custom notification body}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test Firebase Cloud Messaging configuration and dispatch test push notifications';

    public function handle(PushNotificationServiceInterface $fcmService): int
    {
        $this->info('=== Firebase Cloud Messaging (FCM) Diagnostic Tool ===');

        if ($fcmService instanceof FcmNotificationService) {
            $path = $fcmService->resolveCredentialsPath();
            if ($path && file_exists($path)) {
                $this->info("✓ Service Account JSON found: {$path} (" . filesize($path) . " bytes)");
                $content = json_decode(@file_get_contents($path), true);
                $this->line("  Project ID in file: " . ($content['project_id'] ?? 'Not found'));
                $this->line("  Client Email: " . ($content['client_email'] ?? 'Not found'));
            } else {
                $this->error("✗ Service Account JSON NOT found!");
                $this->warn("  Expected at: " . storage_path('app/firebase/service-account.json'));
                $this->warn("  Or fallback: " . storage_path('google.json'));
            }
        }

        $tokenCount = 0;
        try {
            $tokenCount = DeviceToken::count();
            $this->info("✓ Registered Device Tokens in Database: {$tokenCount}");
        } catch (\Throwable $e) {
            $this->warn("! Could not query device_tokens table: " . $e->getMessage());
        }

        $specificToken = $this->option('token');
        $specificTopic = $this->option('topic');
        $title = $this->option('title') ?: 'Test Notification';
        $body = $this->option('body') ?: 'FCM test notification from Chitranshu Pharma (' . now()->toDateTimeString() . ')';

        if ($specificTopic) {
            $this->info("Sending test notification to topic: /topics/{$specificTopic}...");
            $success = $fcmService->sendToTopic($specificTopic, $title, $body, ['type' => 'test']);
            if ($success) {
                $this->info("✓ Topic notification successfully dispatched!");
            } else {
                $this->error("✗ Topic notification failed. Check storage/logs/laravel.log for details.");
            }
            return 0;
        }

        $tokensToSend = [];
        if ($specificToken) {
            $tokensToSend = [$specificToken];
        } else {
            try {
                $tokensToSend = DeviceToken::latest()->take(5)->pluck('token')->toArray();
            } catch (\Throwable $e) {
                $tokensToSend = [];
            }
        }

        if (empty($tokensToSend)) {
            $this->warn("No device tokens available to send test. Provide --token=<FCM_TOKEN> or register via mobile app.");
            return 0;
        }

        $this->info("Sending test notification to " . count($tokensToSend) . " device token(s)...");
        $result = $fcmService->sendNotification($tokensToSend, $title, $body, [
            'type' => 'test',
            'timestamp' => (string)now()->timestamp,
        ]);

        $this->line("Results:");
        $this->line("  Success count: " . $result['success_count']);
        $this->line("  Failure count: " . $result['failure_count']);
        if (!empty($result['invalid_tokens'])) {
            $this->warn("  Invalid tokens pruned: " . count($result['invalid_tokens']));
        }

        if ($result['success_count'] > 0) {
            $this->info("✓ Test push notification sent successfully!");
        } else {
            $this->error("✗ Failed to send push notification. Please check laravel.log.");
        }

        return 0;
    }
}
