@extends('layouts.pwa')

@section('title', 'Medicine Catalog & Ordering - Chitranshu Pharma')

@section('content')
<div x-data="pwaCart()" x-init="initCart()">
    
    <!-- Top Filter & Search Bar -->
    <div class="mb-4 space-y-2">
        <form action="{{ route('pwa.retailer.catalog') }}" method="GET" class="flex items-center space-x-2">
            <div class="relative flex-grow">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search medicine, salt..."
                       class="w-full pl-9 pr-4 py-2.5 bg-slate-800 border border-slate-700 rounded-2xl text-xs text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-sky-500">
                <span class="absolute left-3 top-2.5 text-slate-400 text-sm">🔍</span>
            </div>
            <button type="submit" class="bg-sky-600 hover:bg-sky-500 text-white text-xs font-bold px-4 py-2.5 rounded-2xl transition">
                Filter
            </button>
        </form>

        <!-- Company Select Pills -->
        <div class="flex items-center space-x-2 overflow-x-auto no-scrollbar py-1 text-xs">
            <a href="{{ route('pwa.retailer.catalog') }}"
               class="whitespace-nowrap px-3 py-1.5 rounded-xl border transition {{ !request('company_id') ? 'bg-sky-500/20 text-sky-300 border-sky-500/40 font-bold' : 'bg-slate-800 text-slate-400 border-slate-700 hover:text-white' }}">
                All Companies
            </a>
            @foreach($companies as $c)
                <a href="{{ route('pwa.retailer.catalog', ['company_id' => $c->id]) }}"
                   class="whitespace-nowrap px-3 py-1.5 rounded-xl border transition {{ request('company_id') == $c->id ? 'bg-sky-500/20 text-sky-300 border-sky-500/40 font-bold' : 'bg-slate-800 text-slate-400 border-slate-700 hover:text-white' }}">
                    {{ $c->name }}
                </a>
            @endforeach
        </div>
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

                    <!-- Add to Cart Controls (No Stock Restriction) -->
                    <div class="mt-3 flex items-center justify-between border-t border-slate-700/60 pt-2.5">
                        <span class="text-[10px] text-slate-400">PTR: ₹{{ number_format($product->ptr, 2) }}</span>

                        <div class="flex items-center space-x-1.5" x-data="{ qty: getItemQty({{ $product->id }}) }">
                            <template x-if="getItemQty({{ $product->id }}) > 0">
                                <div class="flex items-center space-x-1 bg-slate-900 border border-slate-700 rounded-xl p-0.5">
                                    <button @click="updateQty({{ $product->id }}, getItemQty({{ $product->id }}) - 1)"
                                            class="w-7 h-7 rounded-lg bg-slate-800 text-white font-bold text-sm flex items-center justify-center hover:bg-slate-700 active:scale-95 transition">
                                        -
                                    </button>
                                    <span class="w-7 text-center font-bold text-xs text-sky-400" x-text="getItemQty({{ $product->id }})"></span>
                                    <button @click="updateQty({{ $product->id }}, getItemQty({{ $product->id }}) + 1)"
                                            class="w-7 h-7 rounded-lg bg-slate-800 text-white font-bold text-sm flex items-center justify-center hover:bg-slate-700 active:scale-95 transition">
                                        +
                                    </button>
                                </div>
                            </template>

                            <template x-if="getItemQty({{ $product->id }}) === 0">
                                <button @click="addToCart({ id: {{ $product->id }}, name: '{{ addslashes($product->name) }}', packing: '{{ addslashes($product->packing ?? '') }}', price: {{ $price }} })"
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
                    <p class="text-xs text-slate-400">No stock limit restriction • Direct Order</p>
                </div>
                <button @click="showModal = false" class="text-slate-400 hover:text-white font-bold text-lg">✕</button>
            </div>

            <!-- Cart Items Summary -->
            <div class="space-y-2 mb-4 max-h-48 overflow-y-auto no-scrollbar pr-1">
                <template x-for="item in cart" :key="item.id">
                    <div class="flex items-center justify-between bg-slate-800/80 p-2.5 rounded-xl border border-slate-700/60 text-xs">
                        <div class="min-w-0 flex-grow pr-2">
                            <span class="font-bold text-white block truncate" x-text="item.name"></span>
                            <span class="text-[10px] text-slate-400" x-text="'₹' + item.price.toFixed(2) + ' x ' + item.qty"></span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="font-bold text-emerald-400" x-text="'₹' + (item.price * item.qty).toFixed(2)"></span>
                            <button @click="updateQty(item.id, 0)" class="text-red-400 hover:text-red-300 font-bold px-1.5 py-0.5 rounded bg-red-500/10">✕</button>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Total Price Badge -->
            <div class="flex items-center justify-between bg-slate-800 p-3 rounded-xl mb-4 text-xs font-bold text-white">
                <span>Grand Total:</span>
                <span class="text-base text-emerald-400">₹<span x-text="cartTotal.toFixed(2)"></span></span>
            </div>

            <!-- Customer Details Form -->
            <form @submit.prevent="submitOrder()">
                <div class="space-y-3 mb-5">
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

            getItemQty(id) {
                const found = this.cart.find(i => i.id === id);
                return found ? found.qty : 0;
            },

            addToCart(item) {
                const found = this.cart.find(i => i.id === item.id);
                if (found) {
                    found.qty += 1;
                } else {
                    this.cart.push({ ...item, qty: 1 });
                }
                this.saveCart();
            },

            updateQty(id, newQty) {
                if (newQty <= 0) {
                    this.cart = this.cart.filter(i => i.id !== id);
                } else {
                    const found = this.cart.find(i => i.id === id);
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
                    alert('Please enter counter name and contact phone.');
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
