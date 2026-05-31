@extends('layouts.admin')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
    <div>
        <h1 class="text-3xl font-extrabold text-pharma-navy">Divisions Management</h1>
        <p class="text-sm text-slate-500 mt-1">Manage product divisions and categories under pharmaceutical companies.</p>
    </div>
    <a href="{{ route('divisions.create') }}" class="px-5 py-2.5 bg-pharma-accent text-white font-bold text-sm rounded-xl hover:bg-blue-700 transition shadow-md">
        + Add New Division
    </a>
</div>

<!-- Table Card -->
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    @if($divisions->isEmpty())
        <div class="p-12 text-center text-slate-400">
            <span class="text-4xl block mb-3">🗂️</span>
            No divisions registered yet. Add a division to begin categorizing products.
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50 text-[10px] font-bold text-slate-500 uppercase">
                        <th class="p-4">Division Name</th>
                        <th class="p-4">Parent Company</th>
                        <th class="p-4">Description</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @foreach($divisions as $division)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="p-4 font-bold text-slate-900">{{ $division->name }}</td>
                            <td class="p-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-slate-100 text-slate-700 border border-slate-200">
                                    🏢 {{ $division->company->name }}
                                </span>
                            </td>
                            <td class="p-4 text-xs text-slate-500 max-w-xs truncate">{{ $division->description ?? 'No description provided.' }}</td>
                            <td class="p-4">
                                @if($division->is_active)
                                    <span class="inline-flex px-2 py-0.5 rounded-full text-[10px] font-bold bg-green-100 text-green-800 border border-green-200">Active</span>
                                @else
                                    <span class="inline-flex px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600 border border-slate-200">Inactive</span>
                                @endif
                            </td>
                            <td class="p-4 text-right flex justify-end items-center space-x-2 h-18">
                                <a href="{{ route('divisions.edit', $division->id) }}" class="px-2.5 py-1 bg-slate-100 text-slate-700 font-semibold text-xs rounded border border-slate-200 hover:bg-slate-200 transition">
                                    Edit
                                </a>
                                <form action="{{ route('divisions.destroy', $division->id) }}" method="POST" 
                                      onsubmit="return confirm('Are you sure you want to delete this division? Related products will be permanently deleted.')">
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
            {{ $divisions->links() }}
        </div>
    @endif
</div>
@endsection
