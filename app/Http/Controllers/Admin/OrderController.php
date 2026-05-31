<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::latest()->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update the status of the order.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:Pending,Confirmed,Dispatched',
        ]);

        $oldStatus = $order->status;
        $order->update(['status' => $request->input('status')]);

        return redirect()->route('orders.show', $order->id)
            ->with('success', "Order status updated from {$oldStatus} to {$order->status}!");
    }

    /**
     * Generate a WhatsApp confirmation link and redirect.
     */
    public function sendConfirmation(Order $order)
    {
        $companyName = setting('company_name', 'Chitranshu Pharmaceuticals Agency');
        
        $message = "Hello *{$order->customer_name}*,\n\n";
        $message .= "Your order *#{$order->id}* with *{$companyName}* has been updated!\n";
        $message .= "*Current Status:* *{$order->status}*\n\n";
        $message .= "*Order Details:*\n";
        
        $i = 1;
        foreach ($order->cart as $item) {
            $subtotal = $item['qty'] * $item['price'];
            $message .= "{$i}. {$item['name']} ({$item['packing']}) x {$item['qty']} = ₹" . number_format($subtotal, 2) . "\n";
            $i++;
        }

        $message .= "\n*Total Amount:* *₹" . number_format($order->total, 2) . "*\n\n";
        
        if ($order->status == 'Confirmed') {
            $message .= "We have confirmed your order and it is currently being packed. We will update you once it is dispatched.";
        } elseif ($order->status == 'Dispatched') {
            $message .= "Great news! Your order has been dispatched and is on its way to you.";
        } else {
            $message .= "Your order is currently pending review. We will contact you shortly.";
        }

        // Sanitize client phone number
        $phone = preg_replace('/[^0-9]/', '', $order->phone);
        // Prepend India country code if 10 digits
        if (strlen($phone) === 10) {
            $phone = '91' . $phone;
        }

        $url = "https://wa.me/{$phone}?text=" . rawurlencode($message);

        return redirect()->away($url);
    }
}
