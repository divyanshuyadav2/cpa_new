<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DeviceToken;
use Illuminate\Http\Request;

class DeviceTokenController extends Controller
{
    /**
     * Store or update a device FCM token for the authenticated user/admin.
     */
    public function store(Request $request)
    {
        $request->validate([
            'token' => 'required|string|max:1000',
            'platform' => 'nullable|string|in:android,ios,web',
        ]);

        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $token = trim($request->token);
        $platform = $request->platform ?? 'android';

        // Save polymorphic device token
        DeviceToken::updateOrCreate(
            [
                'tokenable_type' => get_class($user),
                'tokenable_id' => $user->id,
                'token' => $token,
            ],
            [
                'platform' => $platform,
                'updated_at' => now(),
            ]
        );

        // Shortcut directly on model if column exists
        try {
            $user->fcm_token = $token;
            $user->save();
        } catch (\Throwable $e) {
            // Ignore if column not yet migrated
        }

        return response()->json([
            'message' => 'Device token registered successfully',
        ]);
    }

    /**
     * Remove a device FCM token upon logout.
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
        ]);

        $user = $request->user();
        if ($user) {
            DeviceToken::where('tokenable_type', get_class($user))
                ->where('tokenable_id', $user->id)
                ->where('token', $request->token)
                ->delete();

            try {
                if ($user->fcm_token === $request->token) {
                    $user->fcm_token = null;
                    $user->save();
                }
            } catch (\Throwable $e) {
                // Ignore
            }
        }

        return response()->json([
            'message' => 'Device token removed successfully',
        ]);
    }

    /**
     * Send a test push notification to the authenticated user's registered devices.
     */
    public function sendTestNotification(Request $request, \App\Contracts\PushNotificationServiceInterface $pushService)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $tokens = [];
        try {
            $tokens = DeviceToken::where('tokenable_type', get_class($user))
                ->where('tokenable_id', $user->id)
                ->pluck('token')
                ->toArray();
        } catch (\Throwable $e) {
            // Ignore DB issues
        }

        if (empty($tokens) && !empty($user->fcm_token)) {
            $tokens[] = $user->fcm_token;
        }

        if (empty($tokens)) {
            return response()->json([
                'success' => false,
                'message' => 'No FCM device tokens registered for this user yet. Please re-open the app or log in again.',
            ], 404);
        }

        $result = $pushService->sendNotification(
            $tokens,
            '🔔 Chitranshu Pharma Test',
            'Hello ' . ($user->name ?? 'User') . '! Push notifications are working perfectly on your device.',
            ['type' => 'test_notification', 'timestamp' => (string)now()->timestamp]
        );

        return response()->json([
            'success' => $result['success_count'] > 0,
            'result' => $result,
            'message' => $result['success_count'] > 0
                ? 'Test notification dispatched successfully!'
                : 'Failed to send notification. Please verify Firebase credentials on server.',
        ]);
    }
}

