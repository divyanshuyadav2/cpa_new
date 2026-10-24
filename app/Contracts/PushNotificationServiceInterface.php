<?php

namespace App\Contracts;

interface PushNotificationServiceInterface
{
    /**
     * Send a push notification to one or more device tokens.
     *
     * @param  array<string>  $tokens
     * @param  string  $title
     * @param  string  $body
     * @param  array<string, mixed>  $data
     * @return array{success_count: int, failure_count: int, invalid_tokens: array<string>}
     */
    public function sendNotification(array $tokens, string $title, string $body, array $data = []): array;

    /**
     * Send a push notification to a specific topic (e.g., 'admin_orders').
     *
     * @param  string  $topic
     * @param  string  $title
     * @param  string  $body
     * @param  array<string, mixed>  $data
     * @return bool
     */
    public function sendToTopic(string $topic, string $title, string $body, array $data = []): bool;
}
