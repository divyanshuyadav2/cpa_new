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
    
    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans antialiased text-slate-800" x-data="{ sidebarOpen: false }">

    <div class="flex h-screen overflow-hidden bg-slate-50">
        
        <!-- Sidebar Backdrop (Mobile) -->
        <div class="fixed inset-0 z-40 bg-slate-900/60 backdrop-blur-sm md:hidden"
             x-show="sidebarOpen"
             x-transition.opacity
             @click="sidebarOpen = false"
             style="display: none;"></div>

        <!-- Sidebar Navigation -->
        <aside class="fixed inset-y-0 left-0 z-50 flex flex-col w-64 bg-pharma-navy text-slate-300 transform md:translate-x-0 md:static md:flex-shrink-0 transition-transform duration-300 ease-in-out"
               :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
            
            <!-- Branding -->
            <div class="flex items-center justify-between px-6 py-5 bg-slate-950/20 border-b border-slate-800/60">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-2">
                    <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-pharma-gold/20 text-pharma-gold font-extrabold text-base border border-pharma-gold/10">A</div>
                    <div>
                        <span class="block text-sm font-bold text-white tracking-wider uppercase leading-none">CPA Admin</span>
                        <span class="text-[9px] text-slate-400 font-semibold tracking-wider">Chitranshu Pharma</span>
                    </div>
                </a>
                <!-- Close sidebar (Mobile) -->
                <button @click="sidebarOpen = false" class="text-slate-400 hover:text-white md:hidden text-2xl font-bold">×</button>
            </div>
            <!-- Navigation Links -->
            <nav class="flex-grow px-4 py-6 space-y-1.5 overflow-hidden">
                <div class="text-[10px] font-bold text-slate-500 uppercase tracking-widest px-4 mb-3">Menu</div>

                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center px-4 py-3 text-sm font-medium rounded-xl transition duration-150 {{ Request::is('admin/dashboard') ? 'bg-pharma-navyLight text-white font-bold shadow-inner' : 'text-slate-400 hover:bg-pharma-navyLight/50 hover:text-white' }}">
                    <span class="mr-3 text-lg">📊</span>
                    Dashboard
                </a>

                <!-- Companies -->
                <a href="{{ route('companies.index') }}" 
                   class="flex items-center px-4 py-3 text-sm font-medium rounded-xl transition duration-150 {{ Request::is('admin/companies*') ? 'bg-pharma-navyLight text-white font-bold shadow-inner' : 'text-slate-400 hover:bg-pharma-navyLight/50 hover:text-white' }}">
                    <span class="mr-3 text-lg">🏢</span>
                    Companies
                </a>

                <!-- Divisions -->
                <a href="{{ route('divisions.index') }}" 
                   class="flex items-center px-4 py-3 text-sm font-medium rounded-xl transition duration-150 {{ Request::is('admin/divisions*') ? 'bg-pharma-navyLight text-white font-bold shadow-inner' : 'text-slate-400 hover:bg-pharma-navyLight/50 hover:text-white' }}">
                    <span class="mr-3 text-lg">🗂️</span>
                    Divisions
                </a>

                <!-- Salts -->
                <a href="{{ route('salts.index') }}" 
                   class="flex items-center px-4 py-3 text-sm font-medium rounded-xl transition duration-150 {{ Request::is('admin/salts*') ? 'bg-pharma-navyLight text-white font-bold shadow-inner' : 'text-slate-400 hover:bg-pharma-navyLight/50 hover:text-white' }}">
                    <span class="mr-3 text-lg">🧪</span>
                    Salts/Compositions
                </a>

                <!-- Products -->
                <a href="{{ route('products.index') }}" 
                   class="flex items-center px-4 py-3 text-sm font-medium rounded-xl transition duration-150 {{ Request::is('admin/products*') ? 'bg-pharma-navyLight text-white font-bold shadow-inner' : 'text-slate-400 hover:bg-pharma-navyLight/50 hover:text-white' }}">
                    <span class="mr-3 text-lg">💊</span>
                    Products
                </a>

                <!-- Orders -->
                <a href="{{ route('orders.index') }}" 
                   class="flex items-center px-4 py-3 text-sm font-medium rounded-xl transition duration-150 {{ Request::is('admin/orders*') ? 'bg-pharma-navyLight text-white font-bold shadow-inner' : 'text-slate-400 hover:bg-pharma-navyLight/50 hover:text-white' }}">
                    <span class="mr-3 text-lg">🛒</span>
                    Orders
                </a>

                <!-- Applications -->
                <a href="{{ route('applications.index') }}" 
                   class="flex items-center px-4 py-3 text-sm font-medium rounded-xl transition duration-150 {{ Request::is('admin/applications*') ? 'bg-pharma-navyLight text-white font-bold shadow-inner' : 'text-slate-400 hover:bg-pharma-navyLight/50 hover:text-white' }}">
                    <span class="mr-3 text-lg">📄</span>
                    Applications
                </a>

                <!-- Settings -->
                <a href="{{ route('admin.settings') }}" 
                   class="flex items-center px-4 py-3 text-sm font-medium rounded-xl transition duration-150 {{ Request::is('admin/settings*') ? 'bg-pharma-navyLight text-white font-bold shadow-inner' : 'text-slate-400 hover:bg-pharma-navyLight/50 hover:text-white' }}">
                    <span class="mr-3 text-lg">⚙️</span>
                    Settings
                </a>

                <!-- Logout -->
                <form action="{{ route('admin.logout') }}" method="POST" id="logout-form" class="block">
                    @csrf
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                       class="flex items-center px-4 py-3 text-sm font-medium rounded-xl text-slate-400 hover:bg-pharma-navyLight/50 hover:text-white transition duration-150">
                        <span class="mr-3 text-lg flex items-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                        </span>
                        Logout
                    </a>
                </form>
            </nav>
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

            <!-- Content Area -->
            <main class="flex-grow p-6 overflow-y-auto">
                
                <!-- Breadcrumbs & Dynamic Alerts -->
                <div class="max-w-7xl mx-auto">
                    @if(session('success'))
                        <div class="p-4 mb-6 text-sm text-green-800 rounded-xl bg-green-50 border border-green-200 flex items-center justify-between shadow-sm animate-fadeIn" role="alert">
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
