@extends('layouts.app')

@section('content')
<div class="bg-slate-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Back Link -->
        <a href="{{ route('products.index') }}" class="inline-flex items-center text-sm font-bold text-pharma-accent hover:text-pharma-navy mb-6">
            &larr; Back to Catalog
        </a>

        <!-- Product Main Card -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden mb-12">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-6 sm:p-8">
                
                <!-- Left: Product Image -->
                <div class="bg-slate-50 border border-slate-200 rounded-2xl flex items-center justify-center p-8 text-8xl h-96 relative">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-contain rounded-xl">
                    @else
                        💊
                    @endif
                    @if($product->stock_qty < 10 && $product->stock_qty > 0)
                        <span class="absolute top-4 right-4 bg-red-100 text-red-800 text-xs font-bold px-3 py-1 rounded-full border border-red-200">
                            Low Stock ({{ $product->stock_qty }} left)
                        </span>
                    @endif
                </div>

                <!-- Right: Product Information -->
                <div class="flex flex-col">
                    <!-- Brand info -->
                    <span class="inline-flex items-center px-3 py-1 rounded-md text-xs font-bold bg-slate-100 text-slate-600 border border-slate-200 w-fit">
                        {{ $product->company->name }} &bull; {{ $product->division->name }}
                    </span>

                    <h1 class="text-3xl sm:text-4xl font-extrabold text-pharma-navy mt-4 leading-tight">
                        {{ $product->name }}
                    </h1>
                    
                    <!-- Composition -->
                    <p class="text-sm font-semibold text-slate-700 mt-2">
                        Composition: <span class="text-pharma-accent">{{ $product->composition }}</span>
                    </p>

                    <div class="mt-4 flex items-center space-x-6">
                        <span class="text-xs text-slate-500 font-bold uppercase">Packing: <span class="text-slate-800 font-semibold italic">{{ $product->packing }}</span></span>
                        <span class="text-xs text-slate-500 font-bold uppercase">Chemical Salt: <span class="text-slate-800 font-semibold">{{ $product->salt->name }}</span></span>
                    </div>

                    <!-- Description (if any) -->
                    @if($product->salt->description)
                        <div class="mt-6 p-4 bg-pharma-light/50 border border-pharma-light rounded-xl">
                            <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Salt Information</h4>
                            <p class="text-xs text-slate-600 leading-relaxed">{{ $product->salt->description }}</p>
                        </div>
                    @endif

                    <!-- Pricing Table -->
                    <div class="mt-8 border border-slate-200 rounded-2xl overflow-hidden shadow-inner bg-slate-50">
                        <div class="bg-slate-100 px-4 py-3 border-b border-slate-200 text-xs font-bold text-slate-700 uppercase tracking-wider">
                            Pricing Structures (INR)
                        </div>
                        <div class="grid grid-cols-3 divide-x divide-slate-200 text-center">
                            <div class="p-4">
                                <span class="block text-[10px] font-bold text-slate-400 uppercase">MRP (Retail)</span>
                                <span class="text-xl font-extrabold text-slate-800">₹{{ number_format($product->mrp, 2) }}</span>
                            </div>
                            <div class="p-4">
                                <span class="block text-[10px] font-bold text-slate-400 uppercase">PTR (Retailer)</span>
                                <span class="text-xl font-extrabold text-slate-800">₹{{ number_format($product->ptr, 2) }}</span>
                            </div>
                            <div class="p-4">
                                <span class="block text-[10px] font-bold text-slate-400 uppercase">PTS (Stockist)</span>
                                <span class="text-xl font-extrabold text-slate-800">₹{{ number_format($product->pts, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Cart and Inventory controls -->
                    <div class="mt-8 pt-6 border-t border-slate-200 mt-auto">
                        @if($product->stock_qty > 0)
                            <form action="{{ route('cart.add') }}" method="POST" class="flex flex-col sm:flex-row gap-4 items-stretch sm:items-center">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                
                                <div class="flex items-center border border-slate-300 rounded-xl overflow-hidden bg-white shadow-sm self-start">
                                    <span class="px-4 py-2 text-xs font-bold text-slate-500 uppercase bg-slate-50 border-r border-slate-200">Qty</span>
                                    <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock_qty }}" 
                                           class="w-16 px-3 py-2 text-sm font-bold text-center focus:outline-none">
                                </div>

                                <button type="submit" class="flex-grow py-3 px-6 bg-gradient-to-r from-pharma-accent to-pharma-navy text-white text-sm font-bold rounded-xl hover:opacity-95 transition shadow-md text-center">
                                    Add to Cart Drawer
                                </button>
                            </form>
                        @else
                            <div class="p-4 bg-red-50 border border-red-200 rounded-xl text-center">
                                <span class="text-sm font-bold text-red-600">Currently Out of Stock</span>
                                <p class="text-xs text-red-500 mt-1">This item will be restocked shortly. Please contact support.</p>
                            </div>
                        @endif
                    </div>

                </div>

            </div>
        </div>

        <!-- Related Products Section -->
        @if(!$relatedProducts->isEmpty())
            <div>
                <h3 class="text-2xl font-extrabold text-pharma-navy mb-6">Related Formulations</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($relatedProducts as $rel)
                        <div class="flex flex-col bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden hover:shadow-md transition">
                            <div class="h-40 bg-slate-50 flex items-center justify-center text-3xl">
                                @if($rel->image)
                                    <img src="{{ asset('storage/' . $rel->image) }}" class="w-full h-full object-cover">
                                @else
                                    💊
                                @endif
                            </div>
                            <div class="p-4 flex-grow flex flex-col">
                                <span class="text-[9px] font-bold text-pharma-gold uppercase tracking-wider">{{ $rel->company->name }}</span>
                                <h4 class="text-sm font-bold text-slate-800 mt-1 truncate">
                                    <a href="{{ route('products.show', $rel->id) }}" class="hover:text-pharma-accent">{{ $rel->name }}</a>
                                </h4>
                                <p class="text-xs text-slate-400 mt-1 italic">Packing: {{ $rel->packing }}</p>
                                
                                <div class="mt-4 pt-3 border-t border-slate-100 flex justify-between items-center mt-auto">
                                    <span class="text-sm font-extrabold text-pharma-navy">₹{{ number_format($rel->mrp, 2) }}</span>
                                    <a href="{{ route('products.show', $rel->id) }}" class="text-xs font-bold text-pharma-accent hover:text-pharma-navy">
                                        View Details &rarr;
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</div>
@endsection
