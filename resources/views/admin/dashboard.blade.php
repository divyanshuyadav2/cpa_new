@extends('layouts.admin')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-pharma-navy font-display">Dashboard</h1>
        <p class="text-sm text-slate-500 mt-1">{{ now()->format('l, d F Y') }} &middot; here's what needs your attention.</p>
    </div>
    <div class="inline-flex rounded-xl bg-white border border-slate-200 p-1 text-xs font-bold self-start">
        @foreach([7 => '7 days', 30 => '30 days', 90 => '90 days'] as $d => $label)
            <a href="{{ route('admin.dashboard', ['range' => $d]) }}"
               class="px-3 py-1.5 rounded-lg transition {{ $days == $d ? 'bg-pharma-navy text-white' : 'text-slate-500 hover:text-pharma-navy' }}">{{ $label }}</a>
        @endforeach
    </div>
</div>

<!-- Needs attention -->
@if($stats['pending_orders'] || $stats['pending_apps'] || $lowStockCount)
<div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-6">
    @if($stats['pending_orders'])
    <a href="{{ route('orders.index', ['status' => 'Pending']) }}" class="flex items-center justify-between px-4 py-3 rounded-xl bg-yellow-50 border border-yellow-200 hover:border-yellow-400 transition">
        <span class="text-sm font-semibold text-yellow-900">🛒 {{ $stats['pending_orders'] }} order(s) waiting for confirmation</span><span class="text-yellow-700 font-bold">&rarr;</span>
    </a>
    @endif
    @if($stats['pending_apps'])
    <a href="{{ route('applications.index') }}" class="flex items-center justify-between px-4 py-3 rounded-xl bg-sky-50 border border-sky-200 hover:border-sky-400 transition">
        <span class="text-sm font-semibold text-sky-900">📄 {{ $stats['pending_apps'] }} new stockist application(s)</span><span class="text-sky-700 font-bold">&rarr;</span>
    </a>
    @endif
    @if($lowStockCount)
    <a href="{{ route('products.index') }}" class="flex items-center justify-between px-4 py-3 rounded-xl bg-red-50 border border-red-200 hover:border-red-400 transition">
        <span class="text-sm font-semibold text-red-900">⚠️ {{ $lowStockCount }} product(s) low on stock</span><span class="text-red-700 font-bold">&rarr;</span>
    </a>
    @endif
</div>
@endif

<!-- KPI cards -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    @php
        $cards = [
            ['Orders today', $stats['orders_today'], '📈', 'from-emerald-400 to-green-600', route('orders.index', ['from' => now()->toDateString()])],
            ['Revenue today', '₹'.number_format($stats['revenue_today']), '💰', 'from-amber-400 to-orange-500', route('orders.index', ['from' => now()->toDateString()])],
            ['Revenue this month', '₹'.number_format($stats['revenue_month']), '🗓️', 'from-indigo-400 to-violet-600', route('orders.index', ['from' => now()->startOfMonth()->toDateString()])],
            ['Pending orders', $stats['pending_orders'], '⏳', 'from-yellow-300 to-amber-500', route('orders.index', ['status' => 'Pending'])],
            ['Products', $stats['products'], '💊', 'from-sky-400 to-blue-600', route('products.index')],
            ['Companies', $stats['companies'], '🏢', 'from-fuchsia-400 to-purple-600', route('companies.index')],
            ['Retailers', $stats['retailers'], '🏪', 'from-cyan-400 to-sky-600', route('admin.users.index')],
            ['Salesmen', $stats['salesmen'], '🧑‍💼', 'from-rose-400 to-pink-600', route('admin.users.index')],
        ];
    @endphp
    @foreach($cards as [$label, $value, $icon, $color, $href])
        <a href="{{ $href }}" class="bg-white shadow-sm border border-slate-200/70 rounded-2xl p-4 sm:p-5 flex items-center space-x-3 hover:-translate-y-0.5 hover:shadow-lg transition duration-200">
            <div class="w-11 h-11 flex items-center justify-center rounded-xl text-xl bg-gradient-to-br shadow-md shadow-slate-300/60 {{ $color }}">{{ $icon }}</div>
            <div class="min-w-0">
                <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider truncate">{{ $label }}</span>
                <strong class="text-xl sm:text-2xl font-black text-slate-800">{{ $value }}</strong>
            </div>
        </a>
    @endforeach
