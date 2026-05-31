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
    
    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex flex-col justify-center h-full min-h-screen py-12 sm:px-6 lg:px-8 bg-gradient-to-br from-slate-950 via-slate-900 to-pharma-navy text-slate-100 font-sans antialiased">

    <div class="sm:mx-auto sm:w-full sm:max-w-md text-center">
        <!-- Logo Icon -->
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-pharma-gold text-slate-900 font-extrabold text-3xl shadow-lg border border-pharma-gold/30">
            A
        </div>
        <h2 class="mt-6 text-3xl font-extrabold tracking-tight text-white font-display">
            Admin Panel Login
        </h2>
        <p class="mt-2 text-sm text-slate-400">
            {{ setting('company_name', 'Chitranshu Pharmaceuticals Agency') }}
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md px-4">
        
        <!-- Alerts -->
        @if(session('error'))
            <div class="p-4 mb-4 text-xs font-semibold text-red-800 rounded-xl bg-red-50 border border-red-200">
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="p-4 mb-4 text-xs font-semibold text-green-800 rounded-xl bg-green-50 border border-green-200">
                {{ session('success') }}
            </div>
        @endif

        <!-- Card wrapper -->
        <div class="bg-slate-800/80 backdrop-blur-md py-8 px-6 sm:px-10 rounded-2xl border border-slate-700 shadow-2xl">
            <form action="{{ route('admin.login') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Email Input -->
                <div>
                    <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">
                        Email Address
                    </label>
                    <input type="email" name="email" id="email" required value="{{ old('email') }}" autocomplete="email"
                           class="w-full px-3.5 py-2.5 bg-slate-900/50 border border-slate-700 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-pharma-gold focus:border-transparent text-white @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Input -->
                <div>
                    <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">
                        Password
                    </label>
                    <input type="password" name="password" id="password" required autocomplete="current-password"
                           placeholder="••••••••" 
                           class="w-full px-3.5 py-2.5 bg-slate-900/50 border border-slate-700 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-pharma-gold focus:border-transparent text-white">
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input type="checkbox" name="remember" id="remember" 
                               class="w-4 h-4 rounded bg-slate-900 border-slate-700 text-pharma-gold focus:ring-pharma-gold">
                        <label for="remember" class="ml-2 block text-xs font-medium text-slate-400 cursor-pointer">
                            Remember me
                        </label>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full py-3 px-6 bg-gradient-to-r from-pharma-gold to-yellow-500 text-slate-950 text-sm font-bold rounded-xl hover:opacity-95 transition shadow-lg flex justify-center items-center">
                    Enter Dashboard
                </button>
            </form>
        </div>
    </div>

</body>
</html>
