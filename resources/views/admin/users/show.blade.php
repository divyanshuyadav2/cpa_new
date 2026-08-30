@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Top Nav Back Link -->
    <div>
        <a href="{{ route('admin.users.index') }}" class="text-xs font-bold text-pharma-accent hover:underline mb-2 block">&larr; Back to Users & Counters List</a>
        <h1 class="text-3xl font-extrabold text-pharma-navy font-display">{{ $user->name }}</h1>
        <p class="text-sm text-slate-500 mt-1">User Profile & Order Activity</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Left Column: User Details Card & Edit Form -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Account Info -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Account Overview</h3>
                    @if(($user->role ?? 'retailer') === 'salesman')
                        <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800 border border-amber-200">👔 Salesman</span>
                    @else
                        <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-sky-100 text-sky-800 border border-sky-200">🏪 Retailer</span>
                    @endif
                </div>

                <div class="space-y-3 text-sm">
                    <div>
                        <span class="block text-[10px] font-bold text-slate-400 uppercase">Email Address</span>
                        <strong class="text-slate-800">{{ $user->email }}</strong>
                    </div>
                    <div>
                        <span class="block text-[10px] font-bold text-slate-400 uppercase">Contact Phone</span>
                        <strong class="text-slate-800">{{ $user->phone ?? 'Not provided' }}</strong>
                    </div>
                    <div>
                        <span class="block text-[10px] font-bold text-slate-400 uppercase">Shop / Medical Counter Name</span>
                        <strong class="text-slate-800">{{ $user->company_name ?? 'N/A' }}</strong>
                    </div>
                    <div>
                        <span class="block text-[10px] font-bold text-slate-400 uppercase">Address</span>
                        <p class="text-slate-700 text-xs">{{ $user->address ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <span class="block text-[10px] font-bold text-slate-400 uppercase">Registration Date</span>
                        <strong class="text-slate-800">{{ $user->created_at->format('d M Y, h:i A') }}</strong>
                    </div>
                </div>

                <div class="pt-3 border-t border-slate-100">
                    <form action="{{ route('admin.users.toggle-status', $user->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="w-full py-2 px-3 rounded-xl text-xs font-bold transition {{ ($user->is_active ?? true) ? 'bg-red-50 text-red-700 border border-red-200 hover:bg-red-100' : 'bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-100' }}">
                            {{ ($user->is_active ?? true) ? '🚫 Deactivate Account' : '✅ Activate Account' }}
                        </button>
                    </form>
                </div>
            </div>

            <!-- Edit & Salesman Assignment Form -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4 border-b border-slate-100 pb-2">Update Account & Role</h3>

                <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="role" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1">Account Role</label>
                        <select name="role" id="role" class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-800">
                            <option value="retailer" {{ ($user->role ?? 'retailer') === 'retailer' ? 'selected' : '' }}>🏪 Retailer Counter</option>
                            <option value="salesman" {{ ($user->role ?? '') === 'salesman' ? 'selected' : '' }}>👔 Salesman</option>
                        </select>
                    </div>

                    @if(($user->role ?? 'retailer') === 'retailer')
                        <div>
                            <label for="salesman_id" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1">Assigned Salesman</label>
                            <select name="salesman_id" id="salesman_id" class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800">
                                <option value="">-- No Assigned Salesman --</option>
                                @foreach($salesmen as $s)
                                    <option value="{{ $s->id }}" {{ $user->salesman_id == $s->id ? 'selected' : '' }}>
                                        👔 {{ $s->name }} ({{ $s->phone }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <div>
                        <label for="company_name" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1">Shop / Medical Counter Name</label>
                        <input type="text" name="company_name" id="company_name" value="{{ old('company_name', $user->company_name) }}"
                               class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800">
                    </div>

                    <div>
                        <label for="phone" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1">Phone Number</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}"
                               class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800">
                    </div>

                    <button type="submit" class="w-full py-2.5 bg-pharma-navy hover:bg-slate-800 text-white font-bold text-xs rounded-xl shadow transition">
                        Save Changes
                    </button>
                </form>
            </div>
        </div>

        <!-- Right Column: Order History -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-200 bg-slate-50 flex items-center justify-between">
                    <h2 class="text-sm font-bold text-slate-700 uppercase tracking-wider">Order History</h2>
                    <span class="text-xs font-bold bg-slate-200 text-slate-700 px-2.5 py-1 rounded-full">
                        {{ $user->orders ? $user->orders->count() : 0 }} Total Orders
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-200 bg-slate-100/50 text-[10px] font-bold text-slate-500 uppercase">
                                <th class="p-4">Order ID</th>
                                <th class="p-4">Date</th>
                                <th class="p-4">Items Count</th>
                                <th class="p-4">Total Amount</th>
                                <th class="p-4 text-center">Status</th>
                                <th class="p-4 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm">
                            @forelse($user->orders as $order)
                                <tr class="hover:bg-slate-50/50 transition">
                                    <td class="p-4 font-bold text-pharma-navy">#{{ $order->id }}</td>
                                    <td class="p-4 text-xs text-slate-500">{{ $order->created_at->format('d M Y, h:i A') }}</td>
                                    <td class="p-4 font-semibold text-slate-700">{{ is_array($order->cart) ? count($order->cart) : 0 }} items</td>
                                    <td class="p-4 font-extrabold text-emerald-600">₹{{ number_format($order->total, 2) }}</td>
                                    <td class="p-4 text-center">
                                        @if($order->status == 'Pending')
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800">Pending</span>
                                        @elseif($order->status == 'Confirmed')
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-800">Confirmed</span>
                                        @elseif($order->status == 'Dispatched')
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-purple-100 text-purple-800">Dispatched</span>
                                        @else
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">Delivered</span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-right">
                                        <a href="{{ route('orders.show', $order->id) }}" class="text-xs font-bold text-pharma-accent hover:underline">
                                            View Order &rarr;
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-12 text-slate-400">
                                        <span class="text-3xl block mb-2">🛒</span>
                                        <p class="text-sm font-semibold">No orders placed by this user yet.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
