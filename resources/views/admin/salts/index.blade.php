@extends('layouts.admin')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
    <div>
        <h1 class="text-3xl font-extrabold text-pharma-navy">Salt & Composition Management</h1>
        <p class="text-sm text-slate-500 mt-1">Manage active chemical salts and compounds used in formulations.</p>
    </div>
    <a href="{{ route('salts.create') }}" class="px-5 py-2.5 bg-pharma-accent text-white font-bold text-sm rounded-xl hover:bg-blue-700 transition shadow-md">
        + Add New Salt
    </a>
</div>

<!-- Table Card -->
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    @if($salts->isEmpty())
        <div class="p-12 text-center text-slate-400">
            <span class="text-4xl block mb-3">🧪</span>
            No chemical salts registered. Add a salt to link it with products.
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50 text-[10px] font-bold text-slate-500 uppercase">
                        <th class="p-4">Salt Name</th>
                        <th class="p-4">Description</th>
                        <th class="p-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @foreach($salts as $salt)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="p-4 font-bold text-slate-900">{{ $salt->name }}</td>
                            <td class="p-4 text-xs text-slate-500 max-w-md truncate">{{ $salt->description ?? 'No description provided.' }}</td>
                            <td class="p-4 text-right flex justify-end items-center space-x-2 h-14">
                                <a href="{{ route('salts.edit', $salt->id) }}" class="px-2.5 py-1 bg-slate-100 text-slate-700 font-semibold text-xs rounded border border-slate-200 hover:bg-slate-200 transition">
                                    Edit
                                </a>
                                <form action="{{ route('salts.destroy', $salt->id) }}" method="POST" 
                                      onsubmit="return confirm('Are you sure you want to delete this salt? It will dissociate all products that use it.')">
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
            {{ $salts->links() }}
        </div>
    @endif
</div>
@endsection
