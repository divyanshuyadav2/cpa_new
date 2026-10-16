<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Division;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index(Request $request)
    {
        $query = Product::with(['company', 'division', 'salt'])->where('is_active', true);

        // Search by keyword (name, composition, or salt name)
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('composition', 'like', "%{$search}%")
                  ->orWhereHas('salt', function ($sq) use ($search) {
                      $sq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by company
        if ($request->filled('company_id')) {
            $query->where('company_id', $request->input('company_id'));
        }

        // Filter by division
        if ($request->filled('division_id')) {
            $query->where('division_id', $request->input('division_id'));
        }

        // Paginate results
        $products = $query->latest()->paginate(12)->withQueryString();

        // Return JSON with partial HTML for infinite scroll AJAX requests
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'html' => view('products._card_list', compact('products'))->render(),
                'next_page_url' => $products->nextPageUrl(),
                'has_more' => $products->hasMorePages(),
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'total' => $products->total(),
                'to' => $products->lastItem() ?? 0,
            ]);
        }

        // Get filter options
        $companies = Company::where('is_active', true)->orderBy('name')->get();
        
        // If company is selected, get its divisions, otherwise get all active divisions
        if ($request->filled('company_id')) {
            $divisions = Division::where('company_id', $request->input('company_id'))
                ->where('is_active', true)
                ->orderBy('name')
                ->get();
        } else {
            $divisions = Division::where('is_active', true)->orderBy('name')->get();
        }

        return view('products.index', compact('products', 'companies', 'divisions'));
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product)
    {
        if (!$product->is_active) {
            abort(404);
        }

        $product->load(['company', 'division', 'salt']);
        
        // Get related products (same company or salt)
        $relatedProducts = Product::with(['company', 'division', 'salt'])
            ->where('is_active', true)
            ->where('id', '!=', $product->id)
            ->where(function ($q) use ($product) {
                $q->where('company_id', $product->company_id)
                  ->orWhere('salt_id', $product->salt_id);
            })
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }
}
