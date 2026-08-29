@extends('layouts.pwa')

@section('title', 'My Orders - Chitranshu Pharma PWA')

@section('content')
<div>
    <div class="mb-4 flex items-center justify-between">
        <div>
            <h1 class="text-xl font-extrabold text-white tracking-tight">Order History</h1>
            <p class="text-xs text-slate-400">Track status of placed medicine orders</p>
        </div>
        <a href="{{ route('pwa.retailer.catalog') }}" class="text-xs bg-sky-600 hover:bg-sky-500 text-white font-bold px-3 py-1.5 rounded-xl shadow transition">
            + New Order
        </a>
    </div>

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
                <div class="flex items-center justify-between">
                    <div>
                        <span class="text-xs font-bold text-sky-400">Order #{{ $order->id }}</span>
                        <span class="text-[11px] text-slate-400 block">{{ $order->created_at->format('d M Y, h:i A') }}</span>
                    </div>

                    <span class="text-xs font-bold px-2.5 py-1 rounded-full border {{ $color }}">
                        {{ $order->status }}
                    </span>
                </div>

                <div class="mt-3 flex items-center justify-between text-xs border-t border-slate-700/60 pt-2.5">
                    <span class="text-slate-300">Total Amount: <strong class="text-emerald-400">₹{{ number_format($order->total, 2) }}</strong></span>
                    
                    <button @click="expanded = !expanded" class="text-sky-400 hover:underline text-xs font-semibold">
                        <span x-text="expanded ? 'Hide Details' : 'View Items (' + {{ is_array($order->cart) ? count($order->cart) : 0 }} + ')'"></span>
                    </button>
                </div>

                <!-- Items Details Dropdown -->
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
                </div>
            </div>
        @empty
            <div class="text-center py-12 bg-slate-800/40 rounded-3xl border border-slate-800 text-slate-400">
                <span class="text-4xl block mb-2">📦</span>
                <p class="text-sm font-semibold">No orders placed yet.</p>
                <a href="{{ route('pwa.retailer.catalog') }}" class="inline-block mt-3 text-xs bg-sky-600 text-white font-bold px-4 py-2 rounded-xl">
                    Browse Medicine Catalog &rarr;
                </a>
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $orders->links() }}
    </div>
</div>
@endsection
