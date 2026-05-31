@extends('layouts.app')

@section('content')
<div class="bg-slate-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <h1 class="text-3xl font-extrabold text-pharma-navy mb-8">Review Your Shopping Cart</h1>

        @if(empty($cart))
            <!-- Empty Cart state -->
            <div class="bg-white p-12 rounded-3xl border border-slate-200 shadow-sm text-center max-w-lg mx-auto py-16">
                <div class="w-24 h-24 bg-slate-100 rounded-full flex items-center justify-center text-slate-400 mb-6 text-4xl mx-auto">🛒</div>
                <h2 class="text-xl font-bold text-slate-800">Your shopping cart is empty</h2>
                <p class="text-sm text-slate-500 mt-2">There are currently no products added to your cart. Explore our catalog and add items to request quotation or place orders.</p>
                <a href="{{ route('products.index') }}" class="inline-block mt-8 px-6 py-3 bg-pharma-accent text-white font-bold rounded-xl text-sm hover:bg-pharma-navy transition shadow-md">
                    Browse Products Catalog
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Cart Items List (2 columns on lg) -->
                <div class="lg:col-span-2 space-y-4">
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-slate-200 bg-slate-50 text-xs font-bold text-slate-700 uppercase tracking-wider">
                            Cart Items
                        </div>
                        <div class="divide-y divide-slate-100">
                            @foreach($cart as $item)
                                <div class="p-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                                    <div class="flex items-start space-x-4">
                                        <!-- Icon -->
                                        <div class="w-16 h-16 bg-slate-50 border border-slate-200 rounded-xl flex-shrink-0 flex items-center justify-center text-3xl">
                                            @if($item['image'])
                                                <img src="{{ asset('storage/' . $item['image']) }}" class="w-full h-full object-cover rounded-xl">
                                            @else
                                                💊
                                            @endif
                                        </div>
                                        <!-- Text info -->
                                        <div>
                                            <h3 class="text-sm sm:text-base font-bold text-slate-800 leading-tight">{{ $item['name'] }}</h3>
                                            <p class="text-xs text-slate-500 mt-0.5">{{ $item['packing'] }} | {{ $item['company'] }}</p>
                                            <p class="text-xs text-pharma-accent font-semibold mt-1">Composition: {{ $item['composition'] }}</p>
                                        </div>
                                    </div>

                                    <!-- Controls and Price -->
                                    <div class="flex items-center justify-between sm:justify-end gap-6 w-full sm:w-auto mt-2 sm:mt-0 pt-4 sm:pt-0 border-t sm:border-t-0 border-slate-100">
                                        
                                        <!-- Update Qty Form -->
                                        <form action="{{ route('cart.update') }}" method="POST" class="flex items-center space-x-1.5">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $item['id'] }}">
                                            <input type="number" name="quantity" value="{{ $item['qty'] }}" min="1" 
                                                   class="w-16 px-2 py-1.5 bg-slate-50 border border-slate-200 rounded-lg text-sm font-bold text-center focus:outline-none focus:border-pharma-accent">
                                            <button type="submit" class="px-2.5 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-lg border border-slate-200 transition">
                                                Update
                                            </button>
                                        </form>

                                        <!-- Subtotal price -->
                                        <div class="text-right">
                                            <span class="block text-[10px] font-bold text-slate-400 uppercase">Subtotal</span>
                                            <span class="text-base font-bold text-slate-800">₹{{ number_format($item['qty'] * $item['price'], 2) }}</span>
                                        </div>

                                        <!-- Remove Form -->
                                        <form action="{{ route('cart.remove') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $item['id'] }}">
                                            <button type="submit" class="text-slate-400 hover:text-red-500 transition font-bold text-lg" title="Remove Item">
                                                ✕
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Checkout Summary Card (1 column on lg) -->
                <div class="lg:col-span-1 space-y-6" id="checkout">
                    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                        <h2 class="text-lg font-bold text-pharma-navy border-b border-slate-100 pb-4 mb-4">Order Summary</h2>
                        
                        <div class="flex justify-between items-center mb-6">
                            <span class="text-sm font-bold text-slate-600">Total Invoice Amount:</span>
                            <span class="text-2xl font-extrabold text-pharma-navy">₹{{ number_format($total, 2) }}</span>
                        </div>

                        <!-- Checkout Form -->
                        <form action="{{ route('cart.whatsapp') }}" method="POST" class="space-y-4">
                            @csrf
                            
                            <div>
                                <label for="customer_name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Your Name / Agency Name</label>
                                <input type="text" name="customer_name" id="customer_name" required value="{{ old('customer_name') }}"
                                       placeholder="e.g. John Doe / Apex Pharmacy" 
                                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-pharma-accent focus:bg-white @error('customer_name') border-red-500 @enderror">
                                @error('customer_name')
                                    <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="phone" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">WhatsApp Contact Number</label>
                                <input type="text" name="phone" id="phone" required value="{{ old('phone') }}"
                                       placeholder="e.g. 9876543210" 
                                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-pharma-accent focus:bg-white @error('phone') border-red-500 @enderror">
                                <span class="text-[10px] text-slate-400 mt-1 block">Specify your 10-digit mobile number connected to WhatsApp.</span>
                                @error('phone')
                                    <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit" class="w-full mt-6 py-3 px-6 bg-gradient-to-r from-pharma-accent to-pharma-navy text-white text-sm font-bold rounded-xl hover:opacity-95 transition shadow-md flex justify-center items-center space-x-2">
                                <span>💬 Confirm Order via WhatsApp</span>
                            </button>
                        </form>
                    </div>

                    <!-- Trust banner -->
                    <div class="bg-pharma-light/50 border border-pharma-light p-4 rounded-2xl text-center">
                        <span class="text-xs font-bold text-pharma-navy">Secure WhatsApp Quotation</span>
                        <p class="text-[11px] text-slate-500 mt-1 leading-relaxed">Your order details will be stored in our database, and a formatted message containing item details and pricing will open directly in WhatsApp to finalize delivery details with our admins.</p>
                    </div>
                </div>

            </div>
        @endif

    </div>
</div>
@endsection
