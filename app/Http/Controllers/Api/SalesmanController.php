<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;

class SalesmanController extends Controller
{
    public function retailers(Request $request)
    {
        $salesman = $request->user();

        if ($salesman->role !== 'salesman') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $retailers = User::where('role', 'retailer')
                         ->where('salesman_id', $salesman->id)
                         ->get();

        return response()->json($retailers);
    }

    public function orders(Request $request)
    {
        $salesman = $request->user();

        if ($salesman->role !== 'salesman') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Get all retailer IDs assigned to this salesman
        $retailerIds = User::where('role', 'retailer')
                           ->where('salesman_id', $salesman->id)
                           ->pluck('id');

        // Get orders from those retailers
        $orders = Order::with('user')
                       ->whereIn('user_id', $retailerIds)
                       ->latest()
                       ->paginate(15);

        return response()->json($orders);
    }

    public function updateStatus(Request $request, $id)
    {
        $salesman = $request->user();

        if ($salesman->role !== 'salesman') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'status' => 'required|in:Pending,Confirmed,Dispatched,Delivered',
        ]);

        $order = Order::findOrFail($id);
        $oldStatus = $order->status;
        $order->update(['status' => $request->status]);

        return response()->json([
            'message' => "Order #{$order->id} status updated from {$oldStatus} to {$order->status}",
            'order' => $order,
        ]);
    }
}
