@extends('layouts.admin')

@section('title', 'Product Image Fetcher')

@section('content')

{{-- ═══════════════════════════════════════════════════════════════ --}}
{{-- Header                                                          --}}
{{-- ═══════════════════════════════════════════════════════════════ --}}
<div class="mb-6 flex items-center justify-between">
    <div>
        <h1 class="text-3xl font-extrabold text-pharma-navy flex items-center gap-3">
            🖼️ Product Image Fetcher
        </h1>
        <p class="text-sm text-slate-500 mt-1">
            Scrapes &amp; downloads images from 1mg, Netmeds, PharmEasy in the background — no timeouts.
        </p>
    </div>
    <a href="{{ route('products.index') }}" class="text-sm text-blue-600 hover:underline">← Back to Products</a>
</div>

{{-- ═══════════════════════════════════════════════════════════════ --}}
{{-- RUNNING BANNER (shown when job is active)                       --}}
{{-- ═══════════════════════════════════════════════════════════════ --}}
<div id="runningBanner"
     class="mb-6 rounded-2xl border border-blue-300 bg-blue-50 p-4 flex items-center gap-4 {{ $isRunning ? '' : 'hidden' }}">
    <div class="text-2xl animate-spin">⚙️</div>
    <div class="flex-1">
        <p class="font-bold text-blue-800">Image fetch is running in the background…</p>
        <p class="text-xs text-blue-600 mt-0.5">Stats auto-refresh every 4 seconds. You can safely navigate away.</p>
    </div>
    <button onclick="stopFetch()"
            class="bg-red-500 hover:bg-red-600 text-white text-sm font-bold px-4 py-2 rounded-xl transition">
        ⏹ Stop
    </button>
</div>

{{-- ═══════════════════════════════════════════════════════════════ --}}
{{-- Live Stats Cards                                                 --}}
{{-- ═══════════════════════════════════════════════════════════════ --}}
<div class="grid grid-cols-2 gap-5 sm:grid-cols-4 mb-6">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 flex items-center space-x-4">
        <div class="p-3 bg-blue-100 rounded-xl text-blue-600 text-2xl">💊</div>
        <div>
            <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider">Total Products</span>
            <strong id="statTotal" class="text-3xl font-black text-slate-800">{{ number_format($stats['total']) }}</strong>
        </div>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 flex items-center space-x-4">
        <div class="p-3 bg-green-100 rounded-xl text-green-600 text-2xl">✅</div>
        <div>
            <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider">Have Image</span>
            <strong id="statWithImg" class="text-3xl font-black text-green-700">{{ number_format($stats['with_img']) }}</strong>
        </div>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 flex items-center space-x-4">
        <div class="p-3 bg-red-100 rounded-xl text-red-500 text-2xl">🔴</div>
        <div>
            <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider">Missing Image</span>
            <strong id="statMissing" class="text-3xl font-black text-red-600">{{ number_format($stats['missing']) }}</strong>
        </div>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 flex items-center space-x-4">
        <div class="p-3 bg-purple-100 rounded-xl text-purple-600 text-2xl">📊</div>
        <div>
            <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider">Completed</span>
            <strong id="statPct" class="text-3xl font-black text-purple-700">{{ $stats['pct'] }}%</strong>
        </div>
    </div>
</div>

{{-- Progress bar --}}
<div class="mb-6 bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
    <div class="flex justify-between text-sm font-semibold text-slate-600 mb-2">
        <span>Image Coverage</span>
        <span id="progressLabel">{{ $stats['with_img'] }} / {{ $stats['total'] }}</span>
    </div>
    <div class="w-full bg-slate-100 rounded-full h-5 overflow-hidden">
        <div id="progressBar"
             class="h-5 rounded-full bg-gradient-to-r from-green-400 to-green-600 transition-all duration-700"
             style="width: {{ $stats['pct'] }}%"></div>
    </div>
    <div class="mt-2 flex justify-between text-xs text-slate-400">
        <span>0</span>
        <span id="progressPctLabel" class="text-green-600 font-bold">{{ $stats['pct'] }}% done</span>
        <span>{{ $stats['total'] }}</span>
    </div>
