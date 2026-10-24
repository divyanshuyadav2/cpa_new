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
        ]);

        $email = trim($request->email);
        $password = $request->password;

        $user = null;
        $role = null;

        // 1. Check in User table (Retailer, Salesman, Biller, etc.)
        $foundUser = User::where('email', $email)->first();
        if ($foundUser && Hash::check($password, $foundUser->password)) {
            if (!$foundUser->is_active) {
                return response()->json(['message' => 'Your account is inactive. Please contact admin.'], 403);
            }
            $user = $foundUser;
            $role = $foundUser->role ?? 'retailer';
        }

        // 2. If not found in Users, check in Admins table
        if (!$user) {
            $adminUser = Admin::where('email', $email)->first();
            if ($adminUser && Hash::check($password, $adminUser->password)) {
                $user = $adminUser;
                $role = 'admin';
            }
        }

        if (!$user) {
            return response()->json(['message' => 'Invalid email or password.'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'role' => $role,
            'token' => $token,
        ]);
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
            'phone' => 'required|string|max:20',
            'company_name' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500',
            'role' => 'required|in:retailer,salesman',
            'salesman_id' => 'nullable|exists:users,id',
            'dl_number' => 'required_if:role,retailer|nullable|string|max:100',
            'gst_number' => 'nullable|string|max:50',
        ], [
            'dl_number.required_if' => 'The Drug License (DL) number is required for retailer registration.',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['is_active'] = true;

        $user = User::create($validated);
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Registration successful',
            'user' => $user,
            'role' => $user->role,
            'token' => $token,
        ], 201);
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
