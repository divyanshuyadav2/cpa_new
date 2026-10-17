<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class BillerController extends Controller
{
    /**
     * Orders assigned to the currently logged in biller.
     */
    public function orders(Request $request)
    {
        $user = $request->user();

        $query = Order::with(['user:id,name,email,company_name,phone,address'])
            ->where('biller_id', $user->id)
            ->latest();

        if ($request->filled('billing_status') && $request->billing_status !== 'all') {
            $query->where('billing_status', $request->billing_status);
        }

        $orders = $query->paginate($request->get('per_page', 20));

        $stats = [
            'total_assigned' => Order::where('biller_id', $user->id)->count(),
            'pending_billing' => Order::where('biller_id', $user->id)->where('billing_status', '!=', 'billed')->count(),
            'completed_billing' => Order::where('biller_id', $user->id)->where('billing_status', 'billed')->count(),
        ];

        return response()->json([
            'stats' => $stats,
            'orders' => $orders,
        ]);
    }

    /**
     * Mark an order as billed with invoice number and notes.
     */
    public function updateBilling(Request $request, $id)
    {
        $user = $request->user();

        $request->validate([
            'invoice_no' => 'required|string|max:100',
            'billing_notes' => 'nullable|string|max:500',
            'billing_status' => 'required|in:in_progress,billed',
        ]);

        $order = Order::where('biller_id', $user->id)->findOrFail($id);

        $order->invoice_no = $request->invoice_no;
        $order->billing_notes = $request->billing_notes;
        $order->billing_status = $request->billing_status;

        if ($request->billing_status === 'billed' && $order->status === 'approved') {
            $order->status = 'completed';
        }

        $order->save();

        return response()->json([
            'message' => "Order #{$order->id} billing updated successfully",
            'order' => $order,
        ]);
    }
}
