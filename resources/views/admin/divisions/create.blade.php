@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <a href="{{ route('divisions.index') }}" class="text-xs font-bold text-pharma-accent hover:underline mb-2 block">&larr; Back to Divisions</a>
    <h1 class="text-3xl font-extrabold text-pharma-navy">Add New Division</h1>
</div>

<div class="max-w-2xl bg-white border border-slate-200 rounded-2xl shadow-sm p-6 sm:p-8">
    <form action="{{ route('divisions.store') }}" method="POST" class="space-y-6">
        @csrf

        <!-- Division Name -->
        <div>
            <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Division Name</label>
            <input type="text" name="name" id="name" required value="{{ old('name') }}" placeholder="e.g. Cipla Diagnostics" 
                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-pharma-accent focus:bg-white @error('name') border-red-500 @enderror">
            @error('name')
                <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
            @enderror
        </div>

        <!-- Parent Company Select -->
        <div>
            <label for="company_id" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Parent Company</label>
            <select name="company_id" id="company_id" required
                    class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-pharma-accent focus:bg-white transition @error('company_id') border-red-500 @enderror">
                <option value="">Select a Company</option>
                @foreach($companies as $company)
                    <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>
                        {{ $company->name }}
                    </option>
                @endforeach
            </select>
            @error('company_id')
                <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
            @enderror
        </div>

        <!-- Description -->
        <div>
            <label for="description" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Description</label>
            <textarea name="description" id="description" rows="4" placeholder="Brief details about the division..." 
                      class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-pharma-accent focus:bg-white @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
            @error('description')
                <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
            @enderror
        </div>

        <!-- Active Toggle -->
        <div class="flex items-center">
            <input type="checkbox" name="is_active" id="is_active" value="1" checked
                   class="w-4 h-4 rounded bg-slate-100 border-slate-300 text-pharma-accent focus:ring-pharma-accent">
            <label for="is_active" class="ml-2 block text-xs font-bold uppercase tracking-wider text-slate-700 cursor-pointer">
                Active Status
            </label>
        </div>

        <!-- Actions -->
        <div class="pt-4 border-t border-slate-100 flex items-center space-x-3">
            <button type="submit" class="px-6 py-2.5 bg-pharma-accent text-white font-bold text-sm rounded-xl hover:bg-blue-700 transition shadow-md">
                Save Division
            </button>
            <a href="{{ route('divisions.index') }}" class="px-6 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-sm rounded-xl transition border border-slate-200">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
