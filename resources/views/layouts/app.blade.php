<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', setting('company_name', 'Chitranshu Pharmaceuticals Agency'))</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex flex-col h-full font-sans antialiased text-slate-800" x-data="{ cartOpen: false }">

    <!-- Top Info Bar -->
    <div class="py-2 bg-pharma-navy text-pharma-light text-xs font-medium">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8 flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <span>📞 {{ setting('phone', '8299770727') }}</span>
                <span class="hidden sm:inline">✉️ {{ setting('email', 'info@chitranshupharma.com') }}</span>
            </div>
            <div class="flex items-center space-x-4">
                <span>GSTIN: <span class="text-pharma-gold font-bold">{{ setting('gst_number', '23AAAAA1111A1Z1') }}</span></span>
            </div>
        </div>
    </div>

    <!-- Header Navigation -->
    <header class="sticky top-0 z-40 bg-white/90 backdrop-blur-md border-b border-slate-200">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16 sm:h-20">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center space-x-2">
                    <div class="flex items-center justify-center w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-gradient-to-br from-pharma-accent to-pharma-navy text-white shadow-md">
                        <span class="text-xl sm:text-2xl font-bold font-display">C</span>
                    </div>
                    <div>
                        <span class="block text-lg sm:text-xl font-bold tracking-tight text-pharma-navy leading-none">Chitranshu</span>
                        <span class="text-[10px] sm:text-xs text-pharma-gold font-semibold uppercase tracking-wider">Pharmaceuticals</span>
                    </div>
                </a>

                <!-- Desktop Nav Links -->
                <nav class="hidden md:flex items-center space-x-8 text-sm font-semibold text-slate-600">
                    <a href="{{ route('home') }}" class="hover:text-pharma-accent transition">Home</a>
                    <a href="{{ route('products.index') }}" class="hover:text-pharma-accent transition">Products Catalog</a>
                    <a href="{{ route('about') }}" class="hover:text-pharma-accent transition">About & Contact</a>
                    <a href="{{ route('cart.view') }}" class="hover:text-pharma-accent transition">Review Cart</a>
                </nav>

                <!-- Action Buttons -->
                <div class="flex items-center space-x-4">
                    <!-- Products Search Button (Mobile Shortcut) -->
                    <a href="{{ route('products.index') }}" class="p-2 text-slate-400 hover:text-pharma-accent md:hidden" title="Search Products">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </a>

                    <!-- Cart Trigger Button -->
                    <button @click="cartOpen = true" class="relative flex items-center justify-center p-2.5 rounded-xl border border-slate-200 bg-slate-50 hover:bg-slate-100 hover:border-slate-300 transition duration-150 group">
                        <svg class="w-6 h-6 text-slate-600 group-hover:text-pharma-accent transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        @php
                            $cart = session()->get('cart', []);
                            $cartCount = collect($cart)->sum('qty');
                        @endphp
                        @if($cartCount > 0)
                            <span class="absolute -top-1.5 -right-1.5 flex h-5 w-5 items-center justify-center rounded-full bg-pharma-accent text-[10px] font-bold text-white shadow-sm animate-pulse">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Flash Messages Container -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        @if(session('success'))
            <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 border border-green-200 flex items-center justify-between shadow-sm animate-fadeIn" role="alert">
                <div class="flex items-center space-x-2">
                    <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    <span class="font-semibold">{{ session('success') }}</span>
                </div>
                <button type="button" class="text-green-600 hover:text-green-800 font-bold" onclick="this.parentElement.remove()">×</button>
            </div>
        @endif

        @if(session('error'))
            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 border border-red-200 flex items-center justify-between shadow-sm animate-fadeIn" role="alert">
                <div class="flex items-center space-x-2">
                    <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                    <span class="font-semibold">{{ session('error') }}</span>
                </div>
                <button type="button" class="text-red-600 hover:text-red-800 font-bold" onclick="this.parentElement.remove()">×</button>
            </div>
        @endif
    </div>

    <!-- Main Content Area -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="mt-auto bg-pharma-navy text-slate-300">
        <div class="px-4 py-12 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Branding -->
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-gradient-to-br from-pharma-accent to-pharma-navy text-white font-bold">C</div>
                        <span class="text-lg font-bold text-white tracking-wider">{{ setting('company_name', 'Chitranshu Pharmaceuticals Agency') }}</span>
                    </div>
                    <p class="text-sm text-slate-400 leading-relaxed">
                        {{ setting('tagline', 'Your Trusted Pharmaceutical Distribution Partner') }}
                    </p>
                </div>
                <!-- Links -->
                <div>
                    <h3 class="text-sm font-semibold uppercase tracking-wider text-pharma-gold mb-4">Quick Links</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('home') }}" class="hover:text-white transition">Home</a></li>
                        <li><a href="{{ route('products.index') }}" class="hover:text-white transition">Products Catalog</a></li>
                        <li><a href="{{ route('about') }}" class="hover:text-white transition">About & Contact</a></li>
                        <li><a href="{{ route('cart.view') }}" class="hover:text-white transition">Review Shopping Cart</a></li>
                    </ul>
                </div>
                <!-- Contact info -->
                <div>
                    <h3 class="text-sm font-semibold uppercase tracking-wider text-pharma-gold mb-4">Contact Information</h3>
                    <address class="not-italic space-y-2 text-sm text-slate-400">
                        <p>📍 {{ setting('address', 'Nathupur Bhullanpur P.A.C Varanasi') }}</p>
                        <p>📞 Phone: {{ setting('phone', '8299770727') }}</p>
                        <p>✉️ Email: {{ setting('email', 'info@chitranshupharma.com') }}</p>
                        <p class="text-xs pt-2">GSTIN: <span class="text-white font-semibold">{{ setting('gst_number', '23AAAAA1111A1Z1') }}</span></p>
                    </address>
                </div>
            </div>
            <div class="mt-8 pt-8 border-t border-slate-800 text-center text-xs text-slate-500">
                <p>&copy; {{ date('Y') }} {{ setting('company_name', 'Chitranshu Pharmaceuticals Agency') }}. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Interactive Cart Drawer (Alpine.js) -->
    <div class="relative z-50" x-show="cartOpen" x-transition.opacity style="display: none;">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="cartOpen = false"></div>

        <!-- Drawer Content -->
        <div class="fixed inset-y-0 right-0 flex max-w-full pl-10">
            <div class="w-screen max-w-md bg-white shadow-2xl flex flex-col h-full"
                 x-show="cartOpen"
                 x-transition:enter="transform transition ease-in-out duration-300 sm:duration-500"
                 x-transition:enter-start="translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transform transition ease-in-out duration-300 sm:duration-500"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="translate-x-full">
                 
                <!-- Drawer Header -->
                <div class="px-6 py-5 bg-gradient-to-r from-pharma-navy to-pharma-accent text-white flex justify-between items-center shadow-md">
                    <h2 class="text-lg font-bold flex items-center space-x-2">
                        <span>🛒 Shopping Cart</span>
                        <span class="text-xs bg-pharma-gold text-pharma-navy font-bold px-2 py-0.5 rounded-full">{{ $cartCount }} Items</span>
                    </h2>
                    <button @click="cartOpen = false" class="text-white hover:text-pharma-gold font-semibold text-2xl transition">×</button>
                </div>

                <!-- Drawer Body / Item List -->
                <div class="flex-1 overflow-y-auto px-6 py-4">
                    @if(empty($cart))
                        <div class="flex flex-col items-center justify-center h-full text-center py-12">
                            <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center text-slate-400 mb-4 text-3xl">🛒</div>
                            <h3 class="text-lg font-bold text-slate-700">Your cart is empty</h3>
                            <p class="text-sm text-slate-500 mt-1 max-w-xs">Explore our catalog and add products to start compiling your order.</p>
                            <a href="{{ route('products.index') }}" @click="cartOpen = false" class="mt-6 px-5 py-2.5 bg-pharma-accent text-white rounded-xl text-sm font-semibold hover:bg-pharma-navy transition">Browse Products</a>
                        </div>
                    @else
                        <div class="divide-y divide-slate-100">
                            @php $drawerTotal = 0; @endphp
                            @foreach($cart as $item)
                                @php $drawerTotal += $item['qty'] * $item['price']; @endphp
                                <div class="py-4 flex items-start space-x-3">
                                    <!-- Image (if any) -->
                                    <div class="w-16 h-16 bg-slate-100 rounded-lg flex-shrink-0 flex items-center justify-center text-slate-400 overflow-hidden border border-slate-200">
                                        @if($item['image'])
                                            <img src="{{ asset('storage/' . $item['image']) }}" class="w-full h-full object-cover">
                                        @else
                                            💊
                                        @endif
                                    </div>
                                    <!-- Details -->
                                    <div class="flex-grow">
                                        <h4 class="text-sm font-bold text-slate-800 leading-tight">{{ $item['name'] }}</h4>
                                        <p class="text-xs text-slate-500">{{ $item['packing'] }} | {{ $item['company'] }}</p>
                                        <p class="text-xs text-pharma-accent font-semibold mt-1">Composition: {{ Str::limit($item['composition'], 35) }}</p>
                                        
                                        <!-- Qty & Price -->
                                        <div class="flex justify-between items-center mt-2">
                                            <span class="text-xs font-semibold text-slate-600">{{ $item['qty'] }} x ₹{{ number_format($item['price'], 2) }}</span>
                                            <span class="text-sm font-bold text-slate-900">₹{{ number_format($item['qty'] * $item['price'], 2) }}</span>
                                        </div>
                                    </div>
                                    <!-- Remove -->
                                    <form action="{{ route('cart.remove') }}" method="POST" class="flex-shrink-0">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $item['id'] }}">
                                        <button type="submit" class="text-slate-400 hover:text-red-500 transition text-sm">✕</button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Drawer Footer -->
                @if(!empty($cart))
                    <div class="px-6 py-6 border-t border-slate-200 bg-slate-50">
                        <div class="flex justify-between items-center mb-6">
                            <span class="text-base font-bold text-slate-600">Total Invoice Amount:</span>
                            <span class="text-xl font-extrabold text-pharma-navy">₹{{ number_format($drawerTotal, 2) }}</span>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <a href="{{ route('cart.view') }}" @click="cartOpen = false" class="block text-center py-3 bg-white border border-slate-300 rounded-xl text-sm font-bold text-slate-700 hover:bg-slate-100 transition shadow-sm">Review Cart</a>
                            <a href="{{ route('cart.view') }}#checkout" @click="cartOpen = false" class="block text-center py-3 bg-gradient-to-r from-pharma-accent to-pharma-navy rounded-xl text-sm font-bold text-white hover:opacity-95 transition shadow-md">Checkout Form</a>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>

</body>
</html>
