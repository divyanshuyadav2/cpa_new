<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-900">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - {{ setting('company_name', 'Chitranshu Pharmaceuticals Agency') }}</title>
    
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
</head>
<body class="min-h-screen bg-slate-950 text-slate-100 font-sans antialiased">
<div class="min-h-screen grid lg:grid-cols-2">

    <!-- Branding panel -->
    <div class="hidden lg:flex relative flex-col justify-between p-12 overflow-hidden bg-gradient-to-br from-pharma-navy via-slate-900 to-sky-950">
        <div class="absolute -top-24 -right-24 w-96 h-96 rounded-full bg-pharma-accent/20 blur-3xl"></div>
        <div class="absolute -bottom-32 -left-16 w-96 h-96 rounded-full bg-pharma-gold/10 blur-3xl"></div>

        <div class="relative flex items-center space-x-3">
            @if(setting('site_logo'))
                <img src="{{ media_url(setting('site_logo')) }}" alt="Logo" class="h-12 w-12 object-contain rounded-xl bg-white/10 p-1.5">
            @else
                <img src="{{ asset('images/cpa_logo_white.png') }}" alt="Logo" class="h-12 w-12 object-contain">
            @endif
            <span class="font-display text-lg font-bold tracking-wide">{{ setting('company_name', 'Chitranshu Pharmaceuticals Agency') }}</span>
        </div>

        <div class="relative">
            <h1 class="font-display text-4xl font-extrabold leading-tight">Run your distribution<br>from one place.</h1>
            <p class="mt-4 text-slate-400 max-w-md">Manage products, orders, retailers and salesmen with a single secure admin panel.</p>
            <ul class="mt-8 space-y-3 text-sm text-slate-300">
                <li class="flex items-center space-x-3"><span class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center">💊</span><span>Live product &amp; stock catalogue</span></li>
                <li class="flex items-center space-x-3"><span class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center">🛒</span><span>Order tracking &amp; WhatsApp confirmations</span></li>
                <li class="flex items-center space-x-3"><span class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center">👥</span><span>Retailer, salesman &amp; biller accounts</span></li>
            </ul>
        </div>

        <p class="relative text-xs text-slate-500">&copy; {{ date('Y') }} {{ setting('company_name', 'Chitranshu Pharmaceuticals Agency') }}</p>
    </div>

    <!-- Form panel -->
    <div class="flex items-center justify-center px-5 py-12 sm:px-10">
        <div class="w-full max-w-md">

            <!-- Mobile logo -->
            <div class="lg:hidden text-center mb-8">
                @if(setting('site_logo'))
                    <img src="{{ media_url(setting('site_logo')) }}" alt="Logo" class="mx-auto h-16 w-auto object-contain mb-3 rounded-xl bg-white/10 p-2">
                @else
                    <img src="{{ asset('images/cpa_logo_white.png') }}" alt="Logo" class="mx-auto h-16 w-auto object-contain mb-3">
                @endif
                <p class="text-sm text-slate-400">{{ setting('company_name', 'Chitranshu Pharmaceuticals Agency') }}</p>
            </div>

            <h2 class="font-display text-3xl font-extrabold text-white">Welcome back</h2>
            <p class="mt-1 text-sm text-slate-400">Sign in to the admin panel to continue.</p>

            <div class="mt-6 space-y-3">
                @if(session('error'))
                    <div class="p-3.5 text-xs font-semibold text-red-200 rounded-xl bg-red-500/10 border border-red-500/30" role="alert">{{ session('error') }}</div>
                @endif
                @if(session('success'))
                    <div class="p-3.5 text-xs font-semibold text-emerald-200 rounded-xl bg-emerald-500/10 border border-emerald-500/30" role="status">{{ session('success') }}</div>
                @endif
                @if($errors->any())
                    <div class="p-3.5 text-xs font-semibold text-red-200 rounded-xl bg-red-500/10 border border-red-500/30 flex items-start space-x-2" role="alert">
                        <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif
            </div>

            <form action="{{ route('admin.login') }}" method="POST" class="mt-6 space-y-5"
                  x-data="{ show: false, loading: false, caps: false }" @submit="loading = true">
                @csrf

                <div>
                    <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Email Address</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </span>
                        <input type="email" name="email" id="email" required autofocus value="{{ old('email') }}" autocomplete="email" placeholder="admin@example.com"
                               class="w-full pl-10 pr-3.5 py-3 bg-slate-900 border rounded-xl text-sm text-white placeholder-slate-600 focus:outline-none focus:ring-2 focus:ring-pharma-gold focus:border-transparent {{ $errors->has('email') ? 'border-red-500/60' : 'border-slate-700' }}">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </span>
                        <input :type="show ? 'text' : 'password'" name="password" id="password" required autocomplete="current-password" placeholder="••••••••"
                               @keyup="caps = $event.getModifierState && $event.getModifierState('CapsLock')"
                               class="w-full pl-10 pr-16 py-3 bg-slate-900 border border-slate-700 rounded-xl text-sm text-white placeholder-slate-600 focus:outline-none focus:ring-2 focus:ring-pharma-gold focus:border-transparent">
                        <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 px-3.5 text-[11px] font-bold text-slate-400 hover:text-white" x-text="show ? 'HIDE' : 'SHOW'">SHOW</button>
                    </div>
                    <p x-show="caps" x-cloak style="display:none" class="mt-1.5 text-xs font-semibold text-amber-400">⚠ Caps Lock is on</p>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="remember" id="remember" class="w-4 h-4 rounded bg-slate-900 border-slate-700 text-pharma-gold focus:ring-pharma-gold">
                    <label for="remember" class="ml-2 text-xs font-medium text-slate-400 cursor-pointer">Keep me signed in on this device</label>
                </div>

                <button type="submit" :disabled="loading"
                        class="w-full py-3 px-6 bg-gradient-to-r from-pharma-gold to-yellow-500 text-slate-950 text-sm font-bold rounded-xl hover:opacity-95 transition shadow-lg flex justify-center items-center space-x-2 disabled:opacity-60 disabled:cursor-not-allowed">
                    <svg x-show="loading" style="display:none" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"/></svg>
                    <span x-text="loading ? 'Signing in…' : 'Enter Dashboard'">Enter Dashboard</span>
                </button>
            </form>

            <p class="mt-8 text-center text-xs text-slate-500">
                <a href="{{ route('home') }}" class="hover:text-slate-300 transition">&larr; Back to website</a>
            </p>
        </div>
    </div>
</div>
</body>
</html>
