@extends('layouts.admin')

@section('content')
<div class="space-y-6" x-data="{ createModalOpen: {{ (isset($errors) && $errors->any()) ? 'true' : 'false' }}, selectedRole: '{{ old('role', request('role') === 'salesman' ? 'salesman' : 'salesman') }}' }">
    
    <!-- Page Header & Stats -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-pharma-navy font-display">Registered Users & Counters</h1>
            <p class="text-sm text-slate-500 mt-1">Manage retailer medical counters, salesmen accounts, and assignments.</p>
        </div>

        <div class="flex flex-wrap items-center gap-3">
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

            <!-- Action Buttons to Create Accounts -->
            <button @click="createModalOpen = true; selectedRole = 'salesman'" 
                    class="px-4 py-2.5 bg-amber-600 hover:bg-amber-700 text-white text-xs font-bold rounded-2xl shadow-sm hover:shadow transition flex items-center space-x-2">
                <span>👔</span>
                <span>+ Add Salesman</span>
            </button>
            <button @click="createModalOpen = true; selectedRole = 'retailer'" 
                    class="px-3.5 py-2.5 bg-pharma-navy hover:bg-slate-800 text-white text-xs font-bold rounded-2xl shadow-sm hover:shadow transition flex items-center space-x-1.5">
                <span>🏪</span>
                <span>+ Add Retailer</span>
            </button>
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
                        <th class="p-4 text-center">Orders & Delivery Status</th>
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
                                        <span class="text-xs font-semibold text-sky-700 block">
                                            {{ ($user->role ?? '') === 'salesman' ? '📍' : '🏪' }} {{ $user->company_name }}
                                        </span>
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

                            <!-- Assigned Salesman / Retailers Count -->
                            <td class="p-4">
                                @if(($user->role ?? '') === 'retailer')
                                    @if($user->salesman)
                                        <span class="text-xs font-bold text-slate-700 block">👔 {{ $user->salesman->name }}</span>
                                        <span class="text-[10px] text-slate-400 block">{{ $user->salesman->phone }}</span>
                                    @else
                                        <span class="text-xs text-slate-400 italic">Unassigned</span>
                                    @endif
                                @elseif(($user->role ?? '') === 'salesman')
                                    <span class="text-xs font-bold text-amber-700 bg-amber-50 px-2 py-1 rounded-lg border border-amber-200">
                                        {{ $user->retailers()->count() }} Retailers
                                    </span>
                                @else
                                    <span class="text-xs text-slate-400">—</span>
                                @endif
                            </td>

                            <!-- Orders & Delivery Progress -->
                            <td class="p-4 text-center">
                                @if(($user->role ?? '') === 'salesman')
                                    @php $dStats = $user->delivery_stats; @endphp
                                    <div class="inline-flex flex-col items-center space-y-1">
                                        <span class="text-xs font-extrabold text-slate-900">{{ $dStats['total'] }} Orders</span>
                                        <div class="flex items-center gap-1 text-[10px] font-bold">
                                            <span class="text-emerald-700 bg-emerald-50 px-1.5 py-0.5 rounded border border-emerald-200" title="Delivered Orders">
                                                ✓ {{ $dStats['delivered'] }} Del.
                                            </span>
                                            <span class="text-amber-700 bg-amber-50 px-1.5 py-0.5 rounded border border-amber-200" title="Pending to Deliver">
                                                ⏳ {{ $dStats['pending'] }} Pend.
                                            </span>
                                        </div>
                                        <a href="{{ route('orders.index', ['salesman_id' => $user->id]) }}" 
                                           class="text-[10px] font-bold text-sky-600 hover:text-sky-800 hover:underline">
                                            View Orders &rarr;
                                        </a>
                                    </div>
                                @else
                                    <span class="inline-block px-2.5 py-1 rounded-xl bg-slate-100 text-slate-700 font-extrabold text-xs">
                                        {{ $user->orders_count ?? 0 }}
                                    </span>
                                @endif
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
                                <span class="text-3xl block mb-2">{{ request('role') === 'salesman' ? '👔' : '👥' }}</span>
                                <p class="text-sm font-semibold mb-3">
                                    {{ request('role') === 'salesman' ? 'No salesmen accounts found.' : 'No registered users found.' }}
                                </p>
                                <button @click="createModalOpen = true; selectedRole = '{{ request('role') === 'salesman' ? 'salesman' : 'retailer' }}'" 
                                        class="inline-flex items-center space-x-2 px-4 py-2 bg-pharma-navy text-white text-xs font-bold rounded-xl hover:bg-slate-800 transition">
                                    <span>+ Add {{ request('role') === 'salesman' ? 'Salesman' : 'User' }} Account</span>
                                </button>
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

    <!-- Modal for Creating Salesman / User Account -->
    <div x-show="createModalOpen" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto" 
         aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"
             x-show="createModalOpen"
             x-transition:enter="ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="createModalOpen = false"></div>

        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-slate-200"
                 x-show="createModalOpen"
                 x-transition:enter="ease-out duration-200"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">

                <!-- Modal Header -->
                <div class="px-6 py-4 bg-slate-50 border-b border-slate-200 flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center text-xl font-bold"
                             :class="selectedRole === 'salesman' ? 'bg-amber-100 text-amber-800' : 'bg-sky-100 text-sky-800'">
                            <span x-text="selectedRole === 'salesman' ? '👔' : '🏪'"></span>
                        </div>
                        <div>
                            <h3 class="text-base font-extrabold text-pharma-navy" 
                                x-text="selectedRole === 'salesman' ? 'Create Salesman Account' : 'Create Retailer Counter Account'"></h3>
                            <p class="text-xs text-slate-500">Add credentials and account details.</p>
                        </div>
                    </div>
                    <button type="button" @click="createModalOpen = false" class="text-slate-400 hover:text-slate-600 text-2xl font-bold leading-none">&times;</button>
                </div>

                <!-- Form -->
                <form action="{{ route('admin.users.store') }}" method="POST" class="p-6 space-y-4">
                    @csrf
                    
                    @if(isset($errors) && $errors->any())
                        <div class="p-3 rounded-xl bg-red-50 border border-red-200 text-red-800 text-xs">
                            <ul class="list-disc list-inside space-y-0.5">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Role Switcher -->
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Account Role</label>
                        <div class="grid grid-cols-2 gap-2">
                            <button type="button" 
                                    @click="selectedRole = 'salesman'" 
                                    class="py-2.5 px-3 rounded-xl text-xs font-bold border flex items-center justify-center space-x-2 transition"
                                    :class="selectedRole === 'salesman' ? 'bg-amber-50 border-amber-500 text-amber-900 shadow-sm' : 'border-slate-200 bg-white text-slate-600 hover:bg-slate-50'">
                                <span>👔</span>
                                <span>Salesman</span>
                            </button>
                            <button type="button" 
                                    @click="selectedRole = 'retailer'" 
                                    class="py-2.5 px-3 rounded-xl text-xs font-bold border flex items-center justify-center space-x-2 transition"
                                    :class="selectedRole === 'retailer' ? 'bg-sky-50 border-sky-500 text-sky-900 shadow-sm' : 'border-slate-200 bg-white text-slate-600 hover:bg-slate-50'">
                                <span>🏪</span>
                                <span>Retailer Counter</span>
                            </button>
                        </div>
                        <input type="hidden" name="role" :value="selectedRole">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-1">
                        <!-- Full Name -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Full Name <span class="text-red-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. Ramesh Sharma"
                                   class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:ring-2 focus:ring-pharma-accent">
                        </div>

                        <!-- Phone -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Phone / Mobile</label>
                            <input type="text" name="phone" value="{{ old('phone') }}" placeholder="e.g. 9876543210"
                                   class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:ring-2 focus:ring-pharma-accent">
                        </div>

                        <!-- Email -->
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-slate-700 mb-1">Email Address (Login ID) <span class="text-red-500">*</span></label>
                            <input type="email" name="email" value="{{ old('email') }}" required placeholder="e.g. salesman@chitranshupharma.com"
                                   class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:ring-2 focus:ring-pharma-accent">
                        </div>

                        <!-- Password -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Password <span class="text-red-500">*</span></label>
                            <input type="password" name="password" required minlength="6" placeholder="Min 6 characters"
                                   class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:ring-2 focus:ring-pharma-accent">
                        </div>

                        <!-- Password Confirmation -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Confirm Password <span class="text-red-500">*</span></label>
                            <input type="password" name="password_confirmation" required minlength="6" placeholder="Repeat password"
                                   class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:ring-2 focus:ring-pharma-accent">
                        </div>

                        <!-- Company / Shop / Territory -->
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-slate-700 mb-1" x-text="selectedRole === 'salesman' ? 'Territory / Headquarter' : 'Medical Shop Name'"></label>
                            <input type="text" name="company_name" value="{{ old('company_name') }}"
                                   :placeholder="selectedRole === 'salesman' ? 'e.g. South Kanpur Division' : 'e.g. Life Care Medicos'"
                                   class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:ring-2 focus:ring-pharma-accent">
                        </div>

                        <!-- Assigned Salesman (only for retailer) -->
                        <div class="sm:col-span-2" x-show="selectedRole === 'retailer'" style="display: none;">
                            <label class="block text-xs font-bold text-slate-700 mb-1">Assigned Salesman</label>
                            <select name="salesman_id" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:ring-2 focus:ring-pharma-accent">
                                <option value="">-- No Salesman Assigned --</option>
                                @foreach($salesmen as $sm)
                                    <option value="{{ $sm->id }}">👔 {{ $sm->name }} {{ $sm->phone ? "({$sm->phone})" : '' }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Address -->
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-slate-700 mb-1">Address / Location</label>
                            <input type="text" name="address" value="{{ old('address') }}" placeholder="Area, City"
                                   class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:ring-2 focus:ring-pharma-accent">
                        </div>

                        <!-- Active Checkbox -->
                        <div class="sm:col-span-2">
                            <label class="flex items-center space-x-2 cursor-pointer">
                                <input type="checkbox" name="is_active" value="1" checked class="rounded text-pharma-accent focus:ring-pharma-accent border-slate-300">
                                <span class="text-xs font-semibold text-slate-700">Account is Active immediately</span>
                            </label>
                        </div>
                    </div>

                    <!-- Modal Actions -->
                    <div class="border-t border-slate-100 pt-4 flex items-center justify-end space-x-2">
                        <button type="button" @click="createModalOpen = false" class="px-4 py-2 border border-slate-200 text-slate-600 rounded-xl text-xs font-bold hover:bg-slate-100 transition">
                            Cancel
                        </button>
                        <button type="submit" 
                                class="px-5 py-2 text-white rounded-xl text-xs font-bold shadow-sm hover:shadow transition flex items-center space-x-1.5"
                                :class="selectedRole === 'salesman' ? 'bg-amber-600 hover:bg-amber-700' : 'bg-sky-600 hover:bg-sky-700'">
                            <span x-text="selectedRole === 'salesman' ? '👔 Save Salesman' : '🏪 Save Retailer'"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
