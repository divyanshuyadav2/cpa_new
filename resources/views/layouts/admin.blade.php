<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Panel - {{ setting('company_name', 'Chitranshu Pharmaceuticals Agency') }}</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN & Alpine.js -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'Outfit', 'sans-serif'],
                        display: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        pharma: {
                            navy: '#0f172a',
                            navyLight: '#1e293b',
                            accent: '#0284c7',
                            gold: '#d97706',
                            light: '#f0f9ff'
                        }
                    }
                }
            }
        }
    </script>
    
    <link rel="icon" type="image/png" href="{{ asset('images/cpa_logo_blue.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/cpa_logo_blue.png') }}">
    <style>[x-cloak]{display:none !important}</style>
</head>
<body class="h-full font-sans antialiased text-slate-800" x-data="{ sidebarOpen: false }" @keydown.window.escape="sidebarOpen = false">
@php
    $navPending = \App\Models\Order::withStatus('Pending')->count();
    $navApps = \App\Models\StockistApplication::where('status', 'Pending')->count();
@endphp

    <div class="flex h-screen overflow-hidden bg-slate-50">
        
        <!-- Sidebar Backdrop (Mobile) -->
        <div class="fixed inset-0 z-40 bg-slate-900/60 backdrop-blur-sm md:hidden"
             x-show="sidebarOpen"
             x-transition.opacity
             @click="sidebarOpen = false"
             style="display: none;"></div>

        <!-- Sidebar Navigation -->
        <aside class="fixed inset-y-0 left-0 z-50 flex flex-col w-64 bg-gradient-to-b from-pharma-navy to-slate-950 text-slate-300 transform md:translate-x-0 md:static md:flex-shrink-0 transition-transform duration-300 ease-in-out"
               :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
            
            <!-- Branding -->
            <div class="flex items-center justify-between px-6 py-5 bg-slate-950/20 border-b border-slate-800/60">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-2">
                    @if(setting('site_logo'))
                        <img src="{{ media_url(setting('site_logo')) }}" alt="Logo" class="w-9 h-9 object-contain rounded-lg">
                    @else
                        <img src="{{ asset('images/cpa_logo_white.png') }}" alt="Logo" class="w-9 h-9 object-contain">
                    @endif
                    <div>
                        <span class="block text-sm font-bold text-white tracking-wider uppercase leading-none">CPA Admin</span>
                        <span class="text-[9px] text-slate-400 font-semibold tracking-wider">{{ setting('company_name', 'Chitranshu Pharma') }}</span>
                    </div>
                </a>
                <!-- Close sidebar (Mobile) -->
                <button @click="sidebarOpen = false" class="text-slate-400 hover:text-white md:hidden text-2xl font-bold">×</button>
            </div>
            <!-- Navigation Links -->
            @php
                $icons = [
                    'dash'  => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
                    'cart'  => 'M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.3 2.3c-.6.6-.2 1.7.7 1.7H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z',
                    'doc'   => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.6a1 1 0 01.7.3l5.4 5.4a1 1 0 01.3.7V19a2 2 0 01-2 2z',
                    'pill'  => 'M19.4 4.6a4.5 4.5 0 00-6.4 0L4.6 13a4.5 4.5 0 006.4 6.4L19.4 11a4.5 4.5 0 000-6.4zM8.5 8.5l7 7',
                    'img'   => 'M4 16l4.6-4.6a2 2 0 012.8 0L16 16m-2-2l1.6-1.6a2 2 0 012.8 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z',
                    'build' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4',
                    'grid'  => 'M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z',
                    'flask' => 'M9 3h6m-5 0v6.2a2 2 0 01-.3 1L4.6 18a2 2 0 001.7 3h11.4a2 2 0 001.7-3l-5.1-7.8a2 2 0 01-.3-1V3',
                    'users' => 'M17 20h5v-2a3 3 0 00-5.4-1.9M17 20H7m10 0v-2c0-.7-.1-1.3-.4-1.9M7 20H2v-2a3 3 0 015.4-1.9M7 20v-2c0-.7.1-1.3.4-1.9m0 0a5 5 0 019.2 0M15 7a3 3 0 11-6 0 3 3 0 016 0z',
                    'cog'   => 'M10.3 4.3c.4-1.8 3-1.8 3.4 0a1.7 1.7 0 002.6 1.1c1.5-.9 3.3.8 2.4 2.4a1.7 1.7 0 001 2.6c1.8.4 1.8 3 0 3.4a1.7 1.7 0 00-1 2.6c.9 1.5-.8 3.3-2.4 2.4a1.7 1.7 0 00-2.6 1c-.4 1.8-3 1.8-3.4 0a1.7 1.7 0 00-2.6-1c-1.5.9-3.3-.8-2.4-2.4a1.7 1.7 0 00-1-2.6c-1.8-.4-1.8-3 0-3.4a1.7 1.7 0 001-2.6c-.9-1.5.8-3.3 2.4-2.4.9.5 2.4 0 2.6-1.1zM15 12a3 3 0 11-6 0 3 3 0 016 0z',
                ];
                $menu = [
                    'Overview' => [
                        ['Dashboard', 'admin.dashboard', 'admin/dashboard', 'dash', null],
                    ],
                    'Sales' => [
                        ['Orders', 'orders.index', 'admin/orders*', 'cart', $navPending > 0 ? [$navPending, 'bg-yellow-400 text-slate-900'] : null],
                        ['Applications', 'applications.index', 'admin/applications*', 'doc', $navApps > 0 ? [$navApps, 'bg-sky-400 text-slate-900'] : null],
                        ['Users & Accounts', 'admin.users.index', 'admin/users*', 'users', null],
                    ],
                    'Catalogue' => [
                        ['Products', 'products.index', 'admin/products', 'pill', null],
                        ['Image Fetcher', 'admin.product-images.index', 'admin/products/images*', 'img', ($missing = \App\Models\Product::where(fn($q) => $q->whereNull('image')->orWhere('image',''))->count()) > 0 ? [$missing, 'bg-red-500 text-white'] : null],
                        ['Companies', 'companies.index', 'admin/companies*', 'build', null],
                        ['Divisions', 'divisions.index', 'admin/divisions*', 'grid', null],
                        ['Salts', 'salts.index', 'admin/salts*', 'flask', null],
                    ],
                    'System' => [
                        ['Settings', 'admin.settings', 'admin/settings*', 'cog', null],
                    ],
                ];
            @endphp
            <nav class="flex-grow px-3 py-4 space-y-5 overflow-y-auto">
                @foreach($menu as $section => $items)
                    <div>
                        <div class="text-[10px] font-bold text-slate-500 uppercase tracking-widest px-3 mb-2">{{ $section }}</div>
                        <div class="space-y-0.5">
                            @foreach($items as [$label, $route, $pattern, $icon, $badge])
                                @php $active = Request::is($pattern); @endphp
                                <a href="{{ route($route) }}"
                                   class="group relative flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition {{ $active ? 'bg-white/10 text-white' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                                    @if($active)<span class="absolute left-0 top-2 bottom-2 w-1 rounded-r bg-pharma-gold"></span>@endif
                                    <svg class="w-5 h-5 mr-3 flex-shrink-0 {{ $active ? 'text-pharma-gold' : 'text-slate-500 group-hover:text-slate-300' }}" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $icons[$icon] }}"/></svg>
                                    {{ $label }}
                                    @if($badge)<span class="ml-auto {{ $badge[1] }} text-[10px] font-bold px-1.5 py-0.5 rounded-full">{{ $badge[0] }}</span>@endif
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </nav>

            <!-- Account -->
            <div class="p-3 border-t border-white/5">
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <div class="flex items-center justify-between px-3 py-2 rounded-lg bg-white/5">
                        <div class="flex items-center min-w-0">
                            <span class="w-8 h-8 rounded-full bg-pharma-accent text-white text-xs font-bold flex items-center justify-center flex-shrink-0">{{ strtoupper(substr(auth('admin')->user()->email ?? 'A', 0, 1)) }}</span>
                            <div class="ml-2.5 min-w-0">
                                <span class="block text-xs font-semibold text-white truncate">{{ auth('admin')->user()->email ?? 'Administrator' }}</span>
                                <span class="block text-[10px] text-slate-500">Administrator</span>
                            </div>
                        </div>
                        <button type="submit" title="Log out" class="p-1.5 text-slate-400 hover:text-white">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        </button>
                    </div>
                </form>
            </div>
        </aside>

        <!-- Main Workspace -->
        <div class="flex flex-col flex-1 overflow-hidden">
            
            <!-- Topbar (Mobile trigger) -->
            <header class="flex items-center justify-between px-6 py-4 bg-white border-b border-slate-200 md:hidden flex-shrink-0">
                <button @click="sidebarOpen = true" class="p-1 text-slate-500 hover:text-pharma-navy focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                <div class="text-sm font-bold text-pharma-navy">CPA Admin Panel</div>
                <div class="w-6 h-6"></div> <!-- Spacer for balance -->
            </header>

            <!-- Desktop top bar -->
            <header class="hidden md:flex items-center justify-between gap-4 px-6 py-3 bg-white/80 backdrop-blur border-b border-slate-200/70 flex-shrink-0">
                <form action="{{ route('orders.index') }}" method="GET" class="relative w-full max-w-md">
                    <input type="search" name="q" placeholder="Search orders by #id, customer or phone…" value="{{ request()->routeIs('orders.index') ? request('q') : '' }}"
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-9 pr-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pharma-accent focus:bg-white">
                    <svg class="w-4 h-4 absolute left-3 top-2.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 10a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </form>
                <div class="flex items-center gap-3 text-xs font-bold">
                    <a href="{{ route('home') }}" target="_blank" class="text-slate-500 hover:text-pharma-navy">View website ↗</a>
                    <a href="{{ route('products.create') }}" class="px-3 py-2 bg-pharma-navy text-white rounded-xl hover:bg-slate-700 transition">+ Add product</a>
                </div>
            </header>

            <!-- Content Area -->
            <main class="flex-grow p-4 sm:p-6 lg:p-8 overflow-y-auto bg-gradient-to-br from-slate-50 to-sky-50/40">
                
                <!-- Breadcrumbs & Dynamic Alerts -->
                <div class="max-w-7xl mx-auto">
                    @if(session('success'))
                        <div x-data x-init="setTimeout(() => $el.remove(), 6000)" class="p-4 mb-6 text-sm text-green-800 rounded-xl bg-green-50 border border-green-200 flex items-center justify-between shadow-sm animate-fadeIn" role="alert">
                            <div class="flex items-center space-x-2">
                                <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                <span class="font-semibold">{{ session('success') }}</span>
                            </div>
                            <button type="button" class="text-green-600 hover:text-green-800 font-bold" onclick="this.parentElement.remove()">×</button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="p-4 mb-6 text-sm text-red-800 rounded-xl bg-red-50 border border-red-200 flex items-center justify-between shadow-sm animate-fadeIn" role="alert">
                            <div class="flex items-center space-x-2">
                                <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                <span class="font-semibold">{{ session('error') }}</span>
                            </div>
                            <button type="button" class="text-red-600 hover:text-red-800 font-bold" onclick="this.parentElement.remove()">×</button>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>

    </div>

</body>
</html>
