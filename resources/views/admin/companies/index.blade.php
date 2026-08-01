@extends('layouts.admin')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
    <div>
        <h1 class="text-3xl font-extrabold text-pharma-navy">Companies Management</h1>
        <p class="text-sm text-slate-500 mt-1">Manage pharmaceutical manufacturers, active states, and logos.</p>
    </div>
    <a href="{{ route('companies.create') }}" class="px-5 py-2.5 bg-pharma-accent text-white font-bold text-sm rounded-xl hover:bg-blue-700 transition shadow-md">
        + Add New Company
    </a>
</div>

<!-- Search & Filters Bar Card -->
<div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm mb-6">
    <form action="{{ route('companies.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4" id="admin-company-filter">
        <!-- Search Keyword -->
        <div class="md:col-span-2">
            <label for="search" class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Search Companies</label>
            <div class="relative">
                <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Search by company name or description..."
                       class="w-full bg-slate-50 border border-slate-200 rounded-lg pl-9 pr-8 py-2 text-xs focus:outline-none focus:ring-2 focus:ring-pharma-accent focus:bg-white transition">
                <span class="absolute left-3 top-2.5 text-slate-400 text-xs">🔍</span>
                @if(request('search'))
                    <a href="{{ route('companies.index', request()->except('search')) }}" class="absolute right-3 top-2 text-slate-400 hover:text-slate-600 font-bold text-sm" title="Clear search">×</a>
                @endif
            </div>
        </div>

        <!-- Status Filter & Action Buttons -->
        <div class="flex items-end space-x-2">
            <div class="flex-grow">
                <label for="status" class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Status</label>
                <select name="status" id="status" onchange="document.getElementById('admin-company-filter').submit()"
                        class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-xs focus:outline-none focus:ring-2 focus:ring-pharma-accent focus:bg-white transition">
                    <option value="">All Statuses</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active Only</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive Only</option>
                </select>
            </div>
            
            <button type="submit" class="px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white text-xs font-bold rounded-lg transition shadow-sm">
                Search
            </button>
            @if(request()->anyFilled(['search', 'status']))
                <a href="{{ route('companies.index') }}" class="px-3 py-2 bg-red-50 hover:bg-red-100 text-red-600 text-xs font-bold rounded-lg border border-red-200 transition">
                    Reset
                </a>
            @endif
        </div>
    </form>
</div>

<!-- Results Indicator -->
@if(request()->anyFilled(['search', 'status']))
    <div class="mb-4 text-xs font-medium text-slate-600 flex items-center justify-between">
        <span>Found <strong>{{ $companies->total() }}</strong> {{ Str::plural('company', $companies->total()) }} matching your filter criteria.</span>
        <a href="{{ route('companies.index') }}" class="text-pharma-accent hover:underline font-bold text-xs">Clear all filters</a>
    </div>
@endif

<!-- Table Card -->
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    @if($companies->isEmpty())
        <div class="p-12 text-center text-slate-400">
            <span class="text-4xl block mb-3">🏢</span>
            @if(request()->anyFilled(['search', 'status']))
                No companies found matching your search criteria. <br>
                <a href="{{ route('companies.index') }}" class="mt-3 inline-block px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-lg border border-slate-200 transition">Reset Filters</a>
            @else
                No companies registered. Add a company to begin building your catalog.
            @endif
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50 text-[10px] font-bold text-slate-500 uppercase">
                        <th class="p-4 w-20">Logo</th>
                        <th class="p-4">Company Name</th>
                        <th class="p-4">Description</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @foreach($companies as $company)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="p-4">
                                <div class="w-10 h-10 border border-slate-200 rounded-lg flex items-center justify-center text-lg overflow-hidden flex-shrink-0" style="background-color: {{ $company->bg_color ?? '#f8fafc' }};">
                                @if($company->logo)
                                    <img src="{{ media_url($company->logo) }}" alt="{{ $company->name }}" class="w-full h-full object-cover rounded-lg">
                                @else
                                    🏢
                                @endif
                                </div>
                            </td>
                            <td class="p-4 font-bold text-slate-900">{{ $company->name }}</td>
                            <td class="p-4 text-xs text-slate-500 max-w-xs truncate">{{ $company->description ?? 'No description provided.' }}</td>
                            <td class="p-4">
                                @if($company->is_active)
                                    <span class="inline-flex px-2 py-0.5 rounded-full text-[10px] font-bold bg-green-100 text-green-800 border border-green-200">Active</span>
                                @else
                                    <span class="inline-flex px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600 border border-slate-200">Inactive</span>
                                @endif
                            </td>
                            <td class="p-4 text-right flex justify-end items-center space-x-2 h-18">
                                <a href="{{ route('companies.edit', $company->id) }}" class="px-2.5 py-1 bg-slate-100 text-slate-700 font-semibold text-xs rounded border border-slate-200 hover:bg-slate-200 transition">
                                    Edit
                                </a>
                                <form action="{{ route('companies.destroy', $company->id) }}" method="POST" 
                                      onsubmit="return confirm('Are you sure you want to delete this company? Related divisions and products will be permanently deleted.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-2.5 py-1 bg-red-50 text-red-600 font-semibold text-xs rounded border border-red-200 hover:bg-red-600 hover:text-white transition">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-slate-200 bg-slate-50">
            {{ $companies->links() }}
        </div>
    @endif
</div>
@endsection
