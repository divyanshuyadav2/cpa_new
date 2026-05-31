@extends('layouts.admin')

@section('content')
<div class="flex flex-col xl:flex-row justify-between items-start xl:items-center mb-8 gap-4">
    <div>
        <h1 class="text-3xl font-extrabold text-pharma-navy">Products Management</h1>
        <p class="text-sm text-slate-500 mt-1">Add, edit, filter, or bulk-import products in the system.</p>
    </div>
    
    <div class="flex flex-wrap gap-3">
        <!-- Bulk CSV Import Form -->
        <div class="bg-white p-3 rounded-xl border border-slate-200 shadow-sm flex items-center gap-2">
            <form action="{{ route('products.import') }}" method="POST" enctype="multipart/form-data" class="flex items-center gap-2">
                @csrf
                <div class="relative">
                    <input type="file" name="csv_file" required accept=".csv" class="text-xs text-slate-500 file:mr-2 file:py-1 file:px-2 file:rounded file:border file:border-slate-300 file:text-[10px] file:font-semibold file:bg-slate-50 hover:file:bg-slate-100 cursor-pointer">
                </div>
                <button type="submit" class="px-3 py-1 bg-slate-800 hover:bg-slate-900 text-white font-bold text-xs rounded transition">
                    Bulk Import (CSV)
                </button>
            </form>
        </div>

        <a href="{{ route('products.create') }}" class="px-5 py-3 bg-pharma-accent text-white font-bold text-sm rounded-xl hover:bg-blue-700 transition shadow-md flex items-center">
            + Add New Product
        </a>
    </div>
</div>

<!-- Filters Bar Card -->
<div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm mb-6">
    <form action="{{ route('products.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4" id="admin-product-filter">
        <!-- Search Keyword -->
        <div>
            <label for="search" class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Search Keywords</label>
            <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Name, composition..."
                   class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-xs focus:outline-none focus:ring-2 focus:ring-pharma-accent focus:bg-white transition">
        </div>

        <!-- Company Filter -->
        <div>
            <label for="company_id" class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Company</label>
            <select name="company_id" id="company_id" onchange="document.getElementById('admin-product-filter').submit()"
                    class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-xs focus:outline-none focus:ring-2 focus:ring-pharma-accent focus:bg-white transition">
                <option value="">All Companies</option>
                @foreach($companies as $company)
                    <option value="{{ $company->id }}" {{ request('company_id') == $company->id ? 'selected' : '' }}>
                        {{ $company->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Division Filter -->
        <div>
            <label for="division_id" class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Division</label>
            <select name="division_id" id="division_id" onchange="document.getElementById('admin-product-filter').submit()"
                    class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-xs focus:outline-none focus:ring-2 focus:ring-pharma-accent focus:bg-white transition">
                <option value="">All Divisions</option>
                @foreach($divisions as $div)
                    <option value="{{ $div->id }}" {{ request('division_id') == $div->id ? 'selected' : '' }}>
                        {{ $div->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Reset & Submit buttons -->
        <div class="flex items-end space-x-2">
            <button type="submit" class="flex-grow py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-lg border border-slate-200 transition">
                Apply Filters
            </button>
            @if(request()->anyFilled(['search', 'company_id', 'division_id']))
                <a href="{{ route('products.index') }}" class="px-3 py-2 bg-red-50 hover:bg-red-100 text-red-600 text-xs font-bold rounded-lg border border-red-200 transition">
                    Reset
                </a>
            @endif
        </div>
    </form>
</div>

<!-- Table Card -->
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    @if($products->isEmpty())
        <div class="p-12 text-center text-slate-400">
            <span class="text-4xl block mb-3">💊</span>
            No products found matching the criteria.
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50 text-[10px] font-bold text-slate-500 uppercase">
                        <th class="p-4 w-16">Image</th>
                        <th class="p-4">Product Details</th>
                        <th class="p-4">Company & Division</th>
                        <th class="p-4">Composition & Salt</th>
                        <th class="p-4">Pricing (MRP/PTR/PTS)</th>
                        <th class="p-4">Stock</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @foreach($products as $product)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="p-4">
                                <div class="w-10 h-10 bg-slate-50 border border-slate-200 rounded-lg flex items-center justify-center text-lg overflow-hidden flex-shrink-0">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                    @else
                                        💊
                                    @endif
                                </div>
                            </td>
                            <td class="p-4">
                                <strong class="block text-slate-900 leading-tight">{{ $product->name }}</strong>
                                <span class="text-xs text-slate-400">Packing: {{ $product->packing }}</span>
                            </td>
                            <td class="p-4">
                                <span class="block font-semibold text-slate-700 leading-tight">{{ $product->company->name }}</span>
                                <span class="text-xs text-slate-500">Div: {{ $product->division->name }}</span>
                            </td>
                            <td class="p-4">
                                <span class="block text-xs font-semibold text-slate-700 leading-tight truncate max-w-[180px]">{{ $product->composition }}</span>
                                <span class="text-[10px] text-slate-500 bg-slate-100 px-1.5 py-0.5 rounded border border-slate-200 w-fit block mt-1">Salt: {{ $product->salt->name }}</span>
                            </td>
                            <td class="p-4">
                                <div class="text-xs space-y-0.5 leading-none">
                                    <span class="block text-slate-500">MRP: <strong class="text-slate-800">₹{{ number_format($product->mrp, 2) }}</strong></span>
                                    <span class="block text-slate-500">PTR: <strong class="text-slate-800">₹{{ number_format($product->ptr, 2) }}</strong></span>
                                    <span class="block text-slate-500">PTS: <strong class="text-slate-800">₹{{ number_format($product->pts, 2) }}</strong></span>
                                </div>
                            </td>
                            <td class="p-4">
                                <span class="inline-flex px-2 py-1 rounded text-xs font-bold {{ $product->stock_qty < 10 ? 'bg-red-100 text-red-800 border border-red-200' : 'bg-slate-100 text-slate-800 border border-slate-200' }}">
                                    {{ $product->stock_qty }} units
                                </span>
                            </td>
                            <td class="p-4">
                                @if($product->is_active)
                                    <span class="inline-flex px-2 py-0.5 rounded-full text-[10px] font-bold bg-green-100 text-green-800 border border-green-200">Active</span>
                                @else
                                    <span class="inline-flex px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600 border border-slate-200">Inactive</span>
                                @endif
                            </td>
                            <td class="p-4 text-right flex justify-end items-center space-x-2 h-18">
                                <a href="{{ route('products.edit', $product->id) }}" class="px-2.5 py-1 bg-slate-100 text-slate-700 font-semibold text-xs rounded border border-slate-200 hover:bg-slate-200 transition">
                                    Edit
                                </a>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" 
                                      onsubmit="return confirm('Are you sure you want to delete this product?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-2.5 py-1 bg-red-50 text-red-600 font-semibold text-xs rounded border border-red-200 hover:bg-red-600 hover:text-white transition">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-slate-200 bg-slate-50">
            {{ $products->links() }}
        </div>
    @endif
</div>
@endsection
