@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<div class="relative overflow-hidden bg-gradient-to-br from-pharma-navy to-slate-900 text-white py-16 sm:py-24">
    <!-- Decorative background elements -->
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(ellipse_at_center,_var(--tw-gradient-stops))] from-pharma-gold via-slate-900 to-slate-900"></div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <!-- Badge -->
        <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold bg-pharma-gold/20 text-pharma-gold uppercase tracking-widest mb-6 border border-pharma-gold/30">
            Pharmaceutical Distribution & Supply
        </span>
        
        <!-- Heading -->
        <h1 class="text-4xl sm:text-6xl font-extrabold tracking-tight font-display mb-6">
            {{ setting('company_name', 'Chitranshu Pharmaceuticals Agency') }}
        </h1>
        
        <!-- Tagline -->
        <p class="max-w-2xl mx-auto text-base sm:text-xl text-slate-300 mb-10 leading-relaxed">
            {{ setting('tagline', 'Your Trusted Pharmaceutical Distribution Partner') }}
        </p>

        <!-- Search Bar -->
        <div class="max-w-2xl mx-auto bg-white/10 backdrop-blur-md p-2 rounded-2xl border border-white/20 shadow-xl">
            <form action="{{ route('products.index') }}" method="GET" class="flex flex-col sm:flex-row gap-2">
                <div class="relative flex-grow">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                        💊
                    </span>
                    <input type="text" name="search" placeholder="Search by product name, active composition, or salt..." 
                           class="w-full pl-10 pr-4 py-3 bg-white text-slate-900 rounded-xl border border-transparent focus:outline-none focus:ring-2 focus:ring-pharma-accent font-medium text-sm placeholder-slate-400 shadow-inner">
                </div>
                <button type="submit" class="px-6 py-3 bg-pharma-accent hover:bg-blue-700 text-white font-bold text-sm rounded-xl transition duration-150 shadow-md">
                    Search Catalog
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Brands Showcase -->
<div class="py-16 bg-white border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-extrabold text-pharma-navy">Our Pharmaceutical Partners</h2>
            <p class="text-sm text-slate-500 mt-2">Supplying authentic formulations from India's leading brands.</p>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($companies as $company)
                <a href="{{ route('products.index', ['company_id' => $company->id]) }}" class="group block bg-slate-50 p-6 rounded-2xl border border-slate-200 hover:border-pharma-gold hover:shadow-lg transition duration-200 text-center">
                    <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-pharma-light to-white rounded-xl flex items-center justify-center font-bold text-xl text-pharma-navy border border-slate-200 group-hover:scale-105 transition">
                        @if($company->logo)
                            <img src="{{ asset('storage/' . $company->logo) }}" alt="{{ $company->name }}" class="w-full h-full object-cover rounded-xl">
                        @else
                            🏢
                        @endif
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 group-hover:text-pharma-accent transition">{{ $company->name }}</h3>
                    <p class="text-xs text-slate-500 mt-2 line-clamp-3 leading-relaxed">{{ $company->description }}</p>
                    <span class="inline-flex items-center text-xs font-bold text-pharma-gold group-hover:text-pharma-accent mt-4">
                        View Products &rarr;
                    </span>
                </a>
            @endforeach
        </div>
    </div>
</div>

<!-- Featured Products Grid -->
<div class="py-16 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row justify-between items-center mb-12">
            <div>
                <h2 class="text-3xl font-extrabold text-pharma-navy text-center sm:text-left">Featured Formulations</h2>
                <p class="text-sm text-slate-500 mt-1 text-center sm:text-left">Browse through popular listings in active distribution stock.</p>
            </div>
            <a href="{{ route('products.index') }}" class="mt-4 sm:mt-0 px-5 py-2.5 bg-white border border-slate-300 text-slate-700 font-semibold text-sm rounded-xl hover:bg-slate-100 hover:text-pharma-accent transition shadow-sm">
                Explore Full Catalog
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($products as $product)
                <div class="flex flex-col bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden hover:shadow-md transition duration-200">
                    <!-- Product Image/Icon -->
                    <div class="h-48 bg-slate-50 border-b border-slate-100 flex items-center justify-center text-5xl relative">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                        @else
                            💊
                        @endif
                        @if($product->stock_qty < 10)
                            <span class="absolute top-3 right-3 bg-red-100 text-red-800 text-[10px] font-bold px-2.5 py-0.5 rounded-full border border-red-200">
                                Low Stock
                            </span>
                        @endif
                    </div>
                    
                    <!-- Content -->
                    <div class="p-6 flex-grow flex flex-col">
                        <span class="text-[10px] font-bold text-pharma-gold uppercase tracking-wider">{{ $product->company->name }} | {{ $product->division->name }}</span>
                        <h3 class="text-lg font-bold text-slate-800 mt-1 truncate">
                            <a href="{{ route('products.show', $product->id) }}" class="hover:text-pharma-accent">{{ $product->name }}</a>
                        </h3>
                        <p class="text-xs text-slate-500 font-semibold mt-1">Composition: {{ Str::limit($product->composition, 40) }}</p>
                        <p class="text-xs text-slate-400 mt-2 italic">Packing: {{ $product->packing }}</p>

                        <!-- Salt Badge -->
                        <div class="mt-3">
                            <span class="inline-block text-[10px] font-semibold bg-slate-100 text-slate-600 px-2 py-0.5 rounded-md border border-slate-200">
                                Salt: {{ $product->salt->name }}
                            </span>
                        </div>

                        <!-- Footer / Pricing & Cart -->
                        <div class="mt-6 pt-4 border-t border-slate-100 flex justify-between items-center mt-auto">
                            <div>
                                <span class="block text-[9px] uppercase font-bold text-slate-400">MRP Value</span>
                                <span class="text-lg font-extrabold text-pharma-navy">₹{{ number_format($product->mrp, 2) }}</span>
                            </div>
                            
                            @if($product->stock_qty > 0)
                                <form action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="px-3.5 py-2 bg-pharma-accent hover:bg-pharma-navy text-white text-xs font-bold rounded-xl transition shadow-sm">
                                        Add +
                                    </button>
                                </form>
                            @else
                                <span class="text-xs font-bold text-red-600 bg-red-50 border border-red-200 px-2.5 py-1.5 rounded-lg">Out of Stock</span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
