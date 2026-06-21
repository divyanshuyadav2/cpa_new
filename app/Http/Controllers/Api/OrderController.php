<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        
        $orders = Order::where('user_id', $user->id)
                       ->latest()
                       ->paginate(15);
                       
        return response()->json($orders);
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'cart' => 'required|array',
            'total' => 'required|numeric|min:0'
        ]);

        $order = Order::create([
            'user_id' => $request->user()->id,
            'customer_name' => $request->customer_name,
            'phone' => $request->phone,
            'cart' => $request->cart,
            'total' => $request->total,
            'status' => 'Pending'
        ]);

        return response()->json([
            'message' => 'Order placed successfully',
            'order' => $order
        ], 201);
    }

    public function show($id, Request $request)
    {
        $order = Order::where('user_id', $request->user()->id)->findOrFail($id);
        return response()->json($order);
    }
}
