<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class UserController extends Controller
{
    /**
     * Display list of Retailers & Salesmen.
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Safely check schema columns
        $hasRoleCol = Schema::hasColumn('users', 'role');
        $hasUserIdCol = Schema::hasColumn('orders', 'user_id');

        if ($hasRoleCol) {
            $query->with(['salesman']);
        }
        if ($hasUserIdCol) {
            $query->withCount('orders');
        }

        if ($hasRoleCol && $request->filled('role') && in_array($request->role, ['retailer', 'salesman'])) {
            $query->where('role', $request->role);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search, $hasRoleCol) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");

                if (Schema::hasColumn('users', 'phone')) {
                    $q->orWhere('phone', 'like', "%{$search}%");
                }
                if (Schema::hasColumn('users', 'company_name')) {
                    $q->orWhere('company_name', 'like', "%{$search}%");
                }
            });
        }

        $users = $query->latest()->paginate(20);

        // Salesmen for dropdown assignment
        $salesmen = collect();
        if ($hasRoleCol) {
            $salesmen = User::where('role', 'salesman')->orderBy('name')->get();
        }

        // Overview Stats
        $stats = [
            'total' => User::count(),
            'retailers' => $hasRoleCol ? User::where('role', 'retailer')->count() : 0,
            'salesmen' => $hasRoleCol ? User::where('role', 'salesman')->count() : 0,
        ];

        return view('admin.users.index', compact('users', 'salesmen', 'stats'));
    }

    /**
     * Display detailed view of a user account.
     */
    public function show(User $user)
    {
        $hasRoleCol = Schema::hasColumn('users', 'role');
        $hasUserIdCol = Schema::hasColumn('orders', 'user_id');

        $relations = [];
        if ($hasRoleCol) $relations[] = 'salesman';
        if ($hasRoleCol) $relations[] = 'retailers';
        if ($hasUserIdCol) $relations['orders'] = fn($q) => $q->latest();

        $user->load($relations);

        $salesmen = collect();
        if ($hasRoleCol) {
            $salesmen = User::where('role', 'salesman')->where('id', '!=', $user->id)->orderBy('name')->get();
        }

        return view('admin.users.show', compact('user', 'salesmen'));
    }

    /**
     * Toggle User Account Status (Active / Inactive).
     */
    public function toggleStatus(User $user)
    {
        if (Schema::hasColumn('users', 'is_active')) {
            $user->is_active = !$user->is_active;
            $user->save();

            $statusText = $user->is_active ? 'activated' : 'deactivated';
            return redirect()->back()->with('success', "User account {$user->name} has been {$statusText}.");
        }

        return redirect()->back()->with('error', 'Status column not found in users table.');
    }

    /**
     * Update User Role or Assigned Salesman.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'role' => 'nullable|in:retailer,salesman',
            'salesman_id' => 'nullable|exists:users,id',
            'company_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        foreach (['role', 'salesman_id', 'company_name', 'phone', 'address'] as $field) {
            if (isset($validated[$field]) && Schema::hasColumn('users', $field)) {
                $user->{$field} = $validated[$field];
            }
        }

        $user->save();

        return redirect()->back()->with('success', "User details for {$user->name} updated successfully.");
    }

    /**
     * Delete User Account.
     */
    public function destroy(User $user)
    {
        $userName = $user->name;
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', "User {$userName} deleted successfully.");
    }
}
