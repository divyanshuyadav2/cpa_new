<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Product;

class CatalogController extends Controller
{
    public function companies()
    {
        $companies = Company::where('is_active', true)->orderBy('name')->get();
        
        // Map over companies to include full media_url
        $companies->transform(function ($company) {
            $company->logo_url = media_url($company->logo);
            return $company;
        });

        return response()->json($companies);
    }

    public function products(Request $request)
    {
        $query = Product::with(['company', 'division', 'salt'])
                        ->where('is_active', true);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('composition', 'like', "%{$search}%");
            });
        }

        if ($request->filled('company_id')) {
            $query->where('company_id', $request->company_id);
        }

        if ($request->filled('division_id')) {
            $query->where('division_id', $request->division_id);
        }

        $products = $query->paginate(20);

        // Append image URLs
        $products->getCollection()->transform(function ($product) {
            $product->image_full_url = media_url($product->image);
            return $product;
        });

        return response()->json($products);
    }

    public function product($id)
    {
        $product = Product::with(['company', 'division', 'salt'])->findOrFail($id);
        $product->image_full_url = media_url($product->image);

        return response()->json($product);
    }

    public function frequentProducts(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json([]);
        }

        // Fetch past orders belonging to this user
        $orders = \App\Models\Order::where('user_id', $user->id)
            ->whereNotNull('cart')
            ->select('cart')
            ->latest()
            ->take(30)
            ->get();

        $productCounts = [];
        foreach ($orders as $order) {
            $cart = is_array($order->cart) ? $order->cart : json_decode($order->cart, true);
            if (is_array($cart)) {
                foreach ($cart as $item) {
                    $pId = $item['product_id'] ?? $item['id'] ?? null;
                    if ($pId) {
                        $productCounts[$pId] = ($productCounts[$pId] ?? 0) + ($item['qty'] ?? $item['quantity'] ?? 1);
                    }
                }
            }
        }

        if (empty($productCounts)) {
            return response()->json([]);
        }

        // Sort products by order frequency
        arsort($productCounts);
        $topProductIds = array_slice(array_keys($productCounts), 0, 15);

        $products = Product::with(['company', 'division', 'salt'])
            ->whereIn('id', $topProductIds)
            ->where('is_active', true)
            ->get()
            ->sortBy(function ($product) use ($productCounts) {
                return -($productCounts[$product->id] ?? 0);
            })
            ->values();

        $products->transform(function ($product) {
            $product->image_full_url = media_url($product->image);
            return $product;
        });

        return response()->json($products);
    }
}
