<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#0284c7">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="CPA Portal">

    <title>@yield('title', setting('company_name', 'Chitranshu Pharma Portal'))</title>
    
    <!-- PWA Manifest & Icons -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="apple-touch-icon" href="{{ asset('favicon.svg') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN & Alpine.js -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        pharma: {
                            navy: '#0f172a',
                            accent: '#0284c7',
                            light: '#f0f9ff',
                            success: '#10b981',
                            warning: '#f59e0b',
                            danger: '#ef4444'
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Outfit', sans-serif; -webkit-tap-highlight-color: transparent; }
        /* Hide scrollbars for slick mobile UI */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="h-full bg-slate-900 text-slate-800 flex flex-col justify-between min-h-screen pb-20">

    <!-- Top App Navigation -->
    <header class="sticky top-0 z-40 bg-slate-900/90 backdrop-blur-md border-b border-slate-800 text-white px-4 py-3 shadow-md">
        <div class="max-w-md mx-auto flex items-center justify-between">
            <a href="{{ Auth::check() ? (Auth::user()->role === 'salesman' ? route('pwa.salesman.dashboard') : route('pwa.retailer.catalog')) : route('pwa.login') }}" class="flex items-center space-x-2.5">
                @if(setting('site_logo'))
                    <img src="{{ media_url(setting('site_logo')) }}" alt="Logo" class="h-8 w-auto object-contain bg-white/10 rounded p-1">
                @else
                    <div class="w-8 h-8 rounded-xl bg-gradient-to-tr from-sky-500 to-emerald-400 flex items-center justify-center font-black text-white text-sm shadow">
                        CP
                    </div>
                @endif
                <div>
                    <span class="font-bold text-sm text-white tracking-wide block leading-none">Chitranshu Pharma</span>
                    <span class="text-[10px] text-sky-400 font-medium">Ordering Portal</span>
                </div>
            </a>

            @auth
                <div class="flex items-center space-x-3">
                    <span class="text-xs px-2.5 py-1 rounded-full font-bold uppercase tracking-wider {{ Auth::user()->role === 'salesman' ? 'bg-amber-500/20 text-amber-300 border border-amber-500/30' : 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30' }}">
                        {{ Auth::user()->role }}
                    </span>
                    <form action="{{ route('pwa.logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" title="Logout" class="p-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-400 hover:text-red-400 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        </button>
                    </form>
                </div>
            @else
                <a href="{{ route('pwa.login') }}" class="text-xs bg-sky-600 hover:bg-sky-500 text-white font-bold px-3 py-1.5 rounded-xl transition">
                    Login
                </a>
            @endauth
        </div>
    </header>

    <!-- PWA Install Prompt Banner -->
    <div id="pwa-install-banner" class="hidden bg-sky-600 text-white px-4 py-2 text-xs flex items-center justify-between sticky top-[57px] z-30 shadow-md">
        <div class="flex items-center space-x-2">
            <span class="text-lg">📲</span>
            <span>Install <strong>CPA App</strong> for fast ordering!</span>
        </div>
        <button id="pwa-install-btn" class="bg-white text-sky-700 font-bold px-3 py-1 rounded-lg text-xs shadow">Install</button>
    </div>

    <!-- Main Content Container -->
    <main class="flex-grow max-w-md mx-auto w-full px-4 py-4">
        <!-- Flash Messages -->
        @if(session('success'))
            <div class="mb-4 bg-emerald-500/10 border border-emerald-500/30 text-emerald-300 text-xs rounded-xl p-3.5 flex items-center justify-between" x-data="{ show: true }" x-show="show">
                <div class="flex items-center space-x-2">
                    <span class="text-base">✅</span>
                    <span>{{ session('success') }}</span>
                </div>
                <button @click="show = false" class="text-emerald-400 font-bold">✕</button>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 bg-red-500/10 border border-red-500/30 text-red-300 text-xs rounded-xl p-3.5 flex items-center justify-between" x-data="{ show: true }" x-show="show">
                <div class="flex items-center space-x-2">
                    <span class="text-base">⚠️</span>
                    <span>{{ session('error') }}</span>
                </div>
                <button @click="show = false" class="text-red-400 font-bold">✕</button>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Bottom Navigation Bar for PWA Mobile Experience -->
    @auth
        <nav class="fixed bottom-0 left-0 right-0 z-40 bg-slate-900/95 backdrop-blur-lg border-t border-slate-800 px-4 py-2 shadow-lg">
            <div class="max-w-md mx-auto flex items-center justify-around text-xs font-semibold text-slate-400">
                @if(Auth::user()->role === 'retailer')
                    <a href="{{ route('pwa.retailer.catalog') }}" class="flex flex-col items-center py-1 px-3 rounded-xl {{ request()->routeIs('pwa.retailer.catalog') ? 'text-sky-400 font-bold' : 'hover:text-white' }}">
                        <span class="text-lg">💊</span>
                        <span>Catalog</span>
                    </a>
                    <a href="{{ route('pwa.retailer.orders') }}" class="flex flex-col items-center py-1 px-3 rounded-xl {{ request()->routeIs('pwa.retailer.orders') ? 'text-sky-400 font-bold' : 'hover:text-white' }}">
                        <span class="text-lg">📦</span>
                        <span>My Orders</span>
                    </a>
                @elseif(Auth::user()->role === 'salesman')
                    <a href="{{ route('pwa.salesman.dashboard') }}" class="flex flex-col items-center py-1 px-3 rounded-xl {{ request()->routeIs('pwa.salesman.dashboard') ? 'text-sky-400 font-bold' : 'hover:text-white' }}">
                        <span class="text-lg">👔</span>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('pwa.retailer.catalog') }}" class="flex flex-col items-center py-1 px-3 rounded-xl {{ request()->routeIs('pwa.retailer.catalog') ? 'text-sky-400 font-bold' : 'hover:text-white' }}">
                        <span class="text-lg">🛒</span>
                        <span>New Order</span>
                    </a>
                @endif
                <a href="{{ route('home') }}" target="_blank" class="flex flex-col items-center py-1 px-3 rounded-xl hover:text-white">
                    <span class="text-lg">🌐</span>
                    <span>Website</span>
                </a>
            </div>
        </nav>
    @endauth

    <!-- Service Worker & PWA Install Script -->
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js').then((reg) => {
                    console.log('PWA Service Worker registered:', reg.scope);
                }).catch((err) => {
                    console.log('PWA Service Worker registration failed:', err);
                });
            });
        }

        let deferredPrompt;
        const banner = document.getElementById('pwa-install-banner');
        const btn = document.getElementById('pwa-install-btn');

        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;
            if (banner) banner.classList.remove('hidden');
        });

        if (btn) {
            btn.addEventListener('click', () => {
                if (deferredPrompt) {
                    deferredPrompt.prompt();
                    deferredPrompt.userChoice.then((choiceResult) => {
                        if (choiceResult.outcome === 'accepted') {
                            console.log('User accepted PWA install');
                        }
                        deferredPrompt = null;
                        if (banner) banner.classList.add('hidden');
                    });
                }
            });
        }
    </script>
    @yield('scripts')
</body>
</html>
