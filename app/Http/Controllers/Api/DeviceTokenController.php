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
}
