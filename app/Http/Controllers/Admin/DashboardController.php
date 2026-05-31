<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Division;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        $totalProducts = Product::count();
        $totalCompanies = Company::count();
        $totalDivisions = Division::count();
        
        $ordersToday = Order::whereDate('created_at', Carbon::today())->count();
        
        $recentOrders = Order::latest()->take(5)->get();
        
        $lowStockAlerts = Product::with(['company', 'division'])
            ->where('stock_qty', '<', 10)
            ->orderBy('stock_qty', 'asc')
            ->get();

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalCompanies',
            'totalDivisions',
            'ordersToday',
            'recentOrders',
            'lowStockAlerts'
        ));
    }
}
