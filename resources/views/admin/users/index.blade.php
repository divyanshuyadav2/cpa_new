@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    
    <!-- Page Header & Stats -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-pharma-navy font-display">Registered Users & Counters</h1>
            <p class="text-sm text-slate-500 mt-1">Manage retailer medical counters, salesmen accounts, and assignments.</p>
        </div>

        <div class="flex items-center space-x-3">
            <div class="bg-white border border-slate-200 px-4 py-2 rounded-2xl shadow-sm flex items-center space-x-3">
                <div class="w-9 h-9 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center font-bold text-lg">🏪</div>
                <div>
                    <span class="block text-[10px] font-bold text-slate-400 uppercase">Retailers</span>
                    <strong class="text-base text-slate-800">{{ $stats['retailers'] }}</strong>
                </div>
            </div>
            <div class="bg-white border border-slate-200 px-4 py-2 rounded-2xl shadow-sm flex items-center space-x-3">
                <div class="w-9 h-9 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold text-lg">👔</div>
                <div>
                    <span class="block text-[10px] font-bold text-slate-400 uppercase">Salesmen</span>
                    <strong class="text-base text-slate-800">{{ $stats['salesmen'] }}</strong>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters & Search Bar -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
        <!-- Role Filter Tabs -->
        <div class="flex items-center space-x-2 w-full md:w-auto">
            <a href="{{ route('admin.users.index') }}" 
               class="px-4 py-2 rounded-xl text-xs font-bold transition {{ !request('role') ? 'bg-pharma-navy text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                All Users ({{ $stats['total'] }})
            </a>
            <a href="{{ route('admin.users.index', ['role' => 'retailer']) }}" 
               class="px-4 py-2 rounded-xl text-xs font-bold transition {{ request('role') == 'retailer' ? 'bg-sky-600 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                🏪 Retailers ({{ $stats['retailers'] }})
            </a>
            <a href="{{ route('admin.users.index', ['role' => 'salesman']) }}" 
               class="px-4 py-2 rounded-xl text-xs font-bold transition {{ request('role') == 'salesman' ? 'bg-amber-600 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                👔 Salesmen ({{ $stats['salesmen'] }})
            </a>
        </div>

        <!-- Search Form -->
        <form action="{{ route('admin.users.index') }}" method="GET" class="flex items-center space-x-2 w-full md:w-auto">
            @if(request('role'))
                <input type="hidden" name="role" value="{{ request('role') }}">
            @endif
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name, phone, shop..." 
                   class="px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-pharma-accent w-full md:w-64">
            <button type="submit" class="px-4 py-2 bg-pharma-navy text-white text-xs font-bold rounded-xl hover:bg-slate-800 transition">
                Search
            </button>
        </form>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50 text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                        <th class="p-4">User / Counter Name</th>
                        <th class="p-4">Account Role</th>
                        <th class="p-4">Phone / Contact</th>
                        <th class="p-4">Assigned Salesman</th>
                        <th class="p-4 text-center">Total Orders</th>
                        <th class="p-4 text-center">Status</th>
                        <th class="p-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($users as $user)
                        <tr class="hover:bg-slate-50/50 transition">
                            <!-- Name & Shop -->
                            <td class="p-4">
                                <a href="{{ route('admin.users.show', $user->id) }}" class="group">
                                    <strong class="block text-slate-900 group-hover:text-pharma-accent transition leading-snug">{{ $user->name }}</strong>
                                    @if($user->company_name)
                                        <span class="text-xs font-semibold text-sky-700 block">🏪 {{ $user->company_name }}</span>
                                    @endif
                                    <span class="text-[11px] text-slate-400 block">{{ $user->email }}</span>
                                </a>
                            </td>

                            <!-- Role Badge -->
                            <td class="p-4">
                                @if(($user->role ?? 'retailer') === 'salesman')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800 border border-amber-200">
                                        👔 Salesman
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-sky-100 text-sky-800 border border-sky-200">
                                        🏪 Retailer Counter
                                    </span>
                                @endif
                            </td>

                            <!-- Phone -->
                            <td class="p-4 font-semibold text-slate-700">
                                {{ $user->phone ?? 'N/A' }}
                            </td>

                            <!-- Assigned Salesman -->
                            <td class="p-4">
                                @if(($user->role ?? '') === 'retailer')
                                    @if($user->salesman)
                                        <span class="text-xs font-bold text-slate-700 block">👔 {{ $user->salesman->name }}</span>
                                        <span class="text-[10px] text-slate-400 block">{{ $user->salesman->phone }}</span>
                                    @else
                                        <span class="text-xs text-slate-400 italic">Unassigned</span>
                                    @endif
                                @else
                                    <span class="text-xs text-slate-400">—</span>
                                @endif
                            </td>

                            <!-- Orders Count -->
                            <td class="p-4 text-center">
                                <span class="inline-block px-2.5 py-1 rounded-xl bg-slate-100 text-slate-700 font-extrabold text-xs">
                                    {{ $user->orders_count ?? 0 }}
                                </span>
                            </td>

                            <!-- Active / Inactive Status -->
                            <td class="p-4 text-center">
                                <form action="{{ route('admin.users.toggle-status', $user->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                            class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold transition {{ ($user->is_active ?? true) ? 'bg-emerald-100 text-emerald-800 hover:bg-emerald-200' : 'bg-red-100 text-red-800 hover:bg-red-200' }}"
                                            title="Click to toggle status">
                                        {{ ($user->is_active ?? true) ? '● Active' : '○ Inactive' }}
                                    </button>
                                </form>
                            </td>

                            <!-- Action Buttons -->
                            <td class="p-4 text-right space-x-2">
                                <a href="{{ route('admin.users.show', $user->id) }}" 
                                   class="inline-block px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition">
                                    View Profile &rarr;
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-12 text-slate-400">
                                <span class="text-3xl block mb-2">👥</span>
                                <p class="text-sm font-semibold">No registered users found.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-slate-200 bg-slate-50">
            {{ $users->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection
