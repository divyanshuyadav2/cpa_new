<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Order;
use App\Models\Product;
use App\Models\StockistApplication;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $days = in_array((int) $request->query('range'), [7, 30, 90], true) ? (int) $request->query('range') : 7;
        $start = Carbon::today()->subDays($days - 1);

        // Revenue excludes cancelled orders.
        $valid = fn () => Order::notCancelled();

        $stats = [
            'orders_today'    => Order::whereDate('created_at', Carbon::today())->count(),
            'revenue_today'   => (float) $valid()->whereDate('created_at', Carbon::today())->sum('total'),
            'revenue_month'   => (float) $valid()->where('created_at', '>=', Carbon::now()->startOfMonth())->sum('total'),
            'pending_orders'  => Order::withStatus('Pending')->count(),
            'pending_apps'    => StockistApplication::where('status', 'Pending')->count(),
            'products'        => Product::count(),
            'companies'       => Company::count(),
            'retailers'       => User::where('role', 'retailer')->count(),
            'salesmen'        => User::where('role', 'salesman')->count(),
            'missing_images'  => Product::where(fn ($q) => $q->whereNull('image')->orWhere('image', ''))->count(),
        ];

        // Daily orders + revenue for the chart (zero-filled).
        $daily = Order::where('created_at', '>=', $start)
            ->notCancelled()
            ->get(['created_at', 'total'])
            ->groupBy(fn ($o) => $o->created_at->format('Y-m-d'));

        $chart = ['labels' => [], 'orders' => [], 'revenue' => []];
        for ($i = 0; $i < $days; $i++) {
            $d = $start->copy()->addDays($i);
            $rows = $daily->get($d->format('Y-m-d'), collect());
            $chart['labels'][]  = $d->format('d M');
            $chart['orders'][]  = $rows->count();
            $chart['revenue'][] = round((float) $rows->sum('total'), 2);
        }

        $statusCounts = Order::statusCounts();

        // Top products by quantity in the selected range (cart is JSON).
        $top = [];
        Order::where('created_at', '>=', $start)->notCancelled()->get(['cart'])
            ->each(function ($order) use (&$top) {
                foreach ($order->items() as $item) {
                    $name = $item['name'] ?? 'Unknown';
                    $top[$name]['name'] = $name;
                    $top[$name]['qty'] = ($top[$name]['qty'] ?? 0) + (int) ($item['qty'] ?? 0);
                    $top[$name]['amount'] = ($top[$name]['amount'] ?? 0) + (int) ($item['qty'] ?? 0) * (float) ($item['price'] ?? 0);
                }
            });
        $topProducts = collect($top)->sortByDesc('qty')->take(5)->values();

        $recentOrders = Order::latest()->take(8)->get();
        $lowStockAlerts = Product::with(['company', 'division'])
            ->where('stock_qty', '<', 10)->orderBy('stock_qty')->take(10)->get();
        $lowStockCount = Product::where('stock_qty', '<', 10)->count();

        return view('admin.dashboard', compact(
            'days', 'stats', 'chart', 'statusCounts', 'topProducts', 'recentOrders', 'lowStockAlerts', 'lowStockCount'
        ));
    }
}
