@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <a href="{{ route('orders.index') }}" class="text-xs font-bold text-pharma-accent hover:underline mb-2 block">&larr; Back to Orders</a>
    <h1 class="text-3xl font-extrabold text-pharma-navy font-display">Order #{{ $order->id }} details</h1>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <!-- Left: Cart Items Table (2 columns on lg) -->
    <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col h-fit">
        <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
            <h2 class="text-sm font-bold text-slate-700 uppercase tracking-wider">Ordered Products</h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-100/50 text-[10px] font-bold text-slate-500 uppercase">
                        <th class="p-4">Item details</th>
                        <th class="p-4">Packing</th>
                        <th class="p-4 text-center">Qty</th>
                        <th class="p-4">Price</th>
                        <th class="p-4 text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @foreach($order->cart as $item)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="p-4">
                                <strong class="block text-slate-900 leading-tight">{{ $item['name'] }}</strong>
                                <span class="block text-xs text-slate-500">Comp: {{ $item['composition'] }}</span>
                                <span class="text-[9px] text-pharma-gold font-bold uppercase tracking-wider">{{ $item['company'] }}</span>
                            </td>
                            <td class="p-4 text-slate-600 font-semibold">{{ $item['packing'] }}</td>
                            <td class="p-4 text-center font-bold text-slate-800">{{ $item['qty'] }}</td>
                            <td class="p-4 font-semibold text-slate-700">₹{{ number_format($item['price'], 2) }}</td>
                            <td class="p-4 text-right font-bold text-slate-900">₹{{ number_format($item['qty'] * $item['price'], 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="px-6 py-5 border-t border-slate-200 bg-slate-50 flex justify-between items-center mt-auto">
            <span class="text-sm font-bold text-slate-600">Total Invoice Amount:</span>
            <span class="text-xl font-extrabold text-pharma-navy">₹{{ number_format($order->total, 2) }}</span>
        </div>
    </div>

    <!-- Right: Customer Info & Status Action (1 column on lg) -->
    <div class="lg:col-span-1 space-y-6">
        
        <!-- Customer details -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4 border-b border-slate-100 pb-2">Customer Information</h3>
            <div class="space-y-3 text-sm">
                <div>
                    <span class="block text-[10px] font-bold text-slate-400 uppercase">Customer Name</span>
                    <strong class="text-slate-800">{{ $order->customer_name }}</strong>
                </div>
                <div>
                    <span class="block text-[10px] font-bold text-slate-400 uppercase">WhatsApp Number</span>
                    <strong class="text-slate-800">{{ $order->phone }}</strong>
                </div>
                <div>
                    <span class="block text-[10px] font-bold text-slate-400 uppercase">Date of Order</span>
                    <strong class="text-slate-800">{{ $order->created_at->format('d-M-Y h:i A') }}</strong>
                </div>
                <div>
                    <span class="block text-[10px] font-bold text-slate-400 uppercase">Current Status</span>
                    @if($order->status == 'Pending')
                        <span class="inline-flex px-2 py-0.5 mt-1 rounded-full text-[10px] font-bold bg-yellow-100 text-yellow-800 border border-yellow-200">Pending Approval</span>
                    @elseif($order->status == 'Confirmed')
                        <span class="inline-flex px-2 py-0.5 mt-1 rounded-full text-[10px] font-bold bg-blue-100 text-blue-800 border border-blue-200">Confirmed</span>
                    @else
                        <span class="inline-flex px-2 py-0.5 mt-1 rounded-full text-[10px] font-bold bg-green-100 text-green-800 border border-green-200">Dispatched</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Update Status Form -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4 border-b border-slate-100 pb-2">Update Order Status</h3>
            
            <form action="{{ route('orders.update-status', $order->id) }}" method="POST" class="space-y-4">
                @csrf
                @method('PATCH')
                
                <div>
                    <label for="status" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Select Status</label>
                    <select name="status" id="status" required
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pharma-accent focus:bg-white transition">
                        <option value="Pending" {{ $order->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Confirmed" {{ $order->status == 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="Dispatched" {{ $order->status == 'Dispatched' ? 'selected' : '' }}>Dispatched</option>
                    </select>
                </div>

                <button type="submit" class="w-full py-2.5 bg-slate-800 hover:bg-slate-900 text-white font-bold text-sm rounded-xl transition shadow-sm">
                    Update Status
                </button>
            </form>
        </div>

        <!-- Send WhatsApp Confirmation -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm text-center">
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Customer Notification</h3>
            <p class="text-xs text-slate-500 mb-4">Send a status update message directly to the customer's WhatsApp.</p>
            <a href="{{ route('orders.confirm', $order->id) }}" target="_blank"
               class="w-full py-3 bg-gradient-to-r from-green-500 to-green-600 text-white font-bold text-sm rounded-xl hover:opacity-95 transition shadow-sm flex justify-center items-center space-x-2">
                <span>💬 Send WhatsApp Confirmation</span>
            </a>
        </div>

    </div>

</div>
@endsection
