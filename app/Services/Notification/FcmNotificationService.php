<?php

namespace App\Services\Notification;

use App\Contracts\PushNotificationServiceInterface;
use App\Models\DeviceToken;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FcmNotificationService implements PushNotificationServiceInterface
{
    protected ?string $projectId;
    protected ?string $credentialsPath;
    protected ?string $serverKey;

    public function __construct()
    {
        $this->projectId = config('services.firebase.project_id');
        $this->credentialsPath = config('services.firebase.credentials_path');
        $this->serverKey = config('services.firebase.server_key');
    }

    /**
     * Send push notification to a list of device tokens.
     */
    public function sendNotification(array $tokens, string $title, string $body, array $data = []): array
    {
        $tokens = array_values(array_filter(array_unique($tokens)));
        if (empty($tokens)) {
            return [
                'success_count' => 0,
                'failure_count' => 0,
                'invalid_tokens' => [],
            ];
        }

        // Try HTTP v1 API first (Google recommended)
        $accessToken = $this->getAccessToken();
        if ($accessToken && $this->projectId) {
            return $this->sendViaHttpV1($tokens, $title, $body, $data, $accessToken);
        }

        // Fallback to legacy FCM server key if configured
        if ($this->serverKey) {
            return $this->sendViaLegacyApi($tokens, $title, $body, $data);
        }

        Log::info('[FCM] Notification skipped: Firebase credentials not configured yet.', [
            'tokens_count' => count($tokens),
            'title' => $title,
            'body' => $body,
        ]);

        return [
            'success_count' => 0,
            'failure_count' => count($tokens),
            'invalid_tokens' => [],
        ];
    }

    /**
     * Send push notification to a Firebase topic (e.g. 'admin_orders').
     */
    public function sendToTopic(string $topic, string $title, string $body, array $data = []): bool
    {
        $accessToken = $this->getAccessToken();
        if (!$accessToken || !$this->projectId) {
            if ($this->serverKey) {
                return $this->sendToTopicLegacy($topic, $title, $body, $data);
            }
            Log::info("[FCM] Topic notification skipped for /topics/{$topic}: Firebase not configured.");
            return false;
        }

        $url = "https://fcm.googleapis.com/v1/projects/{$this->projectId}/messages:send";
        $stringData = array_map(fn($v) => is_scalar($v) ? (string)$v : json_encode($v), $data);

        $payload = [
            'message' => [
                'topic' => $topic,
                'notification' => [
                    'title' => $title,
                    'body' => $body,
                ],
                'data' => $stringData,
                'android' => [
                    'priority' => 'HIGH',
                    'ttl' => '86400s',
                    'notification' => [
                        'sound' => 'default',
                        'channel_id' => 'cpa_orders',
                        'notification_priority' => 'PRIORITY_MAX',
                        'icon' => 'ic_launcher',
                        'color' => '#1E40AF',
                        'default_sound' => true,
                        'default_vibrate_timings' => true,
                        'visibility' => 'PUBLIC',
                    ],
                ],
            ],
        ];

        try {
            $response = Http::withToken($accessToken)
                ->timeout(10)
                ->post($url, $payload);

            return $response->successful();
        } catch (\Throwable $e) {
            Log::error('[FCM] Error sending topic message: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send messages via FCM HTTP v1 API.
     */
    protected function sendViaHttpV1(array $tokens, string $title, string $body, array $data, string $accessToken): array
    {
        $url = "https://fcm.googleapis.com/v1/projects/{$this->projectId}/messages:send";
        $stringData = array_map(fn($v) => is_scalar($v) ? (string)$v : json_encode($v), $data);

        $successCount = 0;
        $failureCount = 0;
        $invalidTokens = [];

        foreach ($tokens as $token) {
            $payload = [
                'message' => [
                    'token' => $token,
                    'notification' => [
                        'title' => $title,
                        'body' => $body,
                    ],
                    'data' => $stringData,
                    'android' => [
                        'priority' => 'HIGH',
                        'ttl' => '86400s',
                        'notification' => [
                            'sound' => 'default',
                            'channel_id' => 'cpa_orders',
                            'notification_priority' => 'PRIORITY_MAX',
                            'icon' => 'ic_launcher',
                            'color' => '#1E40AF',
                            'default_sound' => true,
                            'default_vibrate_timings' => true,
                            'visibility' => 'PUBLIC',
                        ],
                    ],
                ],
            ];

            try {
                $response = Http::withToken($accessToken)
                    ->timeout(8)
                    ->post($url, $payload);

                if ($response->successful()) {
                    $successCount++;
                } else {
                    $failureCount++;
                    $resJson = $response->json();
                    $errorCode = $resJson['error']['details'][0]['errorCode'] ?? $resJson['error']['status'] ?? null;
                    if (in_array($errorCode, ['UNREGISTERED', 'INVALID_ARGUMENT', 'NOT_FOUND'], true)) {
                        $invalidTokens[] = $token;
                    }
                }
            } catch (\Throwable $e) {
                $failureCount++;
                Log::warning("[FCM] Single token send failed: " . $e->getMessage());
            }
        }

        // Cleanup invalid / expired tokens if any were detected
        if (!empty($invalidTokens)) {
            $this->pruneInvalidTokens($invalidTokens);
        }

        return [
            'success_count' => $successCount,
            'failure_count' => $failureCount,
            'invalid_tokens' => $invalidTokens,
        ];
    }

    /**
     * Send messages via Legacy FCM endpoint.
     */
    protected function sendViaLegacyApi(array $tokens, string $title, string $body, array $data): array
    {
        $stringData = array_map(fn($v) => is_scalar($v) ? (string)$v : json_encode($v), $data);

        try {
            $response = Http::withHeaders([
                'Authorization' => 'key=' . $this->serverKey,
                'Content-Type' => 'application/json',
            ])->timeout(10)->post('https://fcm.googleapis.com/fcm/send', [
                'registration_ids' => $tokens,
                'notification' => [
                    'title' => $title,
                    'body' => $body,
                    'sound' => 'default',
                    'icon' => 'ic_launcher',
                    'color' => '#1E40AF',
                    'android_channel_id' => 'cpa_orders',
                ],
                'data' => $stringData,
                'priority' => 'high',
            ]);

            if ($response->successful()) {
                $json = $response->json();
                return [
                    'success_count' => $json['success'] ?? count($tokens),
                    'failure_count' => $json['failure'] ?? 0,
                    'invalid_tokens' => [],
                ];
            }
        } catch (\Throwable $e) {
            Log::error('[FCM] Legacy send failed: ' . $e->getMessage());
        }

        return [
            'success_count' => 0,
            'failure_count' => count($tokens),
            'invalid_tokens' => [],
        ];
    }

    protected function sendToTopicLegacy(string $topic, string $title, string $body, array $data): bool
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'key=' . $this->serverKey,
                'Content-Type' => 'application/json',
            ])->timeout(10)->post('https://fcm.googleapis.com/fcm/send', [
                'to' => '/topics/' . $topic,
                'notification' => [
                    'title' => $title,
                    'body' => $body,
                    'sound' => 'default',
                    'icon' => 'ic_launcher',
                    'color' => '#1E40AF',
                ],
                'data' => $data,
                'priority' => 'high',
            ]);

            return $response->successful();
        } catch (\Throwable $e) {
            Log::error('[FCM] Legacy topic send error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get or generate OAuth2 access token for Google Service Account.
     */
    protected function getAccessToken(): ?string
    {
        if (!$this->credentialsPath || !file_exists($this->credentialsPath)) {
            return null;
        }

        return Cache::remember('fcm_google_access_token', 3300, function () {
            return $this->generateAccessTokenFromServiceAccount();
        });
    }

    /**
     * Generate an OAuth2 access token using RS256 signed JWT with OpenSSL.
     */
    protected function generateAccessTokenFromServiceAccount(): ?string
    {
        try {
            $jsonContent = file_get_contents($this->credentialsPath);
            $serviceAccount = json_decode($jsonContent, true);

            if (empty($serviceAccount['client_email']) || empty($serviceAccount['private_key'])) {
                return null;
            }

            if (empty($this->projectId) && !empty($serviceAccount['project_id'])) {
                $this->projectId = $serviceAccount['project_id'];
            }

            $now = time();
            $header = ['alg' => 'RS256', 'typ' => 'JWT'];
            $claim = [
                'iss' => $serviceAccount['client_email'],
                'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
                'aud' => 'https://oauth2.googleapis.com/token',
                'iat' => $now,
                'exp' => $now + 3600,
            ];

            $base64UrlHeader = $this->base64UrlEncode(json_encode($header));
            $base64UrlClaim = $this->base64UrlEncode(json_encode($claim));
            $dataToSign = $base64UrlHeader . '.' . $base64UrlClaim;

            $signature = '';
            $privateKey = openssl_pkey_get_private($serviceAccount['private_key']);
            if (!$privateKey) {
                Log::error('[FCM] Invalid private key in service account JSON.');
                return null;
            }

            openssl_sign($dataToSign, $signature, $privateKey, OPENSSL_ALGO_SHA256);
            $jwt = $dataToSign . '.' . $this->base64UrlEncode($signature);

            $response = Http::asForm()->post('https://oauth2.googleapis.com/token', [
                'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                'assertion' => $jwt,
            ]);

            if ($response->successful()) {
                return $response->json('access_token');
            }

            Log::error('[FCM] Failed to obtain OAuth2 token: ' . $response->body());
            return null;
        } catch (\Throwable $e) {
            Log::error('[FCM] Service account auth error: ' . $e->getMessage());
            return null;
        }
    }

    protected function base64UrlEncode(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    /**
     * Remove unregistered tokens from the database.
     */
    protected function pruneInvalidTokens(array $invalidTokens): void
    {
        try {
            DeviceToken::whereIn('token', $invalidTokens)->delete();
        } catch (\Throwable $e) {
            Log::warning('[FCM] Failed to prune invalid tokens: ' . $e->getMessage());
        }
    }
}
