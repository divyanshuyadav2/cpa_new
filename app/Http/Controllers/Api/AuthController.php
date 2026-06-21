<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Admin;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'type' => 'required|in:admin,user'
        ]);

        if ($request->type === 'admin') {
            $user = Admin::where('email', $request->email)->first();
        } else {
            $user = User::where('email', $request->email)->first();
        }

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        if ($request->type === 'user' && !$user->is_active) {
            return response()->json(['message' => 'Your account is inactive. Please contact admin.'], 403);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'role' => $request->type === 'admin' ? 'admin' : $user->role,
            'token' => $token,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out successfully']);
    }

    public function user(Request $request)
    {
        $user = $request->user();
        
        $role = $user instanceof Admin ? 'admin' : $user->role;
        
        if ($role === 'retailer') {
            $user->load('salesman');
        } elseif ($role === 'salesman') {
            $user->load('retailers');
        }

        return response()->json([
            'user' => $user,
            'role' => $role
        ]);
    }
}