</div>

{{-- All-time tally --}}
<div class="mb-6 grid grid-cols-2 gap-5 sm:grid-cols-4">
    <div class="bg-emerald-50 border border-emerald-200 rounded-2xl p-5">
        <div class="text-xs font-bold text-emerald-600 uppercase tracking-wider">All-Time Saved</div>
        <div id="tallySaved" class="text-3xl font-black text-emerald-700">{{ $progress['total_saved'] ?? 0 }}</div>
    </div>
    <div class="bg-red-50 border border-red-200 rounded-2xl p-5">
        <div class="text-xs font-bold text-red-500 uppercase tracking-wider">All-Time Failed</div>
        <div id="tallyFailed" class="text-3xl font-black text-red-600">{{ $progress['total_failed'] ?? 0 }}</div>
    </div>
    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-5">
        <div class="text-xs font-bold text-slate-500 uppercase tracking-wider">Last Run</div>
        <div id="lastRun" class="text-sm font-semibold text-slate-700">{{ $progress['last_run'] ?? 'Never' }}</div>
    </div>
    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-5 flex items-center justify-center">
        <button onclick="resetProgress()"
                class="text-sm text-red-500 font-semibold hover:underline">
            🗑️ Clear Log
        </button>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════════ --}}
{{-- Main 3-column layout                                            --}}
{{-- ═══════════════════════════════════════════════════════════════ --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

    {{-- Control Panel --}}
    <div class="lg:col-span-1 space-y-4">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
            <h2 class="text-lg font-bold text-slate-800 mb-4">🚀 Fetch Settings</h2>

            <div class="mb-4">
                <label class="block text-sm font-semibold text-slate-600 mb-1">Products Per Run</label>
                <input id="ctrlLimit" type="number" value="50" min="1" max="500"
                       class="w-full rounded-xl border border-slate-300 px-4 py-2 text-sm focus:ring-2 focus:ring-blue-400 outline-none">
                <p class="text-xs text-slate-400 mt-1">Run multiple times until all are done.</p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-semibold text-slate-600 mb-1">Filter by Company</label>
                <input id="ctrlCompany" type="text" placeholder="e.g. Cipla, Lotus…"
                       class="w-full rounded-xl border border-slate-300 px-4 py-2 text-sm focus:ring-2 focus:ring-blue-400 outline-none">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-semibold text-slate-600 mb-1">Delay Between Requests</label>
                <select id="ctrlDelay" class="w-full rounded-xl border border-slate-300 px-4 py-2 text-sm focus:ring-2 focus:ring-blue-400 outline-none">
                    <option value="800">800ms — Fast</option>
                    <option value="1500" selected>1500ms — Recommended</option>
                    <option value="2500">2500ms — Safe</option>
                    <option value="4000">4000ms — Very Safe</option>
                </select>
            </div>

            <div class="mb-5">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input id="ctrlForce" type="checkbox" class="rounded">
                    <span class="text-sm text-slate-600">Re-fetch products that already have images</span>
                </label>
            </div>

            <button id="startBtn" onclick="startFetch()"
                    class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold py-3 px-6 rounded-xl hover:opacity-90 transition flex items-center justify-center gap-2 disabled:opacity-50">
                ⚡ Start Fetching in Background
            </button>

            <div id="startMsg" class="hidden mt-3 text-sm text-center font-medium"></div>
        </div>

        {{-- Info --}}
        <div class="bg-amber-50 border border-amber-200 rounded-2xl p-4 text-sm text-amber-800">
            <strong class="block mb-1">📝 Sources checked (in order)</strong>
            <ol class="list-decimal list-inside space-y-1 text-xs">
                <li><strong>1mg.com</strong> — API + page scrape</li>
                <li><strong>Netmeds.com</strong></li>
                <li><strong>PharmEasy.in</strong></li>
                <li><strong>Bing Images</strong> — fallback</li>
            </ol>
            <p class="mt-2 text-xs">Saved to: <code class="bg-amber-100 px-1 rounded">storage/products/{company}/{name}.jpg</code></p>
        </div>

        {{-- CLI --}}
        <div class="bg-slate-900 rounded-2xl p-4 text-green-400 font-mono text-xs">
            <p class="text-slate-400 mb-2 uppercase tracking-wider text-[10px]">💻 Or run from terminal</p>
            <p class="text-white">php artisan products:fetch-images --limit=100</p>
            <p class="text-slate-500 mt-2">php artisan products:fetch-images \</p>
            <p class="text-white ml-2">--limit=200 --company="Cipla"</p>
        </div>
    </div>

    {{-- Companies Table + Live Log --}}
    <div class="lg:col-span-2 space-y-4">
        {{-- Companies --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
            <h2 class="text-lg font-bold text-slate-800 mb-4">🏢 Companies — Missing Images</h2>
            <div class="overflow-auto max-h-72">
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
                            <td class="py-2 pr-4 font-semibold text-slate-700">
                                <button class="hover:text-blue-600 text-left"
                                        onclick="document.getElementById('ctrlCompany').value='{{ addslashes($company->name) }}'">
                                    {{ $company->name }}
                                </button>
                            </td>
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

        {{-- Live Log --}}
        <div class="bg-slate-900 rounded-2xl p-5">
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-sm font-bold text-slate-300 uppercase tracking-wider">📋 Live Output Log</h2>
                <button onclick="clearLog()" class="text-xs text-slate-500 hover:text-slate-300">Clear</button>
            </div>
            <div id="logBox"
                 class="font-mono text-xs text-green-400 bg-slate-950 rounded-xl p-4 h-48 overflow-y-auto space-y-0.5">
                <p class="text-slate-500">Waiting for a job to start…</p>
            </div>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════════ --}}
{{-- THIS RUN — Live panel (updates while job runs)                  --}}
{{-- ═══════════════════════════════════════════════════════════════ --}}
<div id="currentRunSection" class="mb-6 {{ (!$isRunning && empty($progress['current_run'])) ? 'hidden' : '' }}">
    <div class="bg-white rounded-2xl shadow-sm border border-blue-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-bold text-blue-700 flex items-center gap-2">
                <span id="currentRunSpinner" class="{{ $isRunning ? 'animate-spin' : '' }}">⚙️</span>
                Current Run — Live Results
            </h2>
            <div class="flex gap-3 text-sm">
                <span class="bg-green-100 text-green-700 font-bold px-3 py-1 rounded-full">
                    ✅ Saved: <span id="curSaved">0</span>
                </span>
                <span class="bg-red-100 text-red-600 font-bold px-3 py-1 rounded-full">
                    ❌ Failed: <span id="curFailed">0</span>
                </span>
                <span class="text-slate-400 text-xs self-center" id="curStartedAt"></span>
            </div>
        </div>

        {{-- Saved in this run --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <div>
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">✅ Images Found This Run</h3>
                <div id="curSavedList" class="overflow-auto max-h-64 rounded-xl border border-slate-100 bg-slate-50">
                    <table class="min-w-full text-xs">
                        <thead class="sticky top-0 bg-slate-100">
                            <tr class="text-slate-400 uppercase text-left">
                                <th class="p-2 pr-3">Time</th>
                                <th class="p-2 pr-3">Product</th>
                                <th class="p-2">Company</th>
                            </tr>
                        </thead>
                        <tbody id="curSavedBody" class="divide-y divide-slate-100">
                            <tr><td colspan="3" class="p-3 text-slate-400 italic text-center">Waiting…</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div>
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">❌ Not Found This Run</h3>
                <div id="curFailedList" class="overflow-auto max-h-64 rounded-xl border border-slate-100 bg-slate-50">
                    <table class="min-w-full text-xs">
                        <thead class="sticky top-0 bg-slate-100">
                            <tr class="text-slate-400 uppercase text-left">
                                <th class="p-2 pr-3">Time</th>
                                <th class="p-2 pr-3">Product</th>
                                <th class="p-2">Company</th>
                            </tr>
                        </thead>
                        <tbody id="curFailedBody" class="divide-y divide-slate-100">
                            <tr><td colspan="3" class="p-3 text-slate-400 italic text-center">None yet…</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════════ --}}
{{-- RUN HISTORY — Last 10 completed runs                           --}}
{{-- ═══════════════════════════════════════════════════════════════ --}}
<div class="mb-8" id="runHistorySection">
    <h2 class="text-xl font-bold text-slate-800 mb-4">📅 Run History (Last 10)</h2>
    <div id="runHistoryList" class="space-y-3">
        @forelse($progress['run_history'] ?? [] as $run)
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden" x-data="{ open: false }">
            <button @click="open = !open"
                    class="w-full flex items-center justify-between px-6 py-4 hover:bg-slate-50 transition text-left">
                <div class="flex items-center gap-4">
                    <span class="text-slate-500 font-mono text-sm">{{ $run['started_at'] }}</span>
                    @if(!empty($run['company']))
                        <span class="bg-blue-100 text-blue-700 text-xs font-bold px-2 py-0.5 rounded-full">{{ $run['company'] }}</span>
                    @endif
                    <span class="text-xs text-slate-400">limit: {{ $run['limit'] }}</span>
                </div>
                <div class="flex items-center gap-3">
                    <span class="bg-green-100 text-green-700 text-xs font-bold px-3 py-1 rounded-full">
                        ✅ {{ count($run['saved'] ?? []) }} saved
                    </span>
                    <span class="bg-red-100 text-red-600 text-xs font-bold px-3 py-1 rounded-full">
                        ❌ {{ count($run['failed'] ?? []) }} failed
                    </span>
                    <span class="text-slate-400 text-xs" x-text="open ? '▲ Collapse' : '▼ Expand'"></span>
                </div>
            </button>

            <div x-show="open" x-transition class="border-t border-slate-100">
                <div class="grid grid-cols-1 lg:grid-cols-2 divide-y lg:divide-y-0 lg:divide-x divide-slate-100">
                    {{-- Saved --}}
                    <div class="p-4">
                        <h4 class="text-xs font-bold text-green-600 uppercase tracking-wider mb-2">
                            ✅ {{ count($run['saved'] ?? []) }} Products — Image Found
                        </h4>
                        @if(!empty($run['saved']))
                        <div class="overflow-auto max-h-52">
                            <table class="min-w-full text-xs">
                                <thead><tr class="text-slate-400 uppercase border-b border-slate-100">
                                    <th class="pb-1 pr-3 text-left">Time</th>
                                    <th class="pb-1 pr-3 text-left">Product</th>
                                    <th class="pb-1 text-left">Company</th>
                                </tr></thead>
                                <tbody class="divide-y divide-slate-50">
                                    @foreach($run['saved'] as $item)
                                    <tr class="hover:bg-green-50">
                                        <td class="py-1 pr-3 text-slate-400 font-mono">{{ $item['at'] ?? '' }}</td>
                                        <td class="py-1 pr-3 font-semibold text-slate-700 truncate max-w-[140px]" title="{{ $item['name'] }}">{{ $item['name'] }}</td>
                                        <td class="py-1 text-slate-500 truncate max-w-[100px]" title="{{ $item['company'] }}">{{ $item['company'] }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <p class="text-slate-400 text-xs italic">None found in this run.</p>
                        @endif
                    </div>

                    {{-- Failed --}}
                    <div class="p-4">
                        <h4 class="text-xs font-bold text-red-500 uppercase tracking-wider mb-2">
                            ❌ {{ count($run['failed'] ?? []) }} Products — Not Found
                        </h4>
                        @if(!empty($run['failed']))
                        <div class="overflow-auto max-h-52">
                            <table class="min-w-full text-xs">
                                <thead><tr class="text-slate-400 uppercase border-b border-slate-100">
                                    <th class="pb-1 pr-3 text-left">Time</th>
                                    <th class="pb-1 pr-3 text-left">Product</th>
                                    <th class="pb-1 text-left">Company</th>
                                </tr></thead>
                                <tbody class="divide-y divide-slate-50">
                                    @foreach($run['failed'] as $item)
                                    <tr class="hover:bg-red-50">
                                        <td class="py-1 pr-3 text-slate-400 font-mono">{{ $item['at'] ?? '' }}</td>
                                        <td class="py-1 pr-3 font-medium text-slate-600 truncate max-w-[140px]" title="{{ $item['name'] }}">{{ $item['name'] }}</td>
                                        <td class="py-1 text-slate-500 truncate max-w-[100px]" title="{{ $item['company'] }}">{{ $item['company'] }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <p class="text-slate-400 text-xs italic">No failures in this run.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div id="noHistoryMsg" class="bg-slate-50 rounded-2xl border border-slate-200 p-8 text-center text-slate-400">
            <p class="text-4xl mb-2">📋</p>
            <p>No run history yet. Start your first fetch to see results here.</p>
        </div>
        @endforelse
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════════ --}}
{{-- JavaScript — AJAX polling + controls                            --}}
{{-- ═══════════════════════════════════════════════════════════════ --}}
<script>
const CSRF      = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const POLL_URL  = "{{ route('admin.product-images.poll') }}";
const FETCH_URL = "{{ route('admin.product-images.fetch') }}";
const STOP_URL  = "{{ route('admin.product-images.stop') }}";
const RESET_URL = "{{ route('admin.product-images.reset') }}";
const LOG_URL   = "{{ route('admin.product-images.log') }}";

let pollingInterval = null;
let logInterval     = null;
let isRunning       = {{ $isRunning ? 'true' : 'false' }};
let lastSavedCount  = 0;
let lastFailedCount = 0;

// ── Start / Stop ─────────────────────────────────────────────────

function startFetch() {
    const limit   = document.getElementById('ctrlLimit').value;
    const company = document.getElementById('ctrlCompany').value;
    const delay   = document.getElementById('ctrlDelay').value;
    const force   = document.getElementById('ctrlForce').checked ? '1' : '0';

    setMsg('⏳ Launching background job…', 'blue');
    document.getElementById('startBtn').disabled = true;

    // Reset current run panel
    lastSavedCount = 0; lastFailedCount = 0;
    document.getElementById('curSaved').textContent  = '0';
    document.getElementById('curFailed').textContent = '0';
    document.getElementById('curSavedBody').innerHTML  = '<tr><td colspan="3" class="p-3 text-slate-400 italic text-center">Waiting…</td></tr>';
    document.getElementById('curFailedBody').innerHTML = '<tr><td colspan="3" class="p-3 text-slate-400 italic text-center">None yet…</td></tr>';

    fetch(FETCH_URL, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
        body: JSON.stringify({ limit, company, delay, force })
    })
    .then(r => r.json())
    .then(data => {
        if (data.status === 'started') {
            setMsg('✅ ' + data.message, 'green');
            setRunning(true);
        } else if (data.status === 'already_running') {
            setMsg('⚠️ ' + data.message, 'amber');
            document.getElementById('startBtn').disabled = false;
        } else {
            setMsg('❌ Unexpected response.', 'red');
            document.getElementById('startBtn').disabled = false;
        }
    })
    .catch(e => {
        setMsg('❌ Request failed: ' + e.message, 'red');
        document.getElementById('startBtn').disabled = false;
    });
}

function stopFetch() {
    fetch(STOP_URL, { method: 'POST', headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' } })
    .then(() => { setRunning(false); setMsg('⏹ Stop signal sent.', 'amber'); });
}

function resetProgress() {
    if (!confirm('Clear all progress logs? Already saved images on disk & DB are unaffected.')) return;
    fetch(RESET_URL, { method: 'POST', headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' } })
    .then(r => r.json()).then(() => {
        document.getElementById('tallySaved').textContent  = '0';
        document.getElementById('tallyFailed').textContent = '0';
        document.getElementById('lastRun').textContent     = 'Never';
        document.getElementById('runHistoryList').innerHTML = `
            <div class="bg-slate-50 rounded-2xl border border-slate-200 p-8 text-center text-slate-400">
                <p class="text-4xl mb-2">📋</p><p>No run history yet.</p>
            </div>`;
        setMsg('🗑️ Progress log cleared.', 'slate');
    });
}

function clearLog() {
    document.getElementById('logBox').innerHTML = '<p class="text-slate-500">Log cleared.</p>';
}

// ── UI state ─────────────────────────────────────────────────────

function setRunning(running) {
    isRunning = running;
    const banner   = document.getElementById('runningBanner');
    const startBtn = document.getElementById('startBtn');
    const section  = document.getElementById('currentRunSection');
    const spinner  = document.getElementById('currentRunSpinner');
    if (running) {
        banner.classList.remove('hidden');
        section.classList.remove('hidden');
        spinner.classList.add('animate-spin');
        startBtn.disabled = true;
        startPolling();
    } else {
        banner.classList.add('hidden');
        spinner.classList.remove('animate-spin');
        startBtn.disabled = false;
        stopPolling();
    }
}

function setMsg(msg, colour) {
    const el = document.getElementById('startMsg');
    const colours = { blue:'text-blue-600', green:'text-green-600', amber:'text-amber-600', red:'text-red-600', slate:'text-slate-500' };
    el.className = 'mt-3 text-sm text-center font-medium ' + (colours[colour] || 'text-slate-600');
    el.textContent = msg;
    el.classList.remove('hidden');
}

// ── Polling ───────────────────────────────────────────────────────

function startPolling() {
    if (pollingInterval) return;
    pollingInterval = setInterval(pollStatus, 3000);
    logInterval     = setInterval(fetchLog,   3000);
    fetchLog(); pollStatus();
}

function stopPolling() {
    clearInterval(pollingInterval);
    clearInterval(logInterval);
    pollingInterval = null; logInterval = null;
    setTimeout(pollStatus, 1500); // final update
}

function pollStatus() {
    fetch(POLL_URL, { headers: { 'Accept': 'application/json' } })
    .then(r => r.json())
    .then(data => {
        // Stat cards
        document.getElementById('statTotal').textContent   = data.stats.total.toLocaleString();
        document.getElementById('statWithImg').textContent = data.stats.with_img.toLocaleString();
        document.getElementById('statMissing').textContent = data.stats.missing.toLocaleString();
        document.getElementById('statPct').textContent     = data.stats.pct + '%';

        // Progress bar
        document.getElementById('progressBar').style.width     = data.stats.pct + '%';
        document.getElementById('progressLabel').textContent   = data.stats.with_img.toLocaleString() + ' / ' + data.stats.total.toLocaleString();
        document.getElementById('progressPctLabel').textContent = data.stats.pct + '% done';

        // Tallies
        document.getElementById('tallySaved').textContent  = data.total_saved;
        document.getElementById('tallyFailed').textContent = data.total_failed;
        if (data.last_run) document.getElementById('lastRun').textContent = data.last_run;

        // ── Current Run live data ────────────────────────────────
        if (data.current_run) {
            const cr = data.current_run;
            document.getElementById('curSaved').textContent  = cr.saved_count  || 0;
            document.getElementById('curFailed').textContent = cr.failed_count || 0;
            if (cr.started_at) document.getElementById('curStartedAt').textContent = 'Started: ' + cr.started_at;

            // Rebuild saved body only if new items arrived
            const savedItems  = cr.saved  || [];
            const failedItems = cr.failed || [];

            if (savedItems.length !== lastSavedCount) {
                lastSavedCount = savedItems.length;
                const savedBody = document.getElementById('curSavedBody');
                if (savedItems.length === 0) {
                    savedBody.innerHTML = '<tr><td colspan="3" class="p-3 text-slate-400 italic text-center">Waiting…</td></tr>';
                } else {
                    savedBody.innerHTML = [...savedItems].reverse().map(item =>
                        `<tr class="hover:bg-green-50 animate-pulse-once">
                            <td class="py-1.5 px-2 text-slate-400 font-mono whitespace-nowrap">${esc(item.at || '')}</td>
                            <td class="py-1.5 px-2 font-semibold text-slate-700 truncate max-w-[140px]" title="${esc(item.name)}">${esc(item.name)}</td>
                            <td class="py-1.5 px-2 text-slate-500 truncate max-w-[100px]" title="${esc(item.company)}">${esc(item.company)}</td>
                        </tr>`
                    ).join('');
                }
            }

            if (failedItems.length !== lastFailedCount) {
                lastFailedCount = failedItems.length;
                const failedBody = document.getElementById('curFailedBody');
                if (failedItems.length === 0) {
                    failedBody.innerHTML = '<tr><td colspan="3" class="p-3 text-slate-400 italic text-center">None yet…</td></tr>';
                } else {
                    failedBody.innerHTML = [...failedItems].reverse().map(item =>
                        `<tr class="hover:bg-red-50">
                            <td class="py-1.5 px-2 text-slate-400 font-mono whitespace-nowrap">${esc(item.at || '')}</td>
                            <td class="py-1.5 px-2 font-medium text-slate-600 truncate max-w-[140px]" title="${esc(item.name)}">${esc(item.name)}</td>
                            <td class="py-1.5 px-2 text-slate-500 truncate max-w-[100px]" title="${esc(item.company)}">${esc(item.company)}</td>
                        </tr>`
                    ).join('');
                }
            }
        }

        // ── Run history (rebuild when job finishes) ──────────────
        if (!data.is_running && isRunning) {
            // Job just completed — reload run history
            renderRunHistory(data.run_history || []);
            setRunning(false);
            setMsg('✅ Job complete! Check Run History below.', 'green');
        }

        if (!data.is_running && !isRunning) {
            // Keep history fresh even without a running job
            renderRunHistory(data.run_history || []);
        }
    })
    .catch(() => {});
}

function renderRunHistory(history) {
    const container = document.getElementById('runHistoryList');
    if (!history || history.length === 0) {
        container.innerHTML = `<div class="bg-slate-50 rounded-2xl border border-slate-200 p-8 text-center text-slate-400">
            <p class="text-4xl mb-2">📋</p><p>No run history yet.</p></div>`;
        return;
    }
    container.innerHTML = history.map((run, idx) => {
        const savedCount  = (run.saved  || []).length;
        const failedCount = (run.failed || []).length;
        const savedRows   = (run.saved  || []).slice().reverse().map(item =>
            `<tr class="hover:bg-green-50">
                <td class="py-1 pr-3 text-slate-400 font-mono">${esc(item.at||'')}</td>
                <td class="py-1 pr-3 font-semibold text-slate-700 truncate max-w-[130px]" title="${esc(item.name)}">${esc(item.name)}</td>
                <td class="py-1 text-slate-500 truncate max-w-[90px]">${esc(item.company)}</td>
            </tr>`).join('');
        const failedRows  = (run.failed || []).slice().reverse().map(item =>
            `<tr class="hover:bg-red-50">
                <td class="py-1 pr-3 text-slate-400 font-mono">${esc(item.at||'')}</td>
                <td class="py-1 pr-3 font-medium text-slate-600 truncate max-w-[130px]" title="${esc(item.name)}">${esc(item.name)}</td>
                <td class="py-1 text-slate-500 truncate max-w-[90px]">${esc(item.company)}</td>
            </tr>`).join('');

        return `<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <button onclick="toggleRun(${idx})"
                    class="w-full flex items-center justify-between px-6 py-4 hover:bg-slate-50 transition text-left">
                <div class="flex items-center gap-4">
                    <span class="text-slate-500 font-mono text-sm">${esc(run.started_at||'')}</span>
                    ${run.company ? `<span class="bg-blue-100 text-blue-700 text-xs font-bold px-2 py-0.5 rounded-full">${esc(run.company)}</span>` : ''}
                    <span class="text-xs text-slate-400">limit: ${run.limit||'?'}</span>
                </div>
                <div class="flex items-center gap-3">
                    <span class="bg-green-100 text-green-700 text-xs font-bold px-3 py-1 rounded-full">✅ ${savedCount} saved</span>
                    <span class="bg-red-100 text-red-600 text-xs font-bold px-3 py-1 rounded-full">❌ ${failedCount} failed</span>
                    <span class="text-slate-400 text-xs" id="runToggleLbl-${idx}">▼ Expand</span>
                </div>
            </button>
            <div id="runDetail-${idx}" class="hidden border-t border-slate-100">
                <div class="grid grid-cols-1 lg:grid-cols-2 divide-y lg:divide-y-0 lg:divide-x divide-slate-100">
                    <div class="p-4">
                        <h4 class="text-xs font-bold text-green-600 uppercase tracking-wider mb-2">✅ ${savedCount} Found</h4>
                        ${savedCount > 0 ? `<div class="overflow-auto max-h-52"><table class="min-w-full text-xs">
                            <thead><tr class="text-slate-400 uppercase border-b border-slate-100">
                                <th class="pb-1 pr-3 text-left">Time</th><th class="pb-1 pr-3 text-left">Product</th><th class="pb-1 text-left">Company</th>
                            </tr></thead><tbody class="divide-y divide-slate-50">${savedRows}</tbody></table></div>` :
                            '<p class="text-slate-400 text-xs italic">None found.</p>'}
                    </div>
                    <div class="p-4">
                        <h4 class="text-xs font-bold text-red-500 uppercase tracking-wider mb-2">❌ ${failedCount} Not Found</h4>
                        ${failedCount > 0 ? `<div class="overflow-auto max-h-52"><table class="min-w-full text-xs">
                            <thead><tr class="text-slate-400 uppercase border-b border-slate-100">
                                <th class="pb-1 pr-3 text-left">Time</th><th class="pb-1 pr-3 text-left">Product</th><th class="pb-1 text-left">Company</th>
                            </tr></thead><tbody class="divide-y divide-slate-50">${failedRows}</tbody></table></div>` :
                            '<p class="text-slate-400 text-xs italic">No failures.</p>'}
                    </div>
                </div>
            </div>
        </div>`;
    }).join('');
}

function toggleRun(idx) {
    const detail = document.getElementById('runDetail-' + idx);
    const lbl    = document.getElementById('runToggleLbl-' + idx);
    const hidden = detail.classList.toggle('hidden');
    lbl.textContent = hidden ? '▼ Expand' : '▲ Collapse';
}

function fetchLog() {
    fetch(LOG_URL, { headers: { 'Accept': 'application/json' } })
    .then(r => r.json())
    .then(data => {
        const box = document.getElementById('logBox');
        if (data.lines && data.lines.length > 0) {
            box.innerHTML = data.lines.map(l =>
                `<p class="${l.includes('✅') ? 'text-green-400' : l.includes('❌') ? 'text-red-400' : l.includes('╔')||l.includes('║') ? 'text-blue-400' : 'text-slate-400'}">${esc(l)}</p>`
            ).join('');
            box.scrollTop = box.scrollHeight;
        }
    }).catch(() => {});
}

function esc(str) {
    return String(str).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}

// Auto-start polling if already running on page load
if (isRunning) startPolling();
</script>

@endsection
