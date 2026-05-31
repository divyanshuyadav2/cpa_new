@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <a href="{{ route('salts.index') }}" class="text-xs font-bold text-pharma-accent hover:underline mb-2 block">&larr; Back to Salts</a>
    <h1 class="text-3xl font-extrabold text-pharma-navy">Edit Salt Details</h1>
</div>

<div class="max-w-2xl bg-white border border-slate-200 rounded-2xl shadow-sm p-6 sm:p-8">
    <form action="{{ route('salts.update', $salt->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Salt Name -->
        <div>
            <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Salt Name</label>
            <input type="text" name="name" id="name" required value="{{ old('name', $salt->name) }}" placeholder="e.g. Paracetamol" 
                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-pharma-accent focus:bg-white @error('name') border-red-500 @enderror">
            @error('name')
                <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
            @enderror
        </div>

        <!-- Description -->
        <div>
            <label for="description" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Description / Medical Properties</label>
            <textarea name="description" id="description" rows="4" placeholder="Brief details about the composition..." 
                      class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-pharma-accent focus:bg-white @error('description') border-red-500 @enderror">{{ old('description', $salt->description) }}</textarea>
            @error('description')
                <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
            @enderror
        </div>

        <!-- Actions -->
        <div class="pt-4 border-t border-slate-100 flex items-center space-x-3">
            <button type="submit" class="px-6 py-2.5 bg-pharma-accent text-white font-bold text-sm rounded-xl hover:bg-blue-700 transition shadow-md">
                Update Salt
            </button>
            <a href="{{ route('salts.index') }}" class="px-6 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-sm rounded-xl transition border border-slate-200">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
