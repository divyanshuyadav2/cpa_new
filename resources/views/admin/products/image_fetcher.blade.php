@extends('layouts.admin')

@section('title', 'Product Image Fetcher')

@section('content')
<div class="mb-8 flex items-center justify-between">
    <div>
        <h1 class="text-3xl font-extrabold text-pharma-navy flex items-center gap-3">
            🖼️ Product Image Fetcher
        </h1>
        <p class="text-sm text-slate-500 mt-1">
            Automatically scrape &amp; download product images from 1mg, Netmeds, PharmEasy. Images saved company-wise.
        </p>
    </div>
    <a href="{{ route('products.index') }}" class="text-sm text-blue-600 hover:underline flex items-center gap-1">
        ← Back to Products
    </a>
</div>

{{-- Flash Results --}}
@if(session('fetch_result'))
    <div class="mb-6 rounded-2xl border border-green-200 bg-green-50 p-5">
        <h3 class="font-bold text-green-800 mb-2">✅ Fetch Run Complete</h3>
        <pre class="text-xs text-green-700 bg-green-100 rounded p-3 overflow-auto max-h-40 whitespace-pre-wrap">{{ session('fetch_result')['output'] }}</pre>
    </div>
@endif
@if(session('success'))
    <div class="mb-6 rounded-2xl border border-blue-200 bg-blue-50 p-4 text-blue-800 font-medium">
        ℹ️ {{ session('success') }}
    </div>
@endif

