@extends('layouts.pwa')

@section('title', 'Login - Chitranshu Pharma PWA')

@section('content')
<div class="mt-4 sm:mt-8">
    <div class="bg-slate-800/80 backdrop-blur-xl border border-slate-700/60 rounded-3xl p-6 sm:p-8 shadow-2xl">
        <!-- App Header Logo -->
        <div class="text-center mb-6">
            @if(setting('site_logo'))
                <img src="{{ media_url(setting('site_logo')) }}" alt="Logo" class="mx-auto h-16 w-auto object-contain mb-3 bg-white/10 p-2 rounded-2xl">
            @else
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-sky-500 to-emerald-400 mx-auto flex items-center justify-center font-extrabold text-white text-2xl shadow-lg mb-3">
                    CP
                </div>
            @endif
            <h1 class="text-2xl font-extrabold text-white tracking-tight">Sign In to Portal</h1>
            <p class="text-xs text-slate-400 mt-1">Retailer Counter Ordering Portal</p>
        </div>

        <!-- Login Form -->
        <form action="{{ route('pwa.login.post') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1.5">Email Address</label>
                <input type="email" name="email" id="email" required value="{{ old('email') }}" placeholder="counter@pharma.com"
                       class="w-full px-4 py-3 bg-slate-900/90 border border-slate-700 rounded-xl text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-transparent @error('email') border-red-500 @enderror">
                @error('email')
                    <p class="text-xs text-red-400 mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1.5">Password</label>
                <input type="password" name="password" id="password" required placeholder="••••••••"
                       class="w-full px-4 py-3 bg-slate-900/90 border border-slate-700 rounded-xl text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-transparent @error('password') border-red-500 @enderror">
                @error('password')
                    <p class="text-xs text-red-400 mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between text-xs text-slate-400 py-1">
                <label class="flex items-center space-x-2 cursor-pointer">
                    <input type="checkbox" name="remember" class="rounded bg-slate-900 border-slate-700 text-sky-500 focus:ring-sky-500">
                    <span>Remember Me</span>
                </label>
            </div>

            <button type="submit" class="w-full py-3.5 px-4 bg-gradient-to-r from-sky-500 to-emerald-500 hover:from-sky-400 hover:to-emerald-400 text-white font-extrabold text-sm rounded-xl shadow-lg shadow-sky-500/20 active:scale-[0.98] transition">
                Sign In &rarr;
            </button>
        </form>

        <div class="mt-6 pt-5 border-t border-slate-700/60 text-center">
            <p class="text-xs text-slate-400">Don't have an account yet?</p>
            <a href="{{ route('pwa.register') }}" class="inline-block mt-2 text-xs font-bold text-sky-400 hover:text-sky-300 hover:underline">
                Create Retailer / Salesman Account &rarr;
            </a>
        </div>
    </div>
</div>
@endsection
