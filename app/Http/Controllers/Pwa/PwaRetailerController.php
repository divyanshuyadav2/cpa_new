<?php

namespace App\Http\Controllers\Pwa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Company;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class PwaRetailerController extends Controller
{
    /**
     * Display Medicine Catalog for Retailers / Counters.
     */
    public function catalog(Request $request)
    {
        $query = Product::where('is_active', true)->with(['company', 'salt']);

        // Filter by Search Query
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('composition', 'like', "%{$search}%")
                  ->orWhere('hsn_code', 'like', "%{$search}%");
            });
        }

        // Filter by Company
        if ($request->filled('company_id')) {
            $query->where('company_id', $request->input('company_id'));
        }

        $products = $query->orderBy('name')->paginate(20);
        $companies = Company::where('is_active', true)->orderBy('name')->get();

        return view('pwa.retailer.catalog', compact('products', 'companies'));
    }

    /**
     * Process Retailer Order Checkout (Direct Ordering without stock lock).
     */
    public function checkout(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'cart' => 'required|array|min:1',
            'cart.*.id' => 'required|integer',
            'cart.*.name' => 'required|string',
            'cart.*.qty' => 'required|integer|min:1',
            'cart.*.price' => 'required|numeric|min:0',
        ]);

        $user = Auth::user();

        // Calculate total
        $total = 0;
        $formattedCart = [];

        foreach ($request->cart as $item) {
            $subtotal = $item['qty'] * $item['price'];
            $total += $subtotal;

            $formattedCart[] = [
                'id' => $item['id'],
                'name' => $item['name'],
                'packing' => $item['packing'] ?? '',
                'unit' => in_array($item['unit'] ?? '', ['Box', 'Strip']) ? $item['unit'] : 'Box',
                'qty' => (int)$item['qty'],
                'price' => (float)$item['price'],
                'subtotal' => $subtotal,
            ];
        }

        if ($user && empty($user->phone) && \Illuminate\Support\Facades\Schema::hasColumn('users', 'phone')) {
            $user->update(['phone' => $request->phone]);
        }

        $order = Order::create([
            'user_id' => $user ? $user->id : null,
            'customer_name' => $request->customer_name,
            'phone' => $request->phone,
            'cart' => $formattedCart,
            'total' => $total,
            'status' => 'Pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Order #' . $order->id . ' placed successfully!',
            'order_id' => $order->id,
            'redirect_url' => route('pwa.retailer.orders'),
        ]);
    }

    /**
     * View Retailer Orders List & Status.
     */
    public function orders(Request $request)
    {
        $user = Auth::user();

        if ($user->role === 'salesman') {
            return redirect()->route('pwa.salesman.dashboard');
        }

        $orders = Order::where('user_id', $user->id)
                       ->latest()
                       ->paginate(15);

        return view('pwa.retailer.orders', compact('orders'));
    }
}