{{-- === PROGRESS STATS === --}}
<div class="grid grid-cols-2 gap-5 sm:grid-cols-4 mb-8">
    {{-- Total Products --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 flex items-center space-x-4">
        <div class="p-3 bg-blue-100 rounded-xl text-blue-600 text-2xl">💊</div>
        <div>
            <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider">Total Products</span>
            <strong class="text-3xl font-black text-slate-800">{{ number_format($stats['total']) }}</strong>
        </div>
    </div>

    {{-- Images Found --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 flex items-center space-x-4">
        <div class="p-3 bg-green-100 rounded-xl text-green-600 text-2xl">✅</div>
        <div>
            <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider">Have Image</span>
            <strong class="text-3xl font-black text-green-700">{{ number_format($stats['with_img']) }}</strong>
        </div>
    </div>

    {{-- Missing Images --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 flex items-center space-x-4">
        <div class="p-3 bg-red-100 rounded-xl text-red-500 text-2xl">🔴</div>
        <div>
            <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider">Missing Image</span>
            <strong class="text-3xl font-black text-red-600">{{ number_format($stats['missing']) }}</strong>
        </div>
    </div>

    {{-- Completion % --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 flex items-center space-x-4">
        <div class="p-3 bg-purple-100 rounded-xl text-purple-600 text-2xl">📊</div>
        <div>
            <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider">Completed</span>
            <strong class="text-3xl font-black text-purple-700">{{ $stats['pct'] }}%</strong>
        </div>
    </div>
</div>

{{-- Progress Bar --}}
<div class="mb-8 bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
    <div class="flex justify-between text-sm font-semibold text-slate-600 mb-2">
        <span>Image Coverage</span>
        <span>{{ $stats['with_img'] }} / {{ $stats['total'] }}</span>
    </div>
    <div class="w-full bg-slate-100 rounded-full h-5 overflow-hidden">
        <div class="h-5 rounded-full bg-gradient-to-r from-green-400 to-green-600 transition-all duration-700"
             style="width: {{ $stats['pct'] }}%"></div>
    </div>
    <div class="mt-2 flex justify-between text-xs text-slate-400">
        <span>0</span>
        <span class="text-green-600 font-bold">{{ $stats['pct'] }}% done</span>
        <span>{{ $stats['total'] }}</span>
    </div>
</div>

{{-- All-time Stats from Progress Log --}}
@if(!empty($progress['total_saved']) || !empty($progress['total_failed']))
<div class="mb-8 grid grid-cols-2 gap-5 sm:grid-cols-4">
    <div class="bg-emerald-50 border border-emerald-200 rounded-2xl p-5">
        <div class="text-xs font-bold text-emerald-600 uppercase tracking-wider">All-Time Saved</div>
        <div class="text-3xl font-black text-emerald-700">{{ $progress['total_saved'] ?? 0 }}</div>
    </div>
    <div class="bg-red-50 border border-red-200 rounded-2xl p-5">
        <div class="text-xs font-bold text-red-500 uppercase tracking-wider">All-Time Failed</div>
        <div class="text-3xl font-black text-red-600">{{ $progress['total_failed'] ?? 0 }}</div>
    </div>
    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-5 col-span-2">
        <div class="text-xs font-bold text-slate-500 uppercase tracking-wider">Last Run</div>
        <div class="text-lg font-semibold text-slate-700">{{ $progress['last_run'] ?? 'Never' }}</div>
    </div>
</div>
@endif

{{-- === FETCH FORM === --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    {{-- Control Panel --}}
    <div class="lg:col-span-1">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
            <h2 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                🚀 Start Fetching Images
            </h2>
            <form method="POST" action="{{ route('admin.product-images.fetch') }}" id="fetchForm">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-slate-600 mb-1">Products Per Run</label>
                    <input type="number" name="limit" value="30" min="1" max="500"
                           class="w-full rounded-xl border border-slate-300 px-4 py-2 text-sm focus:ring-2 focus:ring-blue-400 outline-none">
                    <p class="text-xs text-slate-400 mt-1">Max 500 per batch. Start small to test.</p>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-slate-600 mb-1">Filter by Company (optional)</label>
                    <input type="text" name="company" placeholder="e.g. Cipla, Lupin..."
                           class="w-full rounded-xl border border-slate-300 px-4 py-2 text-sm focus:ring-2 focus:ring-blue-400 outline-none">
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-slate-600 mb-1">Delay Between Requests</label>
                    <select name="delay" class="w-full rounded-xl border border-slate-300 px-4 py-2 text-sm focus:ring-2 focus:ring-blue-400 outline-none">
                        <option value="800">800ms — Fast (may get blocked)</option>
                        <option value="1500" selected>1500ms — Recommended</option>
                        <option value="2500">2500ms — Safe</option>
                        <option value="4000">4000ms — Very Safe</option>
                    </select>
                </div>

                <button type="submit" id="fetchBtn"
                        class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold py-3 px-6 rounded-xl hover:opacity-90 transition flex items-center justify-center gap-2">
                    <span id="fetchBtnText">⚡ Start Fetching</span>
                    <span id="fetchBtnLoader" class="hidden animate-spin">⏳</span>
                </button>
            </form>

            <div class="mt-4 border-t border-slate-100 pt-4">
                <form method="POST" action="{{ route('admin.product-images.reset') }}"
                      onsubmit="return confirm('Clear all progress logs? Product images already saved to DB and disk are unaffected.')">
                    @csrf
                    <button type="submit"
                            class="w-full text-sm text-red-500 border border-red-200 rounded-xl py-2 hover:bg-red-50 transition">
                        🗑️ Clear Progress Log
                    </button>
                </form>
            </div>
        </div>

        {{-- Info Box --}}
        <div class="mt-4 bg-amber-50 border border-amber-200 rounded-2xl p-4 text-sm text-amber-800">
            <strong class="block mb-1">📝 How it works</strong>
            <ul class="list-disc list-inside space-y-1 text-xs">
                <li>Searches <strong>1mg.com</strong> API + page scraping</li>
                <li>Falls back to <strong>Netmeds</strong> &amp; <strong>PharmEasy</strong></li>
                <li>Final fallback: <strong>Bing Images</strong></li>
                <li>Images saved to <code>storage/app/public/products/{company}/</code></li>
                <li>DB updated with relative path: <code>storage/products/...</code></li>
                <li>Progress tracked in <code>storage/app/image_fetch_progress.json</code></li>
            </ul>
        </div>
    </div>

    {{-- Companies Table --}}
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
            <h2 class="text-lg font-bold text-slate-800 mb-4">🏢 Companies — Missing Image Count</h2>
            <div class="overflow-auto max-h-96">
                <table class="min-w-full text-sm">
                    <thead class="sticky top-0 bg-white">
                        <tr class="text-left text-xs font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">
                            <th class="pb-2 pr-4">#</th>
                            <th class="pb-2 pr-4">Company</th>
                            <th class="pb-2 pr-4 text-center">Total</th>
                            <th class="pb-2 pr-4 text-center">Missing</th>
                            <th class="pb-2">Coverage</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($companies as $i => $company)
                        @php
                            $covered = $company->total_products - $company->missing_images;
                            $pct = $company->total_products > 0 ? round(($covered / $company->total_products) * 100) : 0;
                        @endphp
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-2 pr-4 text-slate-400 font-mono text-xs">{{ $i + 1 }}</td>
                            <td class="py-2 pr-4 font-semibold text-slate-700">{{ $company->name }}</td>
                            <td class="py-2 pr-4 text-center text-slate-500">{{ $company->total_products }}</td>
                            <td class="py-2 pr-4 text-center">
                                <span class="inline-block px-2 py-0.5 rounded-full text-xs font-bold
                                    {{ $company->missing_images > 20 ? 'bg-red-100 text-red-600' : ($company->missing_images > 5 ? 'bg-amber-100 text-amber-700' : 'bg-green-100 text-green-700') }}">
                                    {{ $company->missing_images }}
                                </span>
                            </td>
                            <td class="py-2 w-32">
                                <div class="flex items-center gap-2">
                                    <div class="flex-1 bg-slate-100 rounded-full h-2 overflow-hidden">
                                        <div class="h-2 rounded-full {{ $pct >= 80 ? 'bg-green-500' : ($pct >= 40 ? 'bg-amber-400' : 'bg-red-400') }}"
                                             style="width: {{ $pct }}%"></div>
                                    </div>
                                    <span class="text-xs text-slate-400 w-8">{{ $pct }}%</span>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Recent Results --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    {{-- Recently Saved --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
        <h2 class="text-lg font-bold text-slate-800 mb-4 text-green-700">✅ Recently Saved Images (Last 20)</h2>
        @if(!empty($recentSaved))
        <div class="overflow-auto max-h-72">
            <table class="min-w-full text-xs">
                <thead>
                    <tr class="text-left text-slate-400 uppercase tracking-wider border-b border-slate-100">
                        <th class="pb-1 pr-3">Product</th>
                        <th class="pb-1 pr-3">Company</th>
                        <th class="pb-1">Path</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($recentSaved as $item)
                    <tr class="hover:bg-green-50">
                        <td class="py-1.5 pr-3 font-medium text-slate-700 truncate max-w-[120px]" title="{{ $item['name'] }}">{{ $item['name'] }}</td>
                        <td class="py-1.5 pr-3 text-slate-500 truncate max-w-[100px]" title="{{ $item['company'] }}">{{ $item['company'] }}</td>
                        <td class="py-1.5 text-green-600 font-mono truncate max-w-[150px]" title="{{ $item['path'] }}">{{ $item['path'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p class="text-slate-400 text-sm">No images saved yet. Run the fetcher to start.</p>
        @endif
    </div>

    {{-- Recently Failed --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
        <h2 class="text-lg font-bold text-slate-800 mb-4 text-red-600">❌ Failed Lookups (Last 20)</h2>
        @if(!empty($recentFailed))
        <div class="overflow-auto max-h-72">
            <table class="min-w-full text-xs">
                <thead>
                    <tr class="text-left text-slate-400 uppercase tracking-wider border-b border-slate-100">
                        <th class="pb-1 pr-3">Product</th>
                        <th class="pb-1">Company</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($recentFailed as $item)
                    <tr class="hover:bg-red-50">
                        <td class="py-1.5 pr-3 font-medium text-slate-700 truncate max-w-[150px]" title="{{ $item['name'] }}">{{ $item['name'] }}</td>
                        <td class="py-1.5 text-slate-500 truncate max-w-[150px]" title="{{ $item['company'] }}">{{ $item['company'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p class="text-slate-400 text-sm">No failures recorded yet.</p>
        @endif
    </div>
</div>

{{-- CLI Instructions --}}
<div class="bg-slate-900 rounded-2xl p-6 text-green-400 font-mono text-sm mb-6">
    <p class="text-slate-400 text-xs mb-3 uppercase tracking-wider">💻 Run from Terminal</p>
    <p class="mb-2"># Fetch 50 images with 1.5s delay</p>
    <p class="text-white">php artisan products:fetch-images --limit=50</p>
    <p class="mt-3 mb-2"># Fetch only for a specific company</p>
    <p class="text-white">php artisan products:fetch-images --limit=100 --company="Cipla"</p>
    <p class="mt-3 mb-2"># Re-fetch even for products that already have images</p>
    <p class="text-white">php artisan products:fetch-images --limit=50 --force</p>
</div>

<script>
document.getElementById('fetchForm').addEventListener('submit', function () {
    const btn = document.getElementById('fetchBtn');
    const txt = document.getElementById('fetchBtnText');
    const ldr = document.getElementById('fetchBtnLoader');
    btn.disabled = true;
    txt.textContent = 'Fetching... (may take a while)';
    ldr.classList.remove('hidden');
});
</script>
@endsection
