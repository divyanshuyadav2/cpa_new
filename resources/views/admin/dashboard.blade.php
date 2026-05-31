@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-extrabold text-pharma-navy">Dashboard Overview</h1>
    <p class="text-sm text-slate-500 mt-1">Here is a quick snapshot of your agency's product stock, brands, and order flow.</p>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-8">
    <!-- Total Products -->
    <div class="bg-white overflow-hidden shadow-sm border border-slate-200 rounded-2xl flex items-center p-6 space-x-4">
        <div class="p-3 bg-blue-100 rounded-xl text-blue-600 text-2xl">💊</div>
        <div>
            <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider">Total Products</span>
            <strong class="text-2xl font-black text-slate-800">{{ $totalProducts }}</strong>
        </div>
    </div>
    
    <!-- Total Companies -->
    <div class="bg-white overflow-hidden shadow-sm border border-slate-200 rounded-2xl flex items-center p-6 space-x-4">
        <div class="p-3 bg-purple-100 rounded-xl text-purple-600 text-2xl">🏢</div>
        <div>
            <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider">Total Companies</span>
            <strong class="text-2xl font-black text-slate-800">{{ $totalCompanies }}</strong>
        </div>
    </div>

    <!-- Total Divisions -->
    <div class="bg-white overflow-hidden shadow-sm border border-slate-200 rounded-2xl flex items-center p-6 space-x-4">
        <div class="p-3 bg-orange-100 rounded-xl text-orange-600 text-2xl">🗂️</div>
        <div>
            <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider">Total Divisions</span>
            <strong class="text-2xl font-black text-slate-800">{{ $totalDivisions }}</strong>
        </div>
    </div>

    <!-- Orders Today -->
    <div class="bg-white overflow-hidden shadow-sm border border-slate-200 rounded-2xl flex items-center p-6 space-x-4">
        <div class="p-3 bg-green-100 rounded-xl text-green-600 text-2xl">📈</div>
        <div>
            <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider">Orders Today</span>
            <strong class="text-2xl font-black text-slate-800">{{ $ordersToday }}</strong>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <!-- Recent Orders (2 columns on lg) -->
    <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col h-fit">
        <div class="px-6 py-4 border-b border-slate-200 bg-slate-50 flex justify-between items-center">
            <h2 class="text-sm font-bold text-slate-700 uppercase tracking-wider">Recent Orders</h2>
            <a href="{{ route('orders.index') }}" class="text-xs font-semibold text-pharma-accent hover:text-pharma-navy">View All &rarr;</a>
        </div>
        
        @if($recentOrders->isEmpty())
            <div class="p-12 text-center text-slate-400">
                <span class="text-3xl block mb-2">🛒</span>
                No orders received yet.
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-200 bg-slate-100/50 text-[10px] font-bold text-slate-500 uppercase">
                            <th class="p-4">Order ID</th>
                            <th class="p-4">Customer</th>
                            <th class="p-4">Total</th>
                            <th class="p-4">Status</th>
                            <th class="p-4">Date</th>
                            <th class="p-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @foreach($recentOrders as $order)
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="p-4 font-bold text-slate-900">#{{ $order->id }}</td>
                                <td class="p-4">
                                    <span class="block font-semibold text-slate-800">{{ $order->customer_name }}</span>
                                    <span class="text-xs text-slate-500">{{ $order->phone }}</span>
                                </td>
                                <td class="p-4 font-bold text-slate-900">₹{{ number_format($order->total, 2) }}</td>
                                <td class="p-4">
                                    @if($order->status == 'Pending')
                                        <span class="inline-flex px-2 py-0.5 rounded-full text-[10px] font-bold bg-yellow-100 text-yellow-800 border border-yellow-200">Pending</span>
                                    @elseif($order->status == 'Confirmed')
                                        <span class="inline-flex px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-800 border border-blue-200">Confirmed</span>
                                    @else
                                        <span class="inline-flex px-2 py-0.5 rounded-full text-[10px] font-bold bg-green-100 text-green-800 border border-green-200">Dispatched</span>
                                    @endif
                                </td>
                                <td class="p-4 text-xs text-slate-500">{{ $order->created_at->format('d-M-y') }}</td>
                                <td class="p-4 text-right">
                                    <a href="{{ route('orders.show', $order->id) }}" class="px-2.5 py-1 bg-slate-100 text-slate-700 font-semibold text-xs rounded border border-slate-200 hover:bg-slate-200 transition">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <!-- Low Stock Alerts (1 column on lg) -->
    <div class="lg:col-span-1 bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col h-fit">
        <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
            <h2 class="text-sm font-bold text-red-700 uppercase tracking-wider">⚠️ Low Stock Alerts</h2>
        </div>

        @if($lowStockAlerts->isEmpty())
            <div class="p-8 text-center text-slate-400">
                <span class="text-3xl block mb-2">✅</span>
                All inventory quantities are above threshold levels.
            </div>
        @else
            <div class="divide-y divide-slate-100 max-h-[400px] overflow-y-auto">
                @foreach($lowStockAlerts as $item)
                    <div class="p-4 flex justify-between items-center hover:bg-red-50/20 transition">
                        <div>
                            <strong class="block text-sm text-slate-800 leading-tight">{{ $item->name }}</strong>
                            <span class="text-[10px] text-slate-500">{{ $item->company->name }} &bull; {{ $item->division->name }}</span>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center justify-center px-2.5 py-1 rounded-lg text-xs font-black {{ $item->stock_qty == 0 ? 'bg-red-200 text-red-900' : 'bg-orange-100 text-orange-800' }}">
                                Qty: {{ $item->stock_qty }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="p-4 border-t border-slate-100 bg-slate-50 text-center">
                <a href="{{ route('products.index') }}" class="text-xs font-bold text-pharma-accent hover:text-pharma-navy">Manage Products Stock &rarr;</a>
            </div>
        @endif
    </div>

</div>
@endsection
