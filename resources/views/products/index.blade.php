@extends('layouts.app')

@section('content')
<div class="bg-slate-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center">
            <div>
                <h1 class="text-3xl font-extrabold text-pharma-navy">Product Catalog</h1>
                <p class="text-sm text-slate-500 mt-1">Explore our range of pharmaceutical products, active compositions, and salts.</p>
            </div>
            <div class="mt-4 md:mt-0 text-sm font-bold text-slate-600 bg-white px-4 py-2 rounded-xl border border-slate-200 shadow-sm">
                Showing {{ $products->firstItem() ?? 0 }} - {{ $products->lastItem() ?? 0 }} of {{ $products->total() }} Products
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            
            <!-- Filters Sidebar -->
            <div class="lg:col-span-1 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm h-fit">
                <form action="{{ route('products.index') }}" method="GET" id="filter-form">
                    
                    <!-- Search Keyword -->
                    <div class="mb-6">
                        <label for="search" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Search</label>
                        <div class="relative">
                            <input type="text" name="search" id="search" value="{{ request('search') }}" 
                                   placeholder="Name, composition, salt..." 
                                   class="w-full pl-3 pr-8 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-pharma-accent focus:bg-white shadow-inner">
                            @if(request('search'))
                                <a href="{{ route('products.index', request()->except('search')) }}" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-red-500 font-bold">×</a>
                            @endif
                        </div>
                    </div>

                    <!-- Company Filter -->
                    <div class="mb-6">
                        <label for="company_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Company</label>
                        <select name="company_id" id="company_id" onchange="document.getElementById('filter-form').submit()" 
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-pharma-accent focus:bg-white transition">
                            <option value="">All Companies</option>
                            @foreach($companies as $company)
                                <option value="{{ $company->id }}" {{ request('company_id') == $company->id ? 'selected' : '' }}>
                                    {{ $company->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Division Filter -->
                    <div class="mb-6">
                        <label for="division_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Division</label>
                        <select name="division_id" id="division_id" onchange="document.getElementById('filter-form').submit()" 
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-pharma-accent focus:bg-white transition">
                            <option value="">All Divisions</option>
                            @foreach($divisions as $division)
                                <option value="{{ $division->id }}" {{ request('division_id') == $division->id ? 'selected' : '' }}>
                                    {{ $division->name }} ({{ $division->company->name }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Reset Button -->
                    @if(request()->anyFilled(['search', 'company_id', 'division_id']))
                        <a href="{{ route('products.index') }}" class="block text-center py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition">
                            Clear All Filters
                        </a>
                    @endif

                </form>
            </div>

            <!-- Products Listing Grid -->
            <div class="lg:col-span-3">
                @if($products->isEmpty())
                    <div class="bg-white p-12 rounded-2xl border border-slate-200 shadow-sm text-center">
                        <div class="text-4xl mb-4">💊</div>
                        <h3 class="text-lg font-bold text-slate-800">No products found</h3>
                        <p class="text-sm text-slate-500 mt-2">Try adjusting your filters or search keywords to find what you are looking for.</p>
                        <a href="{{ route('products.index') }}" class="inline-block mt-6 px-5 py-2.5 bg-pharma-accent text-white text-sm font-semibold rounded-xl hover:bg-pharma-navy transition">
                            Clear Filters
                        </a>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6 mb-8">
                        @foreach($products as $product)
                            <div class="flex flex-col bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden hover:shadow-md transition duration-200">
                                
                                <!-- Header Badge & Image -->
                                <div class="h-44 bg-slate-50 border-b border-slate-100 flex items-center justify-center text-4xl relative">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                    @else
                                        💊
                                    @endif
                                    @if($product->stock_qty < 10)
                                        <span class="absolute top-3 right-3 bg-red-100 text-red-800 text-[9px] font-bold px-2 py-0.5 rounded-full border border-red-200">
                                            Low Stock
                                        </span>
                                    @endif
                                </div>

                                <!-- Card Details -->
                                <div class="p-5 flex-grow flex flex-col">
                                    <span class="text-[9px] font-bold text-pharma-gold uppercase tracking-wider">{{ $product->company->name }} | {{ $product->division->name }}</span>
                                    
                                    <h3 class="text-base font-bold text-slate-800 mt-1 truncate">
                                        <a href="{{ route('products.show', $product->id) }}" class="hover:text-pharma-accent transition">{{ $product->name }}</a>
                                    </h3>
                                    
                                    <p class="text-xs text-slate-500 font-semibold mt-1">Composition: {{ Str::limit($product->composition, 40) }}</p>
                                    <p class="text-xs text-slate-400 mt-2 italic">Packing: {{ $product->packing }}</p>

                                    <!-- Salt badge -->
                                    <div class="mt-3">
                                        <span class="inline-block text-[10px] font-semibold bg-slate-100 text-slate-600 px-2 py-0.5 rounded-md border border-slate-200">
                                            {{ $product->salt->name }}
                                        </span>
                                    </div>

                                    <!-- Price & Cart Button -->
                                    <div class="mt-6 pt-4 border-t border-slate-100 flex justify-between items-center mt-auto">
                                        <div>
                                            <span class="block text-[8px] uppercase font-bold text-slate-400">MRP Value</span>
                                            <span class="text-base font-extrabold text-pharma-navy">₹{{ number_format($product->mrp, 2) }}</span>
                                        </div>

                                        @if($product->stock_qty > 0)
                                            <form action="{{ route('cart.add') }}" method="POST" class="flex items-center space-x-1">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock_qty }}" 
                                                       class="w-12 px-2 py-1 bg-slate-100 border border-slate-200 rounded-lg text-xs font-semibold text-center focus:outline-none focus:border-pharma-accent">
                                                <button type="submit" class="px-3 py-1 bg-pharma-accent hover:bg-pharma-navy text-white text-xs font-bold rounded-lg transition shadow-sm">
                                                    Add
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-[10px] font-bold text-red-600 bg-red-50 border border-red-200 px-2 py-1 rounded">Out of Stock</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="bg-white px-4 py-4 border border-slate-200 rounded-2xl shadow-sm">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>
@endsection
