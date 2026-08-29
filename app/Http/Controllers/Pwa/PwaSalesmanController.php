<?php

namespace App\Http\Controllers\Pwa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class PwaSalesmanController extends Controller
{
    /**
     * Salesman Dashboard View.
     */
    public function dashboard(Request $request)
    {
        $salesman = Auth::user();

        if (!isset($salesman->role) || $salesman->role !== 'salesman') {
            return redirect()->route('pwa.retailer.catalog');
        }

        // Get retailers assigned to this salesman
        $retailers = collect();
        if (\Illuminate\Support\Facades\Schema::hasColumn('users', 'role') && \Illuminate\Support\Facades\Schema::hasColumn('users', 'salesman_id')) {
            $retailers = User::where('role', 'retailer')
                             ->where('salesman_id', $salesman->id)
                             ->orderBy('company_name')
                             ->get();
        }

        $retailerIds = $retailers->pluck('id');

        // Filter orders by assigned retailers or search query
        $query = Order::with('user')
                      ->where(function ($q) use ($retailerIds, $salesman) {
                          $q->whereIn('user_id', $retailerIds)
                            ->orWhere('user_id', $salesman->id);
                      });

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('id', $search);
            });
        }

        $orders = $query->latest()->paginate(15);

        // Stats overview
        $totalOrders = Order::whereIn('user_id', $retailerIds)->count();
        $pendingCount = Order::whereIn('user_id', $retailerIds)->where('status', 'Pending')->count();
        $deliveredCount = Order::whereIn('user_id', $retailerIds)->where('status', 'Delivered')->count();

        return view('pwa.salesman.dashboard', compact('retailers', 'orders', 'totalOrders', 'pendingCount', 'deliveredCount'));
    }

    /**
     * Update Order Delivery Status (Pending, Confirmed, Dispatched, Delivered).
     */
    public function updateStatus(Request $request, Order $order)
    {
        $salesman = Auth::user();

        if ($salesman->role !== 'salesman') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'status' => 'required|in:Pending,Confirmed,Dispatched,Delivered',
        ]);

        $oldStatus = $order->status;
        $order->update(['status' => $request->status]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Order #{$order->id} marked as {$request->status}!",
                'order' => $order,
            ]);
        }

        return redirect()->back()->with('success', "Order #{$order->id} status updated to {$request->status}!");
    }
}
