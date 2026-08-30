@extends('layouts.pwa')

@section('title', 'Medicine Catalog & Ordering - Chitranshu Pharma')

@section('content')
<div x-data="pwaCart()" x-init="initCart()">
    
    <!-- Top Filter & Search Bar -->
    <div class="mb-4 space-y-2.5">
        <form action="{{ route('pwa.retailer.catalog') }}" method="GET" class="space-y-2">
            <div class="flex items-center space-x-2">
                <!-- Search Input -->
                <div class="relative flex-grow">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search medicine, salt..."
                           class="w-full pl-9 pr-3 py-2.5 bg-slate-800 border border-slate-700 rounded-2xl text-xs text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-sky-500">
                    <span class="absolute left-3 top-2.5 text-slate-400 text-sm">🔍</span>
                </div>

                <!-- Company Select Dropdown Filter -->
                <select name="company_id" onchange="this.form.submit()"
                        class="bg-slate-800 text-slate-200 border border-slate-700 text-xs rounded-2xl px-2.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-sky-500 max-w-[130px] truncate">
                    <option value="">🏢 All Companies</option>
                    @foreach($companies as $c)
                        <option value="{{ $c->id }}" {{ request('company_id') == $c->id ? 'selected' : '' }}>
                            {{ $c->name }}
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="bg-sky-600 hover:bg-sky-500 text-white text-xs font-bold px-3.5 py-2.5 rounded-2xl transition shrink-0">
                    Search
                </button>
            </div>
        </form>

        <!-- Company Select Pills -->
        <div class="flex items-center space-x-2 overflow-x-auto no-scrollbar py-0.5 text-xs">
            <a href="{{ route('pwa.retailer.catalog', array_filter(['search' => request('search')])) }}"
               class="whitespace-nowrap px-3 py-1.5 rounded-xl border transition {{ !request('company_id') ? 'bg-sky-500/20 text-sky-300 border-sky-500/40 font-bold' : 'bg-slate-800 text-slate-400 border-slate-700 hover:text-white' }}">
                All Companies
            </a>
            @foreach($companies as $c)
                <a href="{{ route('pwa.retailer.catalog', array_filter(['company_id' => $c->id, 'search' => request('search')])) }}"
                   class="whitespace-nowrap px-3 py-1.5 rounded-xl border transition {{ request('company_id') == $c->id ? 'bg-sky-500/20 text-sky-300 border-sky-500/40 font-bold' : 'bg-slate-800 text-slate-400 border-slate-700 hover:text-white' }}">
                    {{ $c->name }}
                </a>
            @endforeach
        </div>

        @if(request('search') || request('company_id'))
            <div class="flex items-center justify-between bg-slate-800/80 px-3 py-1.5 rounded-xl text-xs border border-slate-700">
                <div class="flex items-center space-x-2 text-slate-300">
                    <span>Filtering by:</span>
                    @if(request('search'))
                        <span class="font-bold text-sky-400">"{{ request('search') }}"</span>
                    @endif
                    @if(request('company_id'))
                        @php $comp = $companies->firstWhere('id', request('company_id')); @endphp
                        <span class="font-bold text-emerald-400">🏢 {{ $comp ? $comp->name : 'Company' }}</span>
                    @endif
                </div>
                <a href="{{ route('pwa.retailer.catalog') }}" class="text-red-400 font-bold hover:underline text-[11px]">
                    Clear Filter ✕
                </a>
            </div>
        @endif
    </div>

    <!-- Product Grid / List -->
    <div class="space-y-3">
        @forelse($products as $product)
            @php
                $price = $product->ptr > 0 ? $product->ptr : ($product->mrp > 0 ? $product->mrp : 0);
            @endphp
            <div class="bg-slate-800/80 border border-slate-700/60 rounded-2xl p-4 shadow-sm flex items-start space-x-3 hover:border-slate-600 transition">
                <!-- Product Image -->
                <div class="w-16 h-16 rounded-xl bg-slate-900 border border-slate-700 flex-shrink-0 overflow-hidden flex items-center justify-center">
                    @if($product->image)
                        <img src="{{ media_url($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    @else
                        <span class="text-2xl">💊</span>
                    @endif
                </div>

                <!-- Product Details -->
                <div class="flex-grow min-w-0">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="text-sm font-bold text-white truncate leading-snug">{{ $product->name }}</h3>
                            <p class="text-[11px] text-sky-400 font-semibold">{{ $product->company ? $product->company->name : 'General' }}</p>
                        </div>
                        <span class="text-xs font-black text-emerald-400 bg-emerald-500/10 px-2 py-0.5 rounded-lg border border-emerald-500/20">
                            ₹{{ number_format($price, 2) }}
                        </span>
                    </div>

                    @if($product->composition)
                        <p class="text-[10px] text-slate-400 truncate mt-1">🧪 {{ $product->composition }}</p>
                    @endif

                    <div class="mt-2 flex items-center justify-between text-[11px] text-slate-400">
                        <span>Pack: <strong>{{ $product->packing ?? 'N/A' }}</strong></span>
                        <span>MRP: <del>₹{{ number_format($product->mrp, 2) }}</del></span>
                    </div>

                    <!-- Add to Cart & Unit Controls -->
                    <div class="mt-3 flex flex-wrap items-center justify-between gap-2 border-t border-slate-700/60 pt-2.5" x-data="{ selectedUnit: 'Box' }">
                        <!-- Unit Selector (Box Default vs Strip) -->
                        <div class="flex items-center space-x-1 bg-slate-900/90 border border-slate-700/80 p-0.5 rounded-xl text-[10px] font-bold">
                            <button type="button" @click="selectedUnit = 'Box'"
                                    :class="selectedUnit === 'Box' ? 'bg-sky-600 text-white shadow' : 'text-slate-400 hover:text-white'"
                                    class="px-2 py-1 rounded-lg transition">
                                📦 Box
                            </button>
                            <button type="button" @click="selectedUnit = 'Strip'"
                                    :class="selectedUnit === 'Strip' ? 'bg-amber-600 text-white shadow' : 'text-slate-400 hover:text-white'"
                                    class="px-2 py-1 rounded-lg transition">
                                💊 Strip
                            </button>
                        </div>

                        <!-- Quantity Controls -->
                        <div class="flex items-center space-x-1.5">
                            <template x-if="getItemQty({{ $product->id }}, selectedUnit) > 0">
                                <div class="flex items-center space-x-1 bg-slate-900 border border-slate-700 rounded-xl p-0.5">
                                    <button @click="updateQty({{ $product->id }}, selectedUnit, getItemQty({{ $product->id }}, selectedUnit) - 1)"
                                            class="w-7 h-7 rounded-lg bg-slate-800 text-white font-bold text-sm flex items-center justify-center hover:bg-slate-700 active:scale-95 transition">
                                        -
                                    </button>
                                    <span class="w-7 text-center font-bold text-xs text-sky-400" x-text="getItemQty({{ $product->id }}, selectedUnit)"></span>
                                    <button @click="updateQty({{ $product->id }}, selectedUnit, getItemQty({{ $product->id }}, selectedUnit) + 1)"
                                            class="w-7 h-7 rounded-lg bg-slate-800 text-white font-bold text-sm flex items-center justify-center hover:bg-slate-700 active:scale-95 transition">
                                        +
                                    </button>
                                </div>
                            </template>

                            <template x-if="getItemQty({{ $product->id }}, selectedUnit) === 0">
                                <button @click="addToCart({ id: {{ $product->id }}, name: '{{ addslashes($product->name) }}', packing: '{{ addslashes($product->packing ?? '') }}', price: {{ $price }} }, selectedUnit)"
                                        class="bg-sky-600 hover:bg-sky-500 text-white text-xs font-bold px-3 py-1.5 rounded-xl shadow active:scale-95 transition flex items-center space-x-1">
                                    <span>+ Add Order</span>
                                </button>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-12 bg-slate-800/40 rounded-3xl border border-slate-800 text-slate-400">
                <span class="text-4xl block mb-2">🔍</span>
                <p class="text-sm font-semibold">No medicines found.</p>
                <p class="text-xs text-slate-500 mt-1">Try searching with a different product or company name.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $products->appends(request()->query())->links() }}
    </div>

    <!-- Floating Checkout Drawer Button -->
    <div class="fixed bottom-16 right-4 z-40" x-show="cartCount > 0" x-transition>
        <button @click="showModal = true"
                class="bg-gradient-to-r from-sky-500 to-emerald-500 text-white font-extrabold text-xs px-5 py-3 rounded-full shadow-2xl flex items-center space-x-3 active:scale-95 transition">
            <span class="bg-white text-sky-700 w-6 h-6 rounded-full flex items-center justify-center font-bold text-xs" x-text="cartCount"></span>
            <span>View Order (₹<span x-text="cartTotal.toFixed(2)"></span>)</span>
            <span>&rarr;</span>
        </button>
    </div>

    <!-- Order Checkout Modal Drawer -->
    <div class="fixed inset-0 z-50 bg-black/70 backdrop-blur-sm flex items-end sm:items-center justify-center p-0 sm:p-4"
         x-show="showModal" x-transition.opacity style="display: none;">
        <div class="bg-slate-900 border border-slate-800 w-full max-w-md rounded-t-3xl sm:rounded-3xl p-6 shadow-2xl max-h-[90vh] overflow-y-auto"
             @click.away="showModal = false">
            
            <div class="flex items-center justify-between border-b border-slate-800 pb-3 mb-4">
                <div>
                    <h2 class="text-lg font-extrabold text-white">Review Medicine Order</h2>
                    <p class="text-xs text-slate-400">Direct Order • Box & Strip Units</p>
                </div>
                <button @click="showModal = false" class="text-slate-400 hover:text-white font-bold text-lg">✕</button>
            </div>

            <!-- Cart Items Summary -->
            <div class="space-y-2 mb-4 max-h-48 overflow-y-auto no-scrollbar pr-1">
                <template x-for="item in cart" :key="item.id + '_' + item.unit">
                    <div class="flex items-center justify-between bg-slate-800/80 p-2.5 rounded-xl border border-slate-700/60 text-xs">
                        <div class="min-w-0 flex-grow pr-2">
                            <div class="flex items-center space-x-1.5">
                                <span class="font-bold text-white block truncate" x-text="item.name"></span>
                                <span class="text-[10px] font-extrabold px-1.5 py-0.5 rounded border"
                                      :class="item.unit === 'Strip' ? 'bg-amber-500/20 text-amber-300 border-amber-500/30' : 'bg-sky-500/20 text-sky-300 border-sky-500/30'"
                                      x-text="item.unit"></span>
                            </div>
                            <span class="text-[10px] text-slate-400" x-text="'₹' + item.price.toFixed(2) + ' x ' + item.qty + ' ' + (item.unit || 'Box') + '(s)'"></span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="font-bold text-emerald-400" x-text="'₹' + (item.price * item.qty).toFixed(2)"></span>
                            <button @click="updateQty(item.id, item.unit, 0)" class="text-red-400 hover:text-red-300 font-bold px-1.5 py-0.5 rounded bg-red-500/10">✕</button>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Total Price Badge -->
            <div class="flex items-center justify-between bg-slate-800 p-3 rounded-xl mb-4 text-xs font-bold text-white">
                <span>Grand Total:</span>
                <span class="text-base text-emerald-400">₹<span x-text="cartTotal.toFixed(2)"></span></span>
            </div>

            <!-- Customer Details Form (Auto-filled for Logged in Users) -->
            <form @submit.prevent="submitOrder()">
                <div class="space-y-3 mb-5">
                    @auth
                        <div class="bg-slate-800/90 border border-slate-700 p-3 rounded-xl text-xs space-y-1">
                            <div class="flex justify-between items-center">
                                <span class="text-slate-400">Ordering Account:</span>
                                <span class="font-bold text-sky-400" x-text="customerName"></span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-slate-400">Contact Number:</span>
                                <span class="font-bold text-emerald-400" x-text="customerPhone || 'Not set'"></span>
                            </div>
                        </div>
                        <template x-if="!customerPhone">
                            <div>
                                <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-300 mb-1">Contact Phone Number</label>
                                <input type="text" x-model="customerPhone" required placeholder="Enter Mobile Number"
                                       class="w-full px-3.5 py-2.5 bg-slate-800 border border-slate-700 rounded-xl text-xs text-white focus:outline-none focus:ring-2 focus:ring-sky-500">
                            </div>
                        </template>
                    @else
                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-300 mb-1">Counter / Customer Name</label>
                            <input type="text" x-model="customerName" required placeholder="Counter / Retailer Shop Name"
                                   class="w-full px-3.5 py-2.5 bg-slate-800 border border-slate-700 rounded-xl text-xs text-white focus:outline-none focus:ring-2 focus:ring-sky-500">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-300 mb-1">Contact Phone</label>
                            <input type="text" x-model="customerPhone" required placeholder="Mobile Number"
                                   class="w-full px-3.5 py-2.5 bg-slate-800 border border-slate-700 rounded-xl text-xs text-white focus:outline-none focus:ring-2 focus:ring-sky-500">
                        </div>
                    @endauth

                    <!-- Order Notes / Special Instructions -->
                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-300 mb-1">📝 Order Notes / Special Instructions (Optional)</label>
                        <textarea x-model="orderNotes" rows="2" placeholder="e.g. Please deliver after 5 PM, or urgent batch requirement..."
                                  class="w-full px-3.5 py-2 bg-slate-800 border border-slate-700 rounded-xl text-xs text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-sky-500"></textarea>
                    </div>
                </div>

                <button type="submit" :disabled="submitting"
                        class="w-full py-3.5 bg-gradient-to-r from-emerald-500 to-sky-500 hover:from-emerald-400 hover:to-sky-400 text-white font-extrabold text-xs rounded-xl shadow-lg active:scale-95 transition flex items-center justify-center space-x-2">
                    <span x-show="!submitting">🚀 Confirm & Place Order Now</span>
                    <span x-show="submitting">Processing Order...</span>
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function pwaCart() {
        return {
            cart: [],
            showModal: false,
            customerName: '{{ Auth::check() ? (Auth::user()->company_name ?: Auth::user()->name) : "" }}',
            customerPhone: '{{ Auth::check() ? Auth::user()->phone : "" }}',
            orderNotes: '',
            submitting: false,

            initCart() {
                const saved = localStorage.getItem('cpa_pwa_cart');
                if (saved) {
                    try { this.cart = JSON.parse(saved); } catch(e) { this.cart = []; }
                }
            },

            saveCart() {
                localStorage.setItem('cpa_pwa_cart', JSON.stringify(this.cart));
            },

            getItemQty(id, unit = 'Box') {
                const found = this.cart.find(i => i.id === id && (i.unit || 'Box') === unit);
                return found ? found.qty : 0;
            },

            addToCart(item, unit = 'Box') {
                const found = this.cart.find(i => i.id === item.id && (i.unit || 'Box') === unit);
                if (found) {
                    found.qty += 1;
                } else {
                    this.cart.push({ ...item, unit: unit, qty: 1 });
                }
                this.saveCart();
            },

            updateQty(id, unit = 'Box', newQty) {
                if (newQty <= 0) {
                    this.cart = this.cart.filter(i => !(i.id === id && (i.unit || 'Box') === unit));
                } else {
                    const found = this.cart.find(i => i.id === id && (i.unit || 'Box') === unit);
                    if (found) found.qty = newQty;
                }
                this.saveCart();
            },

            get cartCount() {
                return this.cart.reduce((sum, i) => sum + i.qty, 0);
            },

            get cartTotal() {
                return this.cart.reduce((sum, i) => sum + (i.price * i.qty), 0);
            },

            async submitOrder() {
                if (this.cart.length === 0) return;
                if (!this.customerName || !this.customerPhone) {
                    alert('Please enter or confirm contact phone number.');
                    return;
                }

                this.submitting = true;

                try {
                    const res = await fetch('{{ route("pwa.retailer.checkout") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            customer_name: this.customerName,
                            phone: this.customerPhone,
                            notes: this.orderNotes,
                            cart: this.cart
                        })
                    });

                    const data = await res.json();
                    if (data.success) {
                        this.cart = [];
                        this.saveCart();
                        alert(data.message);
                        window.location.href = data.redirect_url;
                    } else {
                        alert(data.message || 'Error placing order');
                    }
                } catch (e) {
                    alert('Server error placing order. Please try again.');
                } finally {
                    this.submitting = false;
                }
            }
        }
    }
</script>
@endsection
