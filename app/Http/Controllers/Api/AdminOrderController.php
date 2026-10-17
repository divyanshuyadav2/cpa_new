<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\Admin;

class AdminOrderController extends Controller
{
    /**
     * Check if user is an Admin.
     */
    protected function authorizeAdmin(Request $request)
    {
        $user = $request->user();
        if (!$user || !($user instanceof Admin || (isset($user->role) && $user->role === 'admin'))) {
            abort(403, 'Unauthorized. Admin access required.');
        }
    }

    /**
     * List all orders for Admin with stats, search & status filters.
     */
    public function orders(Request $request)
    {
        $this->authorizeAdmin($request);

        $query = Order::with(['user:id,name,email,company_name,phone,address', 'biller:id,name,email,phone'])
            ->latest();

        // Status Filter
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Billing Status Filter
        if ($request->filled('billing_status') && $request->billing_status !== 'all') {
            $query->where('billing_status', $request->billing_status);
        }

        // Assigned Biller Filter
        if ($request->filled('biller_id')) {
            if ($request->biller_id === 'unassigned') {
                $query->whereNull('biller_id');
            } else {
                $query->where('biller_id', $request->biller_id);
            }
        }

        // Search
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('invoice_no', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%")
                         ->orWhere('company_name', 'like', "%{$search}%");
                  });
            });
        }

        // Summary Stats
        $stats = [
            'total' => Order::count(),
            'pending' => Order::where('status', 'pending')->count(),
            'approved' => Order::where('status', 'approved')->count(),
            'completed' => Order::where('status', 'completed')->count(),
            'unassigned_billing' => Order::whereNull('biller_id')->where('status', '!=', 'cancelled')->count(),
            'billed' => Order::where('billing_status', 'billed')->count(),
        ];

        $orders = $query->paginate($request->get('per_page', 20));

        return response()->json([
            'stats' => $stats,
            'orders' => $orders,
        ]);
    }

    /**
     * Assign order to a biller / employee.
     */
    public function assignBiller(Request $request, $id)
    {
        $this->authorizeAdmin($request);

        $request->validate([
            'biller_id' => 'nullable|exists:users,id',
        ]);

        $order = Order::with(['user', 'biller'])->findOrFail($id);
        $order->biller_id = $request->biller_id;

        if ($request->biller_id && $order->billing_status === 'pending') {
            $order->billing_status = 'in_progress';
        } elseif (!$request->biller_id) {
            $order->billing_status = 'pending';
        }

        $order->save();
        $order->load('biller');

        return response()->json([
            'message' => $order->biller ? "Order assigned to {$order->biller->name} for billing" : "Order assignment cleared",
            'order' => $order,
        ]);
    }

    /**
     * Update order status (Approve, Complete, Cancel).
     */
    public function updateStatus(Request $request, $id)
    {
        $this->authorizeAdmin($request);

        $request->validate([
            'status' => 'required|in:pending,approved,processing,completed,cancelled',
        ]);

        $order = Order::with(['user', 'biller'])->findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return response()->json([
            'message' => "Order #{$order->id} status updated to {$order->status}",
            'order' => $order,
        ]);
    }

    /**
     * List all billing employees / billers for assignment dropdown.
     */
    public function billers(Request $request)
    {
        $this->authorizeAdmin($request);

        // Get users with role 'biller' or 'salesman'
        $billers = User::whereIn('role', ['biller', 'salesman'])
            ->where('is_active', true)
            ->select('id', 'name', 'email', 'phone', 'role')
            ->orderBy('name')
            ->get();

        return response()->json([
            'billers' => $billers,
        ]);
    }

    /**
     * Create a new billing employee account from admin.
     */
    public function createBiller(Request $request)
    {
        $this->authorizeAdmin($request);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
            'phone' => 'required|string|max:20',
        ]);

        $biller = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'phone' => $validated['phone'],
            'role' => 'biller',
            'is_active' => true,
        ]);

        return response()->json([
            'message' => "Billing operator {$biller->name} created successfully",
            'biller' => $biller,
        ], 201);
    }
}