</div>

<!-- Chart + status breakdown -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-sm font-bold text-slate-700 uppercase tracking-wider">Sales — last {{ $days }} days</h2>
            <span class="text-xs text-slate-400">Cancelled orders excluded</span>
        </div>
        <div class="h-64"><canvas id="salesChart"></canvas></div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
        <h2 class="text-sm font-bold text-slate-700 uppercase tracking-wider mb-4">Orders by status</h2>
        @php $totalOrders = max($statusCounts->sum(), 1); @endphp
        <div class="space-y-3">
            @foreach(\App\Models\Order::STATUSES as $st)
                @php $c = $statusCounts[$st] ?? 0; @endphp
                <a href="{{ route('orders.index', ['status' => $st]) }}" class="block group">
                    <div class="flex justify-between text-xs mb-1"><span class="font-semibold text-slate-600 group-hover:text-pharma-accent">{{ $st }}</span><span class="font-bold text-slate-800">{{ $c }}</span></div>
                    <div class="h-2 rounded-full bg-slate-100 overflow-hidden"><div class="h-full rounded-full {{ ['Pending'=>'bg-yellow-400','Confirmed'=>'bg-blue-500','Dispatched'=>'bg-purple-500','Delivered'=>'bg-emerald-500','Cancelled'=>'bg-red-400'][$st] }}" style="width: {{ round($c / $totalOrders * 100) }}%"></div></div>
                </a>
            @endforeach
        </div>

        <h2 class="text-sm font-bold text-slate-700 uppercase tracking-wider mt-6 mb-3">Quick actions</h2>
        <div class="grid grid-cols-2 gap-2 text-xs font-bold">
            <a href="{{ route('products.create') }}" class="px-3 py-2.5 rounded-xl bg-pharma-light text-pharma-navy border border-slate-200 hover:bg-pharma-navy hover:text-white transition text-center">+ Product</a>
            <a href="{{ route('admin.users.create') }}" class="px-3 py-2.5 rounded-xl bg-pharma-light text-pharma-navy border border-slate-200 hover:bg-pharma-navy hover:text-white transition text-center">+ User</a>
            <a href="{{ route('products.import.index') }}" class="px-3 py-2.5 rounded-xl bg-pharma-light text-pharma-navy border border-slate-200 hover:bg-pharma-navy hover:text-white transition text-center">⬆ Import CSV</a>
            <a href="{{ route('orders.export') }}" class="px-3 py-2.5 rounded-xl bg-pharma-light text-pharma-navy border border-slate-200 hover:bg-pharma-navy hover:text-white transition text-center">⬇ Export orders</a>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Recent orders -->
    <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden h-fit">
        <div class="px-5 py-4 border-b border-slate-200 bg-slate-50 flex justify-between items-center">
            <h2 class="text-sm font-bold text-slate-700 uppercase tracking-wider">Recent Orders</h2>
            <a href="{{ route('orders.index') }}" class="text-xs font-semibold text-pharma-accent hover:text-pharma-navy">View all &rarr;</a>
        </div>
        @if($recentOrders->isEmpty())
            <div class="p-12 text-center text-slate-400"><span class="text-3xl block mb-2">🛒</span>No orders received yet.</div>
        @else
            <div class="divide-y divide-slate-100">
                @foreach($recentOrders as $order)
                    <div class="px-5 py-3 flex items-center justify-between gap-3 hover:bg-slate-50/60 transition">
                        <a href="{{ route('orders.show', $order) }}" class="min-w-0">
                            <span class="block text-sm font-bold text-slate-900 truncate">#{{ $order->id }} &middot; {{ $order->customer_name }}</span>
                            <span class="text-xs text-slate-500">{{ $order->phone }} &middot; {{ $order->created_at->diffForHumans() }}</span>
                        </a>
                        <div class="flex items-center gap-3 flex-shrink-0">
                            <span class="text-sm font-bold text-slate-900">₹{{ number_format($order->total, 2) }}</span>
                            @include('admin.partials.status-badge', ['status' => $order->status_label])
                            @if($order->status_label === 'Pending')
                                <form action="{{ route('orders.update-status', $order) }}" method="POST">@csrf @method('PATCH')
                                    <input type="hidden" name="status" value="Confirmed">
                                    <button class="px-2.5 py-1 bg-pharma-navy text-white text-xs font-bold rounded-lg hover:bg-slate-700 transition">Confirm</button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <div class="space-y-6">
        <!-- Top products -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-200 bg-slate-50"><h2 class="text-sm font-bold text-slate-700 uppercase tracking-wider">Top products ({{ $days }}d)</h2></div>
            @forelse($topProducts as $i => $p)
                <div class="px-5 py-3 flex items-center justify-between {{ !$loop->last ? 'border-b border-slate-100' : '' }}">
                    <span class="text-sm text-slate-800 truncate"><span class="text-slate-400 font-bold mr-2">{{ $i + 1 }}</span>{{ $p['name'] }}</span>
                    <span class="text-xs font-bold text-slate-600 flex-shrink-0 ml-2">{{ $p['qty'] }} units</span>
                </div>
            @empty
                <div class="p-6 text-center text-sm text-slate-400">No sales in this period.</div>
            @endforelse
        </div>

        <!-- Low stock -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-200 bg-slate-50 flex justify-between items-center">
                <h2 class="text-sm font-bold text-red-700 uppercase tracking-wider">⚠️ Low stock</h2>
                @if($stats['missing_images'])
                    <a href="{{ route('admin.product-images.index') }}" class="text-[10px] font-bold text-slate-500 hover:text-pharma-accent">{{ $stats['missing_images'] }} missing images</a>
                @endif
            </div>
            @if($lowStockAlerts->isEmpty())
                <div class="p-6 text-center text-sm text-slate-400">✅ All stock levels are healthy.</div>
            @else
                <div class="divide-y divide-slate-100 max-h-72 overflow-y-auto">
                    @foreach($lowStockAlerts as $item)
                        <a href="{{ route('products.edit', $item) }}" class="px-5 py-3 flex justify-between items-center hover:bg-red-50/30 transition">
                            <span class="min-w-0"><strong class="block text-sm text-slate-800 truncate">{{ $item->name }}</strong><span class="text-[10px] text-slate-500">{{ $item->company?->name ?? 'N/A' }}</span></span>
                            <span class="px-2 py-1 rounded-lg text-xs font-black flex-shrink-0 {{ $item->stock_qty == 0 ? 'bg-red-200 text-red-900' : 'bg-orange-100 text-orange-800' }}">{{ $item->stock_qty }}</span>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
    new Chart(document.getElementById('salesChart'), {
        data: {
            labels: @json($chart['labels']),
            datasets: [
                { type: 'bar', label: 'Revenue (₹)', data: @json($chart['revenue']), backgroundColor: 'rgba(2,132,199,.25)', borderColor: '#0284c7', borderWidth: 1, borderRadius: 6, yAxisID: 'y' },
                { type: 'line', label: 'Orders', data: @json($chart['orders']), borderColor: '#d97706', backgroundColor: '#d97706', tension: .3, pointRadius: 3, yAxisID: 'y1' }
            ]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            interaction: { mode: 'index', intersect: false },
            plugins: { legend: { position: 'bottom', labels: { boxWidth: 10, font: { size: 11 } } } },
            scales: {
                x: { grid: { display: false }, ticks: { maxTicksLimit: 10, font: { size: 10 } } },
                y: { beginAtZero: true, ticks: { font: { size: 10 } } },
                y1: { beginAtZero: true, position: 'right', grid: { display: false }, ticks: { precision: 0, font: { size: 10 } } }
            }
        }
    });
</script>
@endsection
