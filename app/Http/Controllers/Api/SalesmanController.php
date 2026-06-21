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
}
