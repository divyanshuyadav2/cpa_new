<?php

namespace App\Http\Controllers\Pwa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class PwaAuthController extends Controller
{
    /**
     * Show PWA Login Form.
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role === 'salesman') {
                return redirect()->route('pwa.salesman.dashboard');
            }
            return redirect()->route('pwa.retailer.catalog');
        }
        return view('pwa.login');
    }

    /**
     * Process PWA Login.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return back()->withErrors(['email' => 'Invalid email or password.'])->withInput();
        }

        if (!$user->is_active) {
            return back()->withErrors(['email' => 'Your account is inactive. Please contact admin.'])->withInput();
        }

        Auth::login($user, $request->has('remember'));
        $request->session()->regenerate();

        if ($user->role === 'salesman') {
            return redirect()->route('pwa.salesman.dashboard')->with('success', 'Welcome to Salesman Dashboard!');
        }

        return redirect()->route('pwa.retailer.catalog')->with('success', 'Logged in successfully!');
    }

    /**
     * Show PWA Registration Form.
     */
    public function showRegisterForm()
    {
        if (Auth::check()) {
            return redirect()->route('pwa.retailer.catalog');
        }
        $salesmen = User::where('role', 'salesman')->where('is_active', true)->orderBy('name')->get();
        return view('pwa.register', compact('salesmen'));
    }

    /**
     * Process PWA Registration.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'required|string|max:20',
            'company_name' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500',
            'role' => 'required|in:retailer,salesman',
            'salesman_id' => 'nullable|exists:users,id',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['is_active'] = true; // Active immediately so they can order

        $user = User::create($validated);

        Auth::login($user);
        $request->session()->regenerate();

        if ($user->role === 'salesman') {
            return redirect()->route('pwa.salesman.dashboard')->with('success', 'Registration successful! Welcome Salesman.');
        }

        return redirect()->route('pwa.retailer.catalog')->with('success', 'Registration successful! You can now place medicine orders.');
    }

    /**
     * Process PWA Logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('pwa.login')->with('success', 'Logged out successfully.');
    }
}
