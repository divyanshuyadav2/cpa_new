@extends('layouts.pwa')

@section('title', 'Salesman Dashboard - Chitranshu Pharma PWA')

@section('content')
<div class="space-y-4">
    <!-- Header Title -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-extrabold text-white tracking-tight">Salesman Dashboard</h1>
            <p class="text-xs text-slate-400">Order Management & Delivery Tracking</p>
        </div>
        <a href="{{ route('pwa.retailer.catalog') }}" class="text-xs bg-emerald-600 hover:bg-emerald-500 text-white font-bold px-3.5 py-2 rounded-xl shadow transition">
            + New Order
        </a>
    </div>

    <!-- Quick Stats Cards -->
    <div class="grid grid-cols-3 gap-2 text-center">
        <div class="bg-slate-800/80 border border-slate-700/60 p-3 rounded-2xl">
            <span class="text-xs text-slate-400 block mb-0.5">Total Orders</span>
            <span class="text-lg font-black text-white">{{ $totalOrders }}</span>
        </div>
        <div class="bg-slate-800/80 border border-amber-500/30 p-3 rounded-2xl">
            <span class="text-xs text-amber-400 block mb-0.5">Pending</span>
            <span class="text-lg font-black text-amber-300">{{ $pendingCount }}</span>
        </div>
        <div class="bg-slate-800/80 border border-emerald-500/30 p-3 rounded-2xl">
            <span class="text-xs text-emerald-400 block mb-0.5">Delivered</span>
            <span class="text-lg font-black text-emerald-300">{{ $deliveredCount }}</span>
        </div>
    </div>

    <!-- Assigned Retailer Counters Accordion -->
    <div class="bg-slate-800/80 border border-slate-700/60 rounded-2xl p-3.5" x-data="{ open: false }">
        <div class="flex items-center justify-between cursor-pointer" @click="open = !open">
            <div class="flex items-center space-x-2">
                <span class="text-lg">🏪</span>
                <div>
                    <h3 class="text-xs font-bold text-white">Assigned Retailer Counters ({{ $retailers->count() }})</h3>
                    <p class="text-[10px] text-slate-400">Tap to view counters under your supervision</p>
                </div>
            </div>
            <span class="text-xs text-sky-400 font-bold" x-text="open ? '▲ Hide' : '▼ Show'"></span>
        </div>

        <div x-show="open" x-transition class="mt-3 pt-3 border-t border-slate-700 space-y-2">
            @forelse($retailers as $r)
                <div class="flex items-center justify-between bg-slate-900/80 p-2.5 rounded-xl border border-slate-700 text-xs">
                    <div>
                        <span class="font-bold text-white block">{{ $r->company_name ?: $r->name }}</span>
                        <span class="text-[10px] text-slate-400">📞 {{ $r->phone }} • 📍 {{ $r->address ?: 'No address' }}</span>
                    </div>
                    <a href="{{ route('pwa.retailer.catalog') }}" class="text-[11px] bg-sky-600/30 text-sky-300 hover:bg-sky-600 hover:text-white px-2.5 py-1 rounded-lg border border-sky-500/30 transition">
                        Order
                    </a>
                </div>
            @empty
                <p class="text-xs text-slate-500 text-center py-2">No retailers assigned yet.</p>
            @endforelse
        </div>
    </div>

    <!-- Orders Filter & Search -->
    <div>
        <div class="flex items-center justify-between mb-2">
            <h2 class="text-sm font-extrabold text-white">Counter Orders</h2>
            
            <!-- Status Filter Pills -->
            <div class="flex space-x-1 text-[11px]">
                <a href="{{ route('pwa.salesman.dashboard') }}"
                   class="px-2.5 py-1 rounded-lg border transition {{ !request('status') ? 'bg-sky-500/20 text-sky-300 border-sky-500/40 font-bold' : 'bg-slate-800 text-slate-400 border-slate-700' }}">
                    All
                </a>
                <a href="{{ route('pwa.salesman.dashboard', ['status' => 'Pending']) }}"
                   class="px-2.5 py-1 rounded-lg border transition {{ request('status') == 'Pending' ? 'bg-amber-500/20 text-amber-300 border-amber-500/40 font-bold' : 'bg-slate-800 text-slate-400 border-slate-700' }}">
                    Pending
                </a>
                <a href="{{ route('pwa.salesman.dashboard', ['status' => 'Delivered']) }}"
                   class="px-2.5 py-1 rounded-lg border transition {{ request('status') == 'Delivered' ? 'bg-emerald-500/20 text-emerald-300 border-emerald-500/40 font-bold' : 'bg-slate-800 text-slate-400 border-slate-700' }}">
                    Delivered
                </a>
            </div>
        </div>

        <!-- Orders List -->
        <div class="space-y-3">
            @forelse($orders as $order)
                @php
                    $statusColors = [
                        'Pending' => 'bg-amber-500/20 text-amber-300 border-amber-500/30',
                        'Confirmed' => 'bg-blue-500/20 text-blue-300 border-blue-500/30',
                        'Dispatched' => 'bg-purple-500/20 text-purple-300 border-purple-500/30',
                        'Delivered' => 'bg-emerald-500/20 text-emerald-300 border-emerald-500/30',
                    ];
                    $color = $statusColors[$order->status] ?? 'bg-slate-700 text-slate-300 border-slate-600';
                @endphp

                <div class="bg-slate-800/80 border border-slate-700/60 rounded-2xl p-4 shadow-sm" x-data="{ expanded: false }">
                    <div class="flex items-start justify-between">
                        <div>
                            <span class="text-xs font-bold text-sky-400">Order #{{ $order->id }}</span>
                            <h4 class="text-sm font-bold text-white leading-snug">{{ $order->customer_name }}</h4>
                            <p class="text-[11px] text-slate-400">📞 {{ $order->phone }} • {{ $order->created_at->format('d M Y, h:i A') }}</p>
                        </div>

                        <span class="text-xs font-bold px-2.5 py-1 rounded-full border {{ $color }}">
                            {{ $order->status }}
                        </span>
                    </div>

                    <!-- Items Summary & Total -->
                    <div class="mt-3 flex items-center justify-between text-xs border-t border-slate-700/60 pt-2.5">
                        <span class="text-slate-300">Total: <strong class="text-emerald-400">₹{{ number_format($order->total, 2) }}</strong></span>
                        <button @click="expanded = !expanded" class="text-sky-400 hover:underline text-xs font-semibold">
                            <span x-text="expanded ? 'Hide Items' : 'View Items (' + {{ is_array($order->cart) ? count($order->cart) : 0 }} + ')'"></span>
                        </button>
                    </div>

                    <!-- Expandable Items List -->
                    <div x-show="expanded" x-transition class="mt-3 pt-3 border-t border-slate-700/60 space-y-2">
                        @if(is_array($order->cart))
                            @foreach($order->cart as $item)
                                <div class="flex items-center justify-between text-xs bg-slate-900/80 p-2 rounded-xl border border-slate-700">
                                    <div>
                                        <span class="font-bold text-white block">{{ $item['name'] ?? 'Product' }}</span>
                                        <span class="text-[10px] text-slate-400">{{ $item['packing'] ?? '' }} x {{ $item['qty'] }}</span>
                                    </div>
                                    <span class="font-semibold text-slate-300">₹{{ number_format(($item['price'] ?? 0) * ($item['qty'] ?? 1), 2) }}</span>
                                </div>
                            @endforeach
                        @endif

                        @if(!empty($order->notes))
                            <div class="bg-amber-500/10 border border-amber-500/20 p-2 rounded-xl text-xs text-amber-200">
                                <span class="font-bold block text-[10px] uppercase tracking-wider text-amber-400">📝 Retailer Note:</span>
                                {{ $order->notes }}
                            </div>
                        @endif
                    </div>

                    <!-- Delivery Status Change Actions for Salesman -->
                    <div class="mt-3 pt-3 border-t border-slate-700/60 flex items-center justify-between gap-2">
                        <span class="text-[11px] text-slate-400 font-semibold">Update Status:</span>

                        <form action="{{ route('pwa.salesman.order.status', $order->id) }}" method="POST" class="flex items-center space-x-1">
                            @csrf
                            @method('PATCH')

                            @if($order->status !== 'Confirmed')
                                <button type="submit" name="status" value="Confirmed"
                                        class="px-2.5 py-1 rounded-lg bg-blue-500/20 text-blue-300 hover:bg-blue-600 hover:text-white border border-blue-500/30 text-[11px] font-bold transition">
                                    Confirm
                                </button>
                            @endif

                            @if($order->status !== 'Dispatched')
                                <button type="submit" name="status" value="Dispatched"
                                        class="px-2.5 py-1 rounded-lg bg-purple-500/20 text-purple-300 hover:bg-purple-600 hover:text-white border border-purple-500/30 text-[11px] font-bold transition">
                                    Dispatch
                                </button>
                            @endif

                            @if($order->status !== 'Delivered')
                                <button type="submit" name="status" value="Delivered"
                                        class="px-3 py-1 rounded-lg bg-emerald-500 text-white hover:bg-emerald-400 text-[11px] font-extrabold shadow transition flex items-center space-x-1">
                                    <span>✅ Mark Delivered</span>
                                </button>
                            @endif
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-center py-10 bg-slate-800/40 rounded-3xl border border-slate-800 text-slate-400">
                    <span class="text-3xl block mb-1">📋</span>
                    <p class="text-xs font-semibold">No orders found.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-4">
            {{ $orders->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection
