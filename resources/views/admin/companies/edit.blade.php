@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <a href="{{ route('companies.index') }}" class="text-xs font-bold text-pharma-accent hover:underline mb-2 block">&larr; Back to Companies</a>
    <h1 class="text-3xl font-extrabold text-pharma-navy">Edit Company Profile</h1>
</div>

<div class="max-w-2xl bg-white border border-slate-200 rounded-2xl shadow-sm p-6 sm:p-8">
    <form action="{{ route('companies.update', $company->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Company Name -->
        <div>
            <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Company Name</label>
            <input type="text" name="name" id="name" required value="{{ old('name', $company->name) }}" placeholder="e.g. Cipla Ltd" 
                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-pharma-accent focus:bg-white @error('name') border-red-500 @enderror">
            @error('name')
                <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
            @enderror
        </div>

        <!-- Logo Upload -->
        <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Current Logo</label>
            <div class="w-24 h-24 mb-4 bg-slate-50 border border-slate-200 rounded-2xl flex items-center justify-center text-3xl overflow-hidden shadow-sm">
                @if($company->logo)
                    <img src="{{ asset('storage/' . $company->logo) }}" alt="{{ $company->name }}" class="w-full h-full object-cover">
                @else
                    🏢
                @endif
            </div>

            <label for="logo" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Upload New Logo</label>
            <input type="file" name="logo" id="logo" accept="image/*"
                   class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-pharma-light file:text-pharma-navy hover:file:bg-blue-100 transition">
            <span class="text-[10px] text-slate-400 mt-1 block">Leave empty to keep current logo. Max file size: 2MB.</span>
            @error('logo')
                <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
            @enderror
        </div>

        <!-- Description -->
        <div>
            <label for="description" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Description</label>
            <textarea name="description" id="description" rows="4" placeholder="Brief details about the manufacturer..." 
                      class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-pharma-accent focus:bg-white @error('description') border-red-500 @enderror">{{ old('description', $company->description) }}</textarea>
            @error('description')
                <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
            @enderror
        </div>

        <!-- Active Toggle -->
        <div class="flex items-center">
            <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $company->is_active) ? 'checked' : '' }}
                   class="w-4 h-4 rounded bg-slate-100 border-slate-300 text-pharma-accent focus:ring-pharma-accent">
            <label for="is_active" class="ml-2 block text-xs font-bold uppercase tracking-wider text-slate-700 cursor-pointer">
                Active Status
            </label>
        </div>

        <!-- Actions -->
        <div class="pt-4 border-t border-slate-100 flex items-center space-x-3">
            <button type="submit" class="px-6 py-2.5 bg-pharma-accent text-white font-bold text-sm rounded-xl hover:bg-blue-700 transition shadow-md">
                Update Company
            </button>
            <a href="{{ route('companies.index') }}" class="px-6 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-sm rounded-xl transition border border-slate-200">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
