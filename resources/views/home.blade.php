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
            <form action="{{ route('public.products.index') }}" method="GET" class="flex flex-col sm:flex-row gap-2">
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
        
        <div class="flex flex-wrap justify-center gap-6">
            @foreach($companies as $company)
                <a href="{{ route('public.products.index', ['company_id' => $company->id]) }}" class="group block text-center flex flex-col justify-center items-center h-full">
                    <div class="mx-auto mb-3 rounded-2xl flex items-center justify-center font-bold text-xl text-pharma-navy border border-slate-200 shadow-sm group-hover:border-pharma-gold group-hover:shadow-md group-hover:-translate-y-1 transition-all duration-300 overflow-hidden p-3" style="width: 160px; height: 96px; background-color: {{ $company->bg_color ?? '#ffffff' }};">
                        @if($company->logo)
                            <img src="{{ media_url($company->logo) }}" alt="{{ $company->name }}" class="w-full h-full object-contain">
                        @else
                            <span class="text-sm px-2 break-words">{{ $company->name }}</span>
                        @endif
                    </div>
                    <span class="inline-flex items-center justify-center text-xs font-bold text-pharma-gold group-hover:text-pharma-accent">
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
            <a href="{{ route('public.products.index') }}" class="mt-4 sm:mt-0 px-5 py-2.5 bg-white border border-slate-300 text-slate-700 font-semibold text-sm rounded-xl hover:bg-slate-100 hover:text-pharma-accent transition shadow-sm">
                Explore Full Catalog
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($products as $product)
                <div class="flex flex-col bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden hover:shadow-md transition duration-200">
                    <!-- Product Image/Icon -->
                    <div class="h-48 bg-slate-50 border-b border-slate-100 flex items-center justify-center text-5xl relative">
                        @if($product->image)
                            <img src="{{ media_url($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                        @else
                            💊
                        @endif
                    </div>
                    
                    <!-- Content -->
                    <div class="p-6 flex-grow flex flex-col">
                        <span class="text-[10px] font-bold text-pharma-gold uppercase tracking-wider">{{ $product->company?->name ?? 'N/A' }} | {{ $product->division?->name ?? 'N/A' }}</span>
                        <h3 class="text-lg font-bold text-slate-800 mt-1 truncate">
                            <a href="{{ route('public.products.show', $product->id) }}" class="hover:text-pharma-accent">{{ $product->name }}</a>
                        </h3>
                        <p class="text-xs text-slate-500 font-semibold mt-1">Composition: {{ Str::limit($product->composition, 40) }}</p>
                        <p class="text-xs text-slate-400 mt-2 italic">Packing: {{ $product->packing }}</p>

                        <!-- Salt Badge -->
                        @if($product->salt?->name)
                            <div class="mt-3">
                                <span class="inline-block text-[10px] font-semibold bg-slate-100 text-slate-600 px-2 py-0.5 rounded-md border border-slate-200">
                                    Salt: {{ $product->salt->name }}
                                </span>
                            </div>
                        @endif

                        <!-- Footer / Pricing & Cart -->
                        <div class="mt-6 pt-4 border-t border-slate-100 flex justify-between items-center mt-auto">
                            <div>
                                <span class="block text-[9px] uppercase font-bold text-slate-400">MRP Value</span>
                                <span class="text-lg font-extrabold text-pharma-navy">₹{{ number_format($product->mrp, 2) }}</span>
                            </div>
                            
                                <form action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="px-3.5 py-2 bg-pharma-accent hover:bg-pharma-navy text-white text-xs font-bold rounded-xl transition shadow-sm">
                                        Add +
                                    </button>
                                </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Mobile App Download CTA Section -->
