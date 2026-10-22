@extends('layouts.admin')

@section('content')
<div class="max-w-3xl mx-auto space-y-6" x-data="{ role: '{{ old('role', $role ?? 'salesman') }}' }">
    
    <!-- Top Header -->
    <div class="flex items-center justify-between">
        <div>
            <a href="{{ route('admin.users.index') }}" class="text-xs font-bold text-pharma-accent hover:underline mb-1 inline-block">&larr; Back to Users & Counters List</a>
            <h1 class="text-2xl font-extrabold text-pharma-navy font-display">Create Account</h1>
            <p class="text-sm text-slate-500">Register a new Salesman or Retailer Counter account in the system.</p>
        </div>
        <div class="hidden sm:block">
            <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-bold"
                  :class="role === 'salesman' ? 'bg-amber-100 text-amber-800 border border-amber-200' : 'bg-sky-100 text-sky-800 border border-sky-200'">
                <span x-text="role === 'salesman' ? '👔 Salesman Account' : '🏪 Retailer Account'"></span>
            </span>
        </div>
    </div>

    <!-- Error Summary (if any) -->
    @if(isset($errors) && $errors->any())
        <div class="p-4 rounded-xl bg-red-50 border border-red-200 text-red-800 text-sm">
            <strong class="font-bold block mb-1">Please fix the following errors:</strong>
            <ul class="list-disc list-inside space-y-1 text-xs">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form Card -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden p-6 sm:p-8">
        <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Role Selector -->
            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Account Type / Role <span class="text-red-500">*</span></label>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <label class="relative flex items-center p-4 rounded-xl border-2 cursor-pointer transition"
                           :class="role === 'salesman' ? 'border-amber-500 bg-amber-50/40 text-amber-900 shadow-sm' : 'border-slate-200 hover:border-slate-300 bg-white text-slate-700'">
                        <input type="radio" name="role" value="salesman" x-model="role" class="sr-only">
                        <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center font-bold text-xl mr-3 flex-shrink-0">
                            👔
                        </div>
                        <div>
                            <span class="block text-sm font-bold">Salesman</span>
                            <span class="block text-xs text-slate-500 mt-0.5">App access to book orders for assigned retailers & manage territory.</span>
                        </div>
                    </label>

                    <label class="relative flex items-center p-4 rounded-xl border-2 cursor-pointer transition"
                           :class="role === 'retailer' ? 'border-sky-500 bg-sky-50/40 text-sky-900 shadow-sm' : 'border-slate-200 hover:border-slate-300 bg-white text-slate-700'">
                        <input type="radio" name="role" value="retailer" x-model="role" class="sr-only">
                        <div class="w-10 h-10 rounded-xl bg-sky-100 text-sky-700 flex items-center justify-center font-bold text-xl mr-3 flex-shrink-0">
                            🏪
                        </div>
                        <div>
                            <span class="block text-sm font-bold">Retailer Counter</span>
                            <span class="block text-xs text-slate-500 mt-0.5">Medical chemist counter / pharmacy shop customer.</span>
                        </div>
                    </label>
                </div>
            </div>

            <div class="border-t border-slate-100 pt-5 grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Full Name -->
                <div class="sm:col-span-1">
                    <label class="block text-xs font-bold text-slate-700 mb-1">
                        Full Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}" required 
                           placeholder="e.g. Ramesh Sharma"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-pharma-accent">
                </div>

                <!-- Phone -->
                <div class="sm:col-span-1">
                    <label class="block text-xs font-bold text-slate-700 mb-1">
                        Mobile / Phone Number
                    </label>
                    <input type="text" name="phone" value="{{ old('phone') }}" 
                           placeholder="e.g. 9876543210"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-pharma-accent">
                </div>

                <!-- Email -->
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 mb-1">
                        Email Address (Login Username) <span class="text-red-500">*</span>
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}" required 
                           placeholder="e.g. ramesh.sales@chitranshupharma.com"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-pharma-accent">
                </div>

                <!-- Password -->
                <div class="sm:col-span-1">
                    <label class="block text-xs font-bold text-slate-700 mb-1">
                        Login Password <span class="text-red-500">*</span>
                    </label>
                    <input type="password" name="password" required minlength="6"
                           placeholder="At least 6 characters"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-pharma-accent">
                </div>

                <!-- Password Confirmation -->
                <div class="sm:col-span-1">
                    <label class="block text-xs font-bold text-slate-700 mb-1">
                        Confirm Password <span class="text-red-500">*</span>
                    </label>
                    <input type="password" name="password_confirmation" required minlength="6"
                           placeholder="Repeat password"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-pharma-accent">
                </div>

                <!-- Company / Agency / Territory Name -->
                <div class="sm:col-span-1">
                    <label class="block text-xs font-bold text-slate-700 mb-1" x-text="role === 'salesman' ? 'Territory / Headquarter' : 'Medical Counter / Shop Name'">
                        Territory / Shop Name
                    </label>
                    <input type="text" name="company_name" value="{{ old('company_name') }}" 
                           :placeholder="role === 'salesman' ? 'e.g. South Kanpur Division' : 'e.g. Sharma Medical Store'"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-pharma-accent">
                </div>

                <!-- Assigned Salesman (Only for Retailers) -->
                <div class="sm:col-span-1" x-show="role === 'retailer'" style="display: none;">
                    <label class="block text-xs font-bold text-slate-700 mb-1">
                        Assign Salesman
                    </label>
                    <select name="salesman_id" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-pharma-accent">
                        <option value="">-- No Salesman Assigned --</option>
                        @foreach($salesmen as $sm)
                            <option value="{{ $sm->id }}" {{ old('salesman_id') == $sm->id ? 'selected' : '' }}>
                                👔 {{ $sm->name }} {{ $sm->phone ? "({$sm->phone})" : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Address -->
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 mb-1">
                        Address / Location
                    </label>
                    <textarea name="address" rows="2" 
                              placeholder="City, State, Area..."
                              class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-pharma-accent">{{ old('address') }}</textarea>
                </div>

                <!-- Active Status Checkbox -->
                <div class="sm:col-span-2 pt-2">
                    <label class="flex items-center space-x-3 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', '1') == '1' ? 'checked' : '' }} 
                               class="w-4 h-4 rounded text-pharma-accent focus:ring-pharma-accent border-slate-300">
                        <span class="text-sm font-semibold text-slate-700">Account is Active (Can log in immediately)</span>
                    </label>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="border-t border-slate-100 pt-5 flex items-center justify-end space-x-3">
                <a href="{{ route('admin.users.index') }}" 
                   class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-100 font-bold text-xs transition">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-2.5 rounded-xl text-white font-bold text-xs shadow-sm hover:shadow transition flex items-center space-x-2"
                        :class="role === 'salesman' ? 'bg-amber-600 hover:bg-amber-700' : 'bg-sky-600 hover:bg-sky-700'">
                    <span x-text="role === 'salesman' ? '👔 Create Salesman Account' : '🏪 Create Retailer Account'"></span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
