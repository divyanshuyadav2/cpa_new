@extends('layouts.app')

@section('content')
<div class="bg-slate-100 py-8" x-data="{ b2bModalOpen: {{ $errors->any() ? 'true' : 'false' }}, confirmed: {{ old('dl_confirmed') ? 'true' : 'false' }} }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-extrabold text-pharma-navy">Review Your Shopping Cart</h1>
                <p class="text-xs text-slate-500 mt-1">B2B Wholesale medicine catalog & inquiry compiler</p>
            </div>
            <a href="{{ route('public.products.index') }}" class="inline-flex items-center text-xs font-bold text-pharma-accent hover:text-pharma-navy">
                &larr; Continue Browsing Products
            </a>
        </div>

        @if(empty($cart))
            <!-- Empty Cart state -->
            <div class="bg-white p-12 rounded-3xl border border-slate-200 shadow-sm text-center max-w-lg mx-auto py-16">
                <div class="w-24 h-24 bg-slate-100 rounded-full flex items-center justify-center text-slate-400 mb-6 text-4xl mx-auto">🛒</div>
                <h2 class="text-xl font-bold text-slate-800">Your shopping cart is empty</h2>
                <p class="text-sm text-slate-500 mt-2">There are currently no products added to your cart. Explore our catalog and add items to request quotation or place orders.</p>
                <a href="{{ route('public.products.index') }}" class="inline-block mt-8 px-6 py-3 bg-pharma-accent text-white font-bold rounded-xl text-sm hover:bg-pharma-navy transition shadow-md">
                    Browse Products Catalog
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Cart Items List (2 columns on lg) -->
                <div class="lg:col-span-2 space-y-4">
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-slate-200 bg-slate-50 flex justify-between items-center text-xs font-bold text-slate-700 uppercase tracking-wider">
                            <span>Cart Items ({{ count($cart) }})</span>
                            <span class="text-[10px] text-amber-700 bg-amber-50 px-2 py-0.5 rounded border border-amber-200">Wholesale Supply Only</span>
                        </div>
                        <div class="divide-y divide-slate-100">
                            @foreach($cart as $item)
                                <div class="p-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                                    <div class="flex items-start space-x-4">
                                        <!-- Icon -->
                                        <div class="w-16 h-16 bg-slate-50 border border-slate-200 rounded-xl flex-shrink-0 flex items-center justify-center text-3xl">
                                        @if($item['image'])
                                            <img src="{{ media_url($item['image']) }}" class="w-full h-full object-cover rounded-xl">
                                        @else
                                            💊
                                        @endif
                                        </div>
                                        <!-- Text info -->
                                        <div>
                                            <h3 class="text-sm sm:text-base font-bold text-slate-800 leading-tight">{{ $item['name'] }}</h3>
                                            <p class="text-xs text-slate-500 mt-0.5">{{ $item['packing'] }} | {{ $item['company'] }}</p>
                                            <p class="text-xs text-pharma-accent font-semibold mt-1">Composition: {{ $item['composition'] }}</p>
                                            <span class="inline-block text-[8px] font-bold text-amber-700 bg-amber-50 border border-amber-200/80 rounded px-1.5 py-0.5 mt-1.5">
                                                For Licensed Retailers Only
                                            </span>
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
                                            <span class="block text-[10px] font-bold text-slate-400 uppercase">Subtotal (MRP)</span>
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
                        
                        <div class="space-y-2 mb-6">
                            <div class="flex justify-between items-center text-sm text-slate-600">
                                <span>Total Formulations:</span>
                                <span class="font-bold text-slate-800">{{ count($cart) }} Items</span>
                            </div>
                            <div class="flex justify-between items-center text-sm text-slate-600">
                                <span>Total Quantity:</span>
                                <span class="font-bold text-slate-800">{{ collect($cart)->sum('qty') }} Units</span>
                            </div>
                            <div class="flex justify-between items-center pt-3 border-t border-slate-100">
                                <span class="text-sm font-bold text-slate-700">Estimated MRP Value:</span>
                                <span class="text-2xl font-extrabold text-pharma-navy">₹{{ number_format($total, 2) }}</span>
                            </div>
                            <span class="text-[10px] text-slate-400 block text-right">*Net wholesale billing subject to trade discount</span>
                        </div>

                        <!-- Compliance Warning Box -->
                        <div class="p-3.5 bg-amber-50/80 border border-amber-200 rounded-xl text-xs text-amber-900 leading-relaxed mb-6">
                            <div class="flex items-center gap-1.5 font-bold text-amber-950 mb-1">
                                <span>⚖️</span>
                                <span>Retail Drug License Mandatory</span>
                            </div>
                            <p class="text-[11px] text-amber-800">
                                In compliance with the Drugs & Cosmetics Act, 1940, orders are processed strictly against valid Drug Licenses (Form 20/21) and GSTIN.
                            </p>
                        </div>

                        <!-- Proceed to WhatsApp Button (Opens Mandatory Modal) -->
                        <button type="button" @click="b2bModalOpen = true" 
                                class="w-full py-3.5 px-6 bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white text-sm font-extrabold rounded-xl transition shadow-md hover:shadow-lg flex justify-center items-center gap-2 group">
                            <svg class="w-5 h-5 text-emerald-100 group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                            <span>Proceed to Order via WhatsApp</span>
                        </button>
                    </div>

                    <!-- Trust banner -->
                    <div class="bg-pharma-light/50 border border-pharma-light p-4 rounded-2xl text-center">
                        <span class="text-xs font-bold text-pharma-navy">Direct Wholesale Distribution</span>
                        <p class="text-[11px] text-slate-500 mt-1 leading-relaxed">Clicking proceed opens the mandatory retailer verification form. Once verified, your structured quotation inquiry connects directly with our dispatch department on WhatsApp.</p>
                    </div>
                </div>

            </div>
        @endif

    </div>

    <!-- Mandatory B2B Verification Modal Popup -->
    <div class="fixed inset-0 z-50 overflow-y-auto" 
         x-show="b2bModalOpen" 
         x-cloak
         style="display: none;"
         @keydown.window.escape="b2bModalOpen = false">
        
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-slate-900/75 backdrop-blur-sm transition-opacity"
             x-show="b2bModalOpen"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="b2bModalOpen = false"></div>

        <!-- Modal Dialog -->
        <div class="min-h-full flex items-center justify-center p-4 text-center sm:p-0">
            <div class="relative bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:max-w-xl sm:w-full border border-slate-200"
                 x-show="b2bModalOpen"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                 
                <!-- Modal Header -->
                <div class="bg-gradient-to-r from-pharma-navy to-slate-900 px-6 py-5 text-white flex justify-between items-center border-b border-slate-800">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-xl bg-amber-500/20 text-amber-400 flex items-center justify-center border border-amber-500/30 text-xl shrink-0">
                            🏥
                        </div>
                        <div>
                            <h3 class="text-base sm:text-lg font-extrabold text-white leading-tight">Licensed Retailer Verification</h3>
                            <p class="text-xs text-amber-400 font-semibold">Drugs & Cosmetics Act Compliance (Form 20/21)</p>
                        </div>
                    </div>
                    <button type="button" @click="b2bModalOpen = false" class="text-slate-400 hover:text-white transition text-2xl font-bold">&times;</button>
                </div>

                <!-- Modal Body -->
                <form action="{{ route('cart.whatsapp') }}" method="POST" class="p-6 sm:p-8 space-y-4">
                    @csrf

                    <p class="text-xs text-slate-600 leading-relaxed bg-slate-50 p-3.5 rounded-xl border border-slate-200">
                        Please provide your licensed medical establishment details. As a wholesale distributor, invoices and dispatches are processed strictly against valid Drug Licenses.
                    </p>

                    <!-- Pharmacy / Store Name -->
                    <div>
                        <label for="store_name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Pharmacy / Store Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="store_name" id="store_name" required value="{{ old('store_name') }}"
                               placeholder="e.g., Sharma Medical Hall" 
                               class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-pharma-accent focus:bg-white @error('store_name') border-red-500 @enderror">
                        @error('store_name')
                            <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- 2 Columns: Drug License & GST -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="dl_number" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Drug License Number <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="dl_number" id="dl_number" required value="{{ old('dl_number') }}"
                                   placeholder="e.g., DL-XXXXXX" 
                                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-pharma-accent focus:bg-white @error('dl_number') border-red-500 @enderror">
                            @error('dl_number')
                                <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="gst_number" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                GST Number <span class="text-slate-400 font-normal">(Optional)</span>
                            </label>
                            <input type="text" name="gst_number" id="gst_number" value="{{ old('gst_number') }}"
                                   placeholder="e.g., 07AAAAA0000A1Z5" 
                                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-pharma-accent focus:bg-white @error('gst_number') border-red-500 @enderror">
                            @error('gst_number')
                                <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- 2 Columns: City & Pincode, Contact Person -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="city_pincode" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                City & Pincode <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="city_pincode" id="city_pincode" required value="{{ old('city_pincode') }}"
                                   placeholder="e.g., Ghaziabad, 201001" 
                                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-pharma-accent focus:bg-white @error('city_pincode') border-red-500 @enderror">
                            @error('city_pincode')
                                <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="contact_person" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Contact Person <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="contact_person" id="contact_person" required value="{{ old('contact_person') }}"
                                   placeholder="e.g., Ramesh Kumar" 
                                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-pharma-accent focus:bg-white @error('contact_person') border-red-500 @enderror">
                            @error('contact_person')
                                <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- WhatsApp Contact Number -->
                    <div>
                        <label for="phone" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            WhatsApp Contact Number <span class="text-slate-400 font-normal">(Optional / Recommended)</span>
                        </label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                               placeholder="e.g., 9876543210" 
                               class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-pharma-accent focus:bg-white @error('phone') border-red-500 @enderror">
                        @error('phone')
                            <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Mandatory Checkbox in Modal -->
                    <div class="pt-2">
                        <label class="flex items-start space-x-3 cursor-pointer p-3.5 bg-amber-50/70 border border-amber-200 rounded-xl hover:bg-amber-50 transition">
                            <input type="checkbox" name="dl_confirmed" id="dl_confirmed" required x-model="confirmed"
                                   class="mt-0.5 h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-slate-300 rounded shrink-0">
                            <span class="text-xs text-slate-800 font-semibold leading-relaxed">
                                I confirm that I represent a licensed retail pharmacy / medical establishment and hold a valid Drug License for purchasing pharmaceutical products. <span class="text-red-500">*</span>
                            </span>
                        </label>
                        @error('dl_confirmed')
                            <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Action buttons -->
                    <div class="pt-4 flex flex-col sm:flex-row gap-3">
                        <button type="button" @click="b2bModalOpen = false"
                                class="w-full sm:w-1/3 py-3 px-4 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-sm rounded-xl transition text-center">
                            Back to Cart
                        </button>
                        <button type="submit" :disabled="!confirmed"
                                class="w-full sm:w-2/3 py-3 px-6 bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 disabled:opacity-50 disabled:cursor-not-allowed text-white text-sm font-extrabold rounded-xl transition shadow-md flex justify-center items-center gap-2">
                            <span>Continue to WhatsApp</span>
                            <span>&rarr;</span>
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

</div>
@endsection