<section id="download-app" class="relative overflow-hidden py-16 sm:py-24 bg-gradient-to-br from-slate-950 via-pharma-navy to-slate-900 text-white border-t border-slate-800">
    <!-- Ambient glow decorations -->
    <div class="absolute -top-24 -left-24 w-96 h-96 bg-pharma-accent/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-pharma-gold/15 rounded-full blur-3xl pointer-events-none"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            <!-- Left Column: Details, Disclaimer & Download Buttons (7 Cols) -->
            <div class="lg:col-span-7 flex flex-col justify-center text-center lg:text-left">
                
                <!-- Status Badges -->
                <div class="flex flex-wrap items-center justify-center lg:justify-start gap-2.5 mb-5">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-pharma-gold/20 text-pharma-gold border border-pharma-gold/30 uppercase tracking-wider">
                        📱 CPA Retailer App
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/20 text-emerald-400 border border-emerald-500/30">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        Official APK v1.0.0
                    </span>
                </div>

                <!-- Main Heading -->
                <h2 class="text-3xl sm:text-5xl font-extrabold tracking-tight font-display text-white leading-tight mb-4">
                    Order Wholesale Medicines <br class="hidden sm:inline">
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-sky-400 to-pharma-gold">
                        Directly From Your Mobile
                    </span>
                </h2>

                <p class="text-base sm:text-lg text-slate-300 mb-6 leading-relaxed max-w-2xl mx-auto lg:mx-0">
                    Experience faster bulk ordering, instant Strip & Box pricing, real-time dispatch tracking, and direct counter billing on the official Chitranshu Pharmaceuticals Agency mobile app.
                </p>

                <!-- ⚠️ Crucial Retailer Exclusivity Disclaimer -->
                <div class="mb-5 p-4 sm:p-5 rounded-2xl bg-amber-500/10 border border-amber-500/30 text-left backdrop-blur-sm shadow-inner">
                    <div class="flex items-start gap-3.5">
                        <span class="text-2xl flex-shrink-0 leading-none">⚠️</span>
                        <div class="text-xs sm:text-sm text-slate-200 leading-relaxed">
                            <strong class="text-amber-400 font-bold block mb-1 uppercase tracking-wide">
                                Notice: Strictly for Licensed Retailers & Chemists Only
                            </strong>
                            This mobile application is built exclusively for registered medical stores, pharmacies, and wholesale retail counters. <strong class="text-white">This app is NOT intended for individual patients or direct retail consumers.</strong>
                        </div>
                    </div>
                </div>

                <!-- 🔒 Direct Safe Download Note & Play Store Status -->
                <div class="mb-7 p-4 sm:p-5 rounded-2xl bg-sky-500/10 border border-sky-500/25 text-left backdrop-blur-sm">
                    <div class="flex items-start gap-3.5">
                        <span class="text-2xl flex-shrink-0 leading-none">🛡️</span>
                        <div class="text-xs sm:text-sm text-slate-200 leading-relaxed">
                            <strong class="text-sky-300 font-bold block mb-1">
                                100% Safe, Secure & Direct APK Download
                            </strong>
                            Currently, this app is available exclusively for direct download here from our official server. The package is digitally verified and safe to install. <span class="text-pharma-gold font-semibold">We are soon going live on the Google Play Store!</span>
                        </div>
                    </div>
                </div>

                <!-- Action Download & Coming Soon Buttons -->
                <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 mb-8">
                    <!-- Primary APK Download Button -->
                    <a href="{{ route('app.download') }}" 
                       class="w-full sm:w-auto inline-flex items-center justify-center gap-3.5 px-7 py-4 rounded-2xl font-bold text-white bg-gradient-to-r from-blue-600 via-pharma-accent to-blue-700 hover:from-blue-500 hover:to-blue-600 shadow-xl shadow-blue-900/40 hover:shadow-2xl hover:scale-[1.02] active:scale-[0.99] transition duration-200 group border border-sky-400/30">
                        <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center text-xl group-hover:rotate-6 transition-transform">
                            🤖
                        </div>
                        <div class="text-left">
                            <span class="block text-xs uppercase font-extrabold tracking-wider text-sky-200">Direct Download</span>
                            <span class="text-base sm:text-lg font-extrabold text-white leading-tight">Download Android APK</span>
                            <span class="block text-[11px] text-sky-200 font-medium">v1.0.0 • ~55 MB • Android 8.0+</span>
                        </div>
                        <svg class="w-6 h-6 text-white ml-1 group-hover:translate-y-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                    </a>

                    <!-- Google Play Store (Coming Soon) Badge -->
                    <div class="w-full sm:w-auto inline-flex items-center justify-center gap-3 px-6 py-3.5 rounded-2xl bg-slate-800/80 border border-slate-700/80 text-slate-400 relative overflow-hidden cursor-not-allowed">
                        <svg class="w-7 h-7 text-slate-400 flex-shrink-0" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M3.609 1.814L13.792 12 3.61 22.186a2.036 2.036 0 0 1-.22-.383A2.08 2.08 0 0 1 3.25 21V3c0-.312.046-.61.139-.884.062-.12.138-.22.22-.302zM14.852 13.06l2.353 2.353-11.75 6.78 9.397-9.133zm0-2.12L5.455 1.807l11.75 6.78-2.353 2.353zm1.06 1.06l3.36-1.94c.95-.55.95-1.45 0-2l-1.008-.582-2.352 2.352 2.352 2.352 1.008-.582c.95-.55.95-1.45 0-2l-3.36-1.94z"/>
                        </svg>
                        <div class="text-left">
                            <span class="block text-[10px] uppercase font-bold tracking-wider text-slate-400">Get it on</span>
                            <span class="text-sm font-bold text-slate-300">Google Play</span>
                        </div>
                        <span class="ml-2 px-2 py-0.5 text-[10px] font-bold rounded-full bg-pharma-gold/20 text-pharma-gold border border-pharma-gold/40">
                            Coming Soon
                        </span>
                    </div>
                </div>

                <!-- 3 Easy Install Steps -->
                <div class="pt-6 border-t border-slate-800/80 text-left">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3 text-center lg:text-left">
                        How to Install in 3 Easy Steps:
                    </h4>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-xs text-slate-300">
                        <div class="flex items-start gap-2.5 p-3 rounded-xl bg-slate-900/60 border border-slate-800">
                            <span class="w-5 h-5 rounded-full bg-pharma-accent text-white font-bold flex items-center justify-center text-[10px] flex-shrink-0 mt-0.5">1</span>
                            <span><strong>Tap Download:</strong> Save the <code class="text-sky-300 text-[11px]">CPA-Mobile.apk</code> file to your phone.</span>
                        </div>
                        <div class="flex items-start gap-2.5 p-3 rounded-xl bg-slate-900/60 border border-slate-800">
                            <span class="w-5 h-5 rounded-full bg-pharma-accent text-white font-bold flex items-center justify-center text-[10px] flex-shrink-0 mt-0.5">2</span>
                            <span><strong>Allow Source:</strong> Open file & enable <em>"Install unknown apps"</em> if prompted.</span>
                        </div>
                        <div class="flex items-start gap-2.5 p-3 rounded-xl bg-slate-900/60 border border-slate-800">
                            <span class="w-5 h-5 rounded-full bg-pharma-accent text-white font-bold flex items-center justify-center text-[10px] flex-shrink-0 mt-0.5">3</span>
                            <span><strong>Login & Order:</strong> Sign in with your chemist ID or register your store counter.</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Right Column: Interactive Phone Mockup with Screenshot (5 Cols) -->
            <div class="lg:col-span-5 flex justify-center items-center relative">
                
                <!-- Phone Mockup Frame -->
                <div class="relative w-full max-w-[280px] sm:max-w-[310px]">
                    
                    <!-- Decorative back glow -->
                    <div class="absolute -inset-4 bg-gradient-to-tr from-blue-600/30 to-amber-500/20 rounded-[48px] blur-2xl -z-10"></div>
                    
                    <!-- Hardware Phone Shell -->
                    <div class="relative rounded-[42px] p-3 bg-slate-900 border-4 border-slate-700/80 shadow-2xl shadow-black/80">
                        
                        <!-- Top Camera Punch Hole & Speaker -->
                        <div class="absolute top-5 left-1/2 -translate-x-1/2 flex items-center gap-2 z-20">
                            <div class="w-3.5 h-3.5 rounded-full bg-black border border-slate-800 flex items-center justify-center">
                                <div class="w-1.5 h-1.5 rounded-full bg-blue-950"></div>
                            </div>
                            <div class="w-12 h-1 rounded-full bg-slate-800"></div>
                        </div>

                        <!-- Screen Bezel -->
                        <div class="rounded-[32px] overflow-hidden bg-white border border-slate-800 shadow-inner">
                            <img src="{{ asset('images/app_screen_preview.png') }}" 
                                 alt="CPA Mobile App - Wholesale Medicine Catalog Preview" 
                                 class="w-full h-auto object-cover block select-none pointer-events-none"
                                 loading="lazy">
                        </div>

                        <!-- Bottom Home Indicator -->
                        <div class="w-24 h-1 bg-slate-700 rounded-full mx-auto mt-2.5 mb-1"></div>
                    </div>

                    <!-- Floating Feature Pill 1 (Top Right) -->
                    <div class="absolute -top-3 -right-3 bg-white/95 backdrop-blur-md text-pharma-navy px-3.5 py-2 rounded-2xl shadow-xl border border-slate-200/80 text-xs font-bold flex items-center gap-2 animate-bounce" style="animation-duration: 3s;">
                        <span class="text-base">💊</span>
                        <div>
                            <span class="block text-[10px] text-slate-500 uppercase font-semibold">Wholesale Pricing</span>
                            <span>Strip & Box Rates</span>
                        </div>
                    </div>

                    <!-- Floating Feature Pill 2 (Bottom Left) -->
                    <div class="absolute -bottom-3 -left-3 bg-white/95 backdrop-blur-md text-pharma-navy px-3.5 py-2 rounded-2xl shadow-xl border border-slate-200/80 text-xs font-bold flex items-center gap-2">
                        <span class="text-base">⚡</span>
                        <div>
                            <span class="block text-[10px] text-slate-500 uppercase font-semibold">Live Dispatch</span>
                            <span class="text-emerald-600 font-extrabold">Instant Tracking</span>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>
</section>
@endsection
