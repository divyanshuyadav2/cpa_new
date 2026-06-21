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
}
