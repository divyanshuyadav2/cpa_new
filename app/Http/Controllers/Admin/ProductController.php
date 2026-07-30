<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Division;
use App\Models\Product;
use App\Models\Salt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::with(['company', 'division', 'salt']);

        // Search by keyword
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('composition', 'like', "%{$search}%");
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

        $products = $query->latest()->paginate(10)->withQueryString();

        $companies = Company::where('is_active', true)->orderBy('name')->get();
        
        $divisions = [];
        if ($request->filled('company_id')) {
            $divisions = Division::where('company_id', $request->input('company_id'))
                ->where('is_active', true)
                ->orderBy('name')
                ->get();
        }

        return view('admin.products.index', compact('products', 'companies', 'divisions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = Company::where('is_active', true)->orderBy('name')->get();
        $salts = Salt::orderBy('name')->get();
        
        return view('admin.products.create', compact('companies', 'salts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'hsn_code'    => 'nullable|string|max:50',
            'company_id'  => 'nullable|exists:companies,id',
            'division_id' => 'nullable|exists:divisions,id',
            'salt_id'     => 'nullable|exists:salts,id',
            'composition' => 'nullable|string|max:255',
            'packing'     => 'nullable|string|max:255',
            'mrp'         => 'required|numeric|min:0',
            'ptr'         => 'required|numeric|min:0',
            'pts'         => 'required|numeric|min:0',
            'tax'         => 'nullable|numeric|min:0',
            'a_tax'       => 'nullable|numeric|min:0',
            'pur'         => 'nullable|numeric|min:0',
            'stock_qty'   => 'required|integer|min:0',
            'image'       => 'nullable|image|max:2048',
            'image_url'   => 'nullable|url|max:2048',
            'is_active'   => 'nullable|boolean',
        ]);

        $data = $request->except(['image', 'image_url', 'is_active']);
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            // File upload takes priority
            $imagePath = $request->file('image')->store('products', 'public');
            @chmod(public_path('storage/' . $imagePath), 0644);
            $data['image'] = $imagePath;
        } elseif ($request->filled('image_url')) {
            // Store URL directly
            $data['image'] = $request->input('image_url');
        }

        Product::create($data);

        return redirect()->route('products.index')->with('success', 'Product created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $companies = Company::where('is_active', true)->orderBy('name')->get();
        $divisions = Division::where('company_id', $product->company_id)
            ->where('is_active', true)
            ->orderBy('name')
            ->get();
        $salts = Salt::orderBy('name')->get();

        return view('admin.products.edit', compact('product', 'companies', 'divisions', 'salts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'hsn_code'    => 'nullable|string|max:50',
            'company_id'  => 'nullable|exists:companies,id',
            'division_id' => 'nullable|exists:divisions,id',
            'salt_id'     => 'nullable|exists:salts,id',
            'composition' => 'nullable|string|max:255',
            'packing'     => 'nullable|string|max:255',
            'mrp'         => 'required|numeric|min:0',
            'ptr'         => 'required|numeric|min:0',
            'pts'         => 'required|numeric|min:0',
            'tax'         => 'nullable|numeric|min:0',
            'a_tax'       => 'nullable|numeric|min:0',
            'pur'         => 'nullable|numeric|min:0',
            'stock_qty'   => 'required|integer|min:0',
            'image'       => 'nullable|image|max:2048',
            'image_url'   => 'nullable|url|max:2048',
            'is_active'   => 'nullable|boolean',
        ]);

        $data = $request->except(['image', 'image_url', 'is_active']);
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            // Delete old image if it was a stored file (not a URL)
            if ($product->image && !str_starts_with($product->image, 'http')) {
                Storage::disk('public')->delete($product->image);
            }
            $imagePath = $request->file('image')->store('products', 'public');
            @chmod(public_path('storage/' . $imagePath), 0644);
            $data['image'] = $imagePath;
        } elseif ($request->filled('image_url')) {
            // Delete old file if switching to URL
            if ($product->image && !str_starts_with($product->image, 'http')) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->input('image_url');
        }

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Delete image file only if it's a stored file (not a URL)
        if ($product->image && !filter_var($product->image, FILTER_VALIDATE_URL)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
    }

    /**
     * Stub for bulk CSV import.
     */
    public function import(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:4096',
        ]);

        $file = $request->file('csv_file');
        
        // Prototype logic: Parse headers
        if (($handle = fopen($file->getRealPath(), "r")) !== FALSE) {
            $header = fgetcsv($handle, 1000, ",");
            fclose($handle);
            
            // Check if headers match standard structure
            $expected = ['name', 'company', 'division', 'salt', 'composition', 'packing', 'mrp', 'ptr', 'pts', 'stock_qty'];
            
            // Simulating parsing of columns
            return redirect()->route('products.index')
                ->with('success', 'CSV Import Stub: File received successfully! Parsed ' . count($header) . ' columns: (' . implode(', ', $header) . '). In a production environment, this would seed the products table.');
        }

        return redirect()->route('products.index')->with('error', 'Failed to read CSV file.');
    }
    public function export(Request $request)
    {
        $products = Product::with(['company', 'division', 'salt'])->get();

        $filename = "products_export_" . date('Ymd_His') . ".csv";
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['ID', 'Name', 'HSN Code', 'Company', 'Division', 'Salt', 'Composition', 'Packing', 'MRP', 'PTR', 'PTS', 'Tax', 'A.Tax', 'Pur', 'Stock Qty', 'Active'];

        $callback = function() use($products, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($products as $product) {
                fputcsv($file, [
                    $product->id,
                    $product->name,
                    $product->hsn_code,
                    $product->company ? $product->company->name : '',
                    $product->division ? $product->division->name : '',
                    $product->salt ? $product->salt->name : '',
                    $product->composition,
                    $product->packing,
                    $product->mrp,
                    $product->ptr,
                    $product->pts,
                    $product->tax,
                    $product->a_tax,
                    $product->pur,
                    $product->stock_qty,
                    $product->is_active ? 'Yes' : 'No',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
