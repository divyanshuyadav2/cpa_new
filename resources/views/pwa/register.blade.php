@extends('layouts.pwa')

@section('title', 'Register - Chitranshu Pharma PWA')

@section('content')
<div class="mt-4 sm:mt-6">
    <div class="bg-slate-800/80 backdrop-blur-xl border border-slate-700/60 rounded-3xl p-6 sm:p-8 shadow-2xl">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-extrabold text-white tracking-tight">Create Account</h1>
            <p class="text-xs text-slate-400 mt-1">Register for Retailer Counter or Salesman Access</p>
        </div>

        <form action="{{ route('pwa.register.post') }}" method="POST" class="space-y-4" x-data="{ role: '{{ old('role', 'retailer') }}' }">
            @csrf

            <!-- Role (Default Retailer Counter) -->
            <input type="hidden" name="role" value="retailer">

            <!-- Full Name -->
            <div>
                <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1">Full Name</label>
                <input type="text" name="name" id="name" required value="{{ old('name') }}" placeholder="e.g. Ramesh Kumar"
                       class="w-full px-3.5 py-2.5 bg-slate-900/90 border border-slate-700 rounded-xl text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-sky-500">
                @error('name')
                    <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1">Email Address</label>
                <input type="email" name="email" id="email" required value="{{ old('email') }}" placeholder="name@counter.com"
                       class="w-full px-3.5 py-2.5 bg-slate-900/90 border border-slate-700 rounded-xl text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-sky-500">
                @error('email')
                    <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Phone Number -->
            <div>
                <label for="phone" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1">Phone Number</label>
                <input type="text" name="phone" id="phone" required value="{{ old('phone') }}" placeholder="9876543210"
                       class="w-full px-3.5 py-2.5 bg-slate-900/90 border border-slate-700 rounded-xl text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-sky-500">
                @error('phone')
                    <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Shop / Company Name -->
            <div>
                <label for="company_name" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1">Shop / Medical Counter Name</label>
                <input type="text" name="company_name" id="company_name" value="{{ old('company_name') }}" placeholder="e.g. City Pharma Medical"
                       class="w-full px-3.5 py-2.5 bg-slate-900/90 border border-slate-700 rounded-xl text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-sky-500">
            </div>

            <!-- Address -->
            <div>
                <label for="address" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1">Shop Address</label>
                <textarea name="address" id="address" rows="2" placeholder="Full shop address..."
                          class="w-full px-3.5 py-2.5 bg-slate-900/90 border border-slate-700 rounded-xl text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-sky-500">{{ old('address') }}</textarea>
            </div>

            <!-- Assigned Salesman (Optional for Retailer) -->
            <div x-show="role === 'retailer'">
                <label for="salesman_id" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1">Assigned Salesman (Optional)</label>
                <select name="salesman_id" id="salesman_id" class="w-full px-3.5 py-2.5 bg-slate-900/90 border border-slate-700 rounded-xl text-sm text-white focus:outline-none focus:ring-2 focus:ring-sky-500">
                    <option value="">-- Select Salesman --</option>
                    @foreach($salesmen as $s)
                        <option value="{{ $s->id }}">{{ $s->name }} ({{ $s->phone }})</option>
                    @endforeach
                </select>
            </div>

            <!-- Passwords -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1">Password</label>
                    <input type="password" name="password" id="password" required placeholder="••••••••"
                           class="w-full px-3.5 py-2.5 bg-slate-900/90 border border-slate-700 rounded-xl text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-sky-500">
                </div>
                <div>
                    <label for="password_confirmation" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required placeholder="••••••••"
                           class="w-full px-3.5 py-2.5 bg-slate-900/90 border border-slate-700 rounded-xl text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-sky-500">
                </div>
            </div>
            @error('password')
                <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
            @enderror

            <button type="submit" class="w-full py-3.5 px-4 bg-gradient-to-r from-sky-500 to-emerald-500 hover:from-sky-400 hover:to-emerald-400 text-white font-extrabold text-sm rounded-xl shadow-lg shadow-sky-500/20 active:scale-[0.98] transition mt-2">
                Complete Registration &rarr;
            </button>
        </form>

        <div class="mt-6 pt-4 border-t border-slate-700/60 text-center">
            <p class="text-xs text-slate-400">Already registered?</p>
            <a href="{{ route('pwa.login') }}" class="inline-block mt-1.5 text-xs font-bold text-sky-400 hover:text-sky-300 hover:underline">
                Log In &rarr;
            </a>
        </div>
    </div>
</div>
@endsection
