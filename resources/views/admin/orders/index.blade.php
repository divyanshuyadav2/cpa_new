@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-extrabold text-pharma-navy">Orders Management</h1>
    <p class="text-sm text-slate-500 mt-1">Review orders placed via the WhatsApp checkout and update confirmation/dispatch status.</p>
</div>

<!-- Table Card -->
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    @if($orders->isEmpty())
        <div class="p-12 text-center text-slate-400">
            <span class="text-4xl block mb-3">🛒</span>
            No orders placed yet. Orders submitted by customers on the public store will appear here.
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50 text-[10px] font-bold text-slate-500 uppercase">
                        <th class="p-4">Order ID</th>
                        <th class="p-4">Customer Details</th>
                        <th class="p-4">Phone Number</th>
                        <th class="p-4">Invoice Total</th>
                        <th class="p-4">Status</th>
                        <th class="p-4">Order Date</th>
                        <th class="p-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @foreach($orders as $order)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="p-4 font-bold text-slate-900">#{{ $order->id }}</td>
                            <td class="p-4 font-semibold text-slate-800">{{ $order->customer_name }}</td>
                            <td class="p-4 font-medium text-slate-600">{{ $order->phone }}</td>
                            <td class="p-4 font-bold text-slate-950">₹{{ number_format($order->total, 2) }}</td>
                            <td class="p-4">
                                @if($order->status == 'Pending')
                                    <span class="inline-flex px-2 py-0.5 rounded-full text-[10px] font-bold bg-yellow-100 text-yellow-800 border border-yellow-200">Pending</span>
                                @elseif($order->status == 'Confirmed')
                                    <span class="inline-flex px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-800 border border-blue-200">Confirmed</span>
                                @else
                                    <span class="inline-flex px-2 py-0.5 rounded-full text-[10px] font-bold bg-green-100 text-green-800 border border-green-200">Dispatched</span>
                                @endif
                            </td>
                            <td class="p-4 text-xs text-slate-500">{{ $order->created_at->format('d-M-Y h:i A') }}</td>
                            <td class="p-4 text-right">
                                <a href="{{ route('orders.show', $order->id) }}" class="px-3 py-1.5 bg-pharma-light text-pharma-navy hover:bg-pharma-navy hover:text-white font-bold text-xs rounded-xl border border-slate-200 transition">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-slate-200 bg-slate-50">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection
