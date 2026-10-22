@extends('layouts.admin')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3 mb-6">
    <div>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-pharma-navy font-display">Orders</h1>
        <p class="text-sm text-slate-500 mt-1">{{ $summary['count'] }} order(s) &middot; ₹{{ number_format($summary['total'], 2) }} value (excl. cancelled)</p>
    </div>
    <a href="{{ route('orders.export', request()->query()) }}" class="self-start px-4 py-2 bg-white border border-slate-200 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-50 transition">⬇ Export CSV</a>
</div>

<!-- Status tabs -->
<div class="flex gap-2 overflow-x-auto pb-2 mb-4">
    @php $all = $statusCounts->sum(); @endphp
    <a href="{{ route('orders.index', request()->except('status', 'page')) }}" class="flex-shrink-0 px-3 py-1.5 rounded-full text-xs font-bold border transition {{ !request('status') ? 'bg-pharma-navy text-white border-pharma-navy' : 'bg-white text-slate-600 border-slate-200 hover:border-slate-400' }}">All ({{ $all }})</a>
    @foreach(\App\Models\Order::STATUSES as $st)
        <a href="{{ route('orders.index', array_merge(request()->except('page'), ['status' => $st])) }}" class="flex-shrink-0 px-3 py-1.5 rounded-full text-xs font-bold border transition {{ request('status') === $st ? 'bg-pharma-navy text-white border-pharma-navy' : 'bg-white text-slate-600 border-slate-200 hover:border-slate-400' }}">{{ $st }} ({{ $statusCounts[$st] ?? 0 }})</a>
    @endforeach
</div>

<!-- Filters -->
<form method="GET" class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4 mb-4 grid grid-cols-1 sm:grid-cols-6 gap-3">
    @if(request('status'))<input type="hidden" name="status" value="{{ request('status') }}">@endif
    <input type="search" name="q" value="{{ request('q') }}" placeholder="Search #id, customer, phone, invoice…" class="sm:col-span-2 bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pharma-accent focus:bg-white">
    
    <select name="salesman_id" class="bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pharma-accent">
        <option value="">-- All Salesmen --</option>
        @foreach($salesmen as $sm)
            <option value="{{ $sm->id }}" {{ request('salesman_id') == $sm->id ? 'selected' : '' }}>
                👔 {{ $sm->name }}
            </option>
        @endforeach
    </select>

    <input type="date" name="from" value="{{ request('from') }}" title="From date" class="bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pharma-accent">
    <input type="date" name="to" value="{{ request('to') }}" title="To date" class="bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pharma-accent">
    <div class="flex gap-2">
        <button class="flex-1 px-4 py-2 bg-pharma-navy text-white text-sm font-bold rounded-xl hover:bg-slate-700 transition">Filter</button>
        @if(request()->hasAny(['q', 'from', 'to', 'status', 'salesman_id']))
            <a href="{{ route('orders.index') }}" class="px-3 py-2 text-sm font-bold text-slate-500 hover:text-slate-800">Reset</a>
        @endif
    </div>
</form>

<form action="{{ route('orders.bulk-status') }}" method="POST" x-data="{ ids: [], all: false, toggle() { this.ids = this.all ? [...document.querySelectorAll('.row-check')].map(e => e.value) : [] } }">
    @csrf

    <!-- Bulk action bar -->
    <div x-show="ids.length" x-cloak style="display:none" class="sticky top-0 z-10 mb-3 flex flex-wrap items-center gap-3 px-4 py-3 bg-pharma-navy text-white rounded-xl shadow-lg">
        <span class="text-sm font-bold"><span x-text="ids.length"></span> selected</span>
        <select name="status" required class="text-slate-900 text-sm rounded-lg px-2 py-1.5">
            <option value="">Change status to…</option>
            @foreach(\App\Models\Order::STATUSES as $st)<option>{{ $st }}</option>@endforeach
        </select>
        <button class="px-3 py-1.5 bg-pharma-gold text-white text-sm font-bold rounded-lg hover:opacity-90">Apply</button>
    </div>
    <template x-for="id in ids" :key="id"><input type="hidden" name="ids[]" :value="id"></template>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        @if($orders->isEmpty())
            <div class="p-12 text-center text-slate-400">
                <span class="text-4xl block mb-3">🛒</span>
                {{ request()->hasAny(['q', 'from', 'to', 'status']) ? 'No orders match your filters.' : 'No orders placed yet.' }}
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-200 bg-slate-50 text-[10px] font-bold text-slate-500 uppercase">
                            <th class="p-4 w-8"><input type="checkbox" x-model="all" @change="toggle()" class="rounded"></th>
                            <th class="p-4">Order</th>
                            <th class="p-4">Customer</th>
                            <th class="p-4">Salesman</th>
                            <th class="p-4">Total</th>
                            <th class="p-4">Status</th>
                            <th class="p-4">Date</th>
                            <th class="p-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @foreach($orders as $order)
                            @php $noteText = $order->notes ?: (is_array($order->cart) ? ($order->cart['_order_notes'] ?? null) : null); @endphp
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="p-4"><input type="checkbox" value="{{ $order->id }}" x-model="ids" class="row-check rounded"></td>
                                <td class="p-4 font-bold text-slate-900">
                                    <a href="{{ route('orders.show', $order) }}" class="hover:text-pharma-accent">#{{ $order->id }}</a>
                                    @if($noteText)<span class="block text-[10px] font-bold text-amber-700 bg-amber-100 px-1.5 py-0.5 rounded border border-amber-200 w-fit mt-1" title="{{ $noteText }}">📝 Note</span>@endif
                                </td>
                                <td class="p-4">
                                    <span class="block font-semibold text-slate-800">{{ $order->customer_name }}</span>
                                    <a href="tel:{{ $order->phone }}" class="text-xs text-slate-500 hover:text-pharma-accent">{{ $order->phone }}</a>
                                </td>
                                <td class="p-4 whitespace-nowrap">
                                    @if($order->salesman)
                                        <a href="{{ route('orders.index', ['salesman_id' => $order->salesman->id]) }}" 
                                           class="inline-flex items-center space-x-1 px-2.5 py-1 rounded-lg bg-amber-50 text-amber-900 border border-amber-200 text-xs font-bold hover:bg-amber-100 transition" 
                                           title="Filter orders by this salesman">
                                            <span>👔</span>
                                            <span>{{ $order->salesman->name }}</span>
                                        </a>
                                    @else
                                        <span class="text-xs text-slate-400 italic">Direct</span>
                                    @endif
                                </td>
                                <td class="p-4 font-bold text-slate-950">₹{{ number_format($order->total, 2) }}</td>
                                <td class="p-4">@include('admin.partials.status-badge', ['status' => $order->status_label])</td>
                                <td class="p-4 text-xs text-slate-500 whitespace-nowrap">{{ $order->created_at->format('d-M-Y h:i A') }}</td>
                                <td class="p-4 text-right whitespace-nowrap">
                                    <a href="{{ route('orders.show', $order) }}" class="px-3 py-1.5 bg-pharma-light text-pharma-navy hover:bg-pharma-navy hover:text-white font-bold text-xs rounded-xl border border-slate-200 transition">View</a>
                                    <a href="{{ route('orders.invoice', $order) }}" target="_blank" class="px-3 py-1.5 text-slate-600 hover:text-pharma-navy font-bold text-xs">🖨 Invoice</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-slate-200 bg-slate-50">{{ $orders->links() }}</div>
        @endif
    </div>
</form>
@endsection
