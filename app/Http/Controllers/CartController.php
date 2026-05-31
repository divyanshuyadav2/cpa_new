<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * View the shopping cart page.
     */
    public function view()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['qty'] * $item['price'];
        }

        return view('cart', compact('cart', 'total'));
    }

    /**
     * Add a product to the cart.
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::with('company')->findOrFail($request->input('product_id'));
        $qty = (int)$request->input('quantity');

        // Check stock
        if ($product->stock_qty < $qty) {
            return redirect()->back()->with('error', "Only {$product->stock_qty} units available in stock.");
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $newQty = $cart[$product->id]['qty'] + $qty;
            if ($product->stock_qty < $newQty) {
                return redirect()->back()->with('error', "Cannot add more. Total in cart ({$newQty}) exceeds stock.");
            }
            $cart[$product->id]['qty'] = $newQty;
        } else {
            $cart[$product->id] = [
                'id' => $product->id,
                'name' => $product->name,
                'packing' => $product->packing,
                'composition' => $product->composition,
                'company' => $product->company->name,
                'price' => $product->mrp,
                'qty' => $qty,
                'image' => $product->image,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', "{$product->name} added to cart successfully!");
    }

    /**
     * Update quantity of a cart item.
     */
    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $productId = $request->input('product_id');
        $qty = (int)$request->input('quantity');

        $product = Product::findOrFail($productId);
        if ($product->stock_qty < $qty) {
            return redirect()->back()->with('error', "Only {$product->stock_qty} units available in stock.");
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['qty'] = $qty;
            session()->put('cart', $cart);
            return redirect()->back()->with('success', "Cart updated successfully!");
        }

        return redirect()->back()->with('error', "Product not found in cart.");
    }

    /**
     * Remove a product from the cart.
     */
    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
        ]);

        $productId = $request->input('product_id');
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
            return redirect()->back()->with('success', "Product removed from cart!");
        }

        return redirect()->back()->with('error', "Product not found in cart.");
    }

    /**
     * Handle the checkout and redirect to WhatsApp.
     */
    public function whatsapp(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->back()->with('error', 'Your cart is empty.');
        }

        // Calculate total and verify stock
        $total = 0;
        foreach ($cart as $item) {
            $product = Product::find($item['id']);
            if (!$product || $product->stock_qty < $item['qty']) {
                return redirect()->back()->with('error', "Product {$item['name']} is out of stock or quantity exceeds availability.");
            }
            $total += $item['qty'] * $item['price'];
        }

        // Create Order in Database
        $order = Order::create([
            'customer_name' => $request->input('customer_name'),
            'phone' => $request->input('phone'),
            'total' => $total,
            'status' => 'Pending',
            'cart' => $cart,
        ]);

        // Deduct product stock
        foreach ($cart as $item) {
            $product = Product::find($item['id']);
            if ($product) {
                $product->decrement('stock_qty', $item['qty']);
            }
        }

        // Clear Cart
        session()->forget('cart');

        // Build WhatsApp Message
        $companyName = setting('company_name', 'Chitranshu Pharmaceuticals Agency');
        $tagline = setting('tagline', 'Your Trusted Pharmaceutical Partner');

        $message = "*New Order Placed - {$companyName}*\n";
        $message .= "{$tagline}\n\n";
        $message .= "*Order ID:* #{$order->id}\n";
        $message .= "*Customer:* {$order->customer_name}\n";
        $message .= "*Phone:* {$order->phone}\n";
        $message .= "*Date:* " . $order->created_at->format('d-M-Y h:i A') . "\n\n";
        $message .= "*Items Ordered:*\n";

        $i = 1;
        foreach ($cart as $item) {
            $subtotal = $item['qty'] * $item['price'];
            $message .= "{$i}. *{$item['name']}* ({$item['packing']})\n";
            $message .= "   Comp: {$item['composition']}\n";
            $message .= "   Qty: {$item['qty']} x ₹" . number_format($item['price'], 2) . " = *₹" . number_format($subtotal, 2) . "*\n";
            $i++;
        }

        $message .= "\n*Total Invoice Amount: ₹" . number_format($total, 2) . "*\n\n";
        $message .= "Please confirm receipt of this order. Thank you!";

        // Retrieve WhatsApp Number
        $waNumber = setting('whatsapp_number', '919876543210');
        // Clean non-digits
        $waNumber = preg_replace('/[^0-9]/', '', $waNumber);

        // Build URL redirect
        $url = "https://wa.me/{$waNumber}?text=" . rawurlencode($message);

        return redirect()->away($url);
    }
}
