@extends('layouts.admin')

@section('title', 'Import Products')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
    <div>
        <h2 class="text-3xl font-extrabold text-pharma-navy">Import Products</h2>
        <p class="text-sm text-slate-500 mt-1">Upload a CSV file to dynamically map and import products.</p>
    </div>
    <a href="{{ route('products.index') }}" class="px-4 py-2 bg-slate-200 text-slate-700 font-bold rounded-lg hover:bg-slate-300 transition mt-4 md:mt-0 flex items-center">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Back to Products
    </a>
</div>

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
    <form action="{{ route('products.import.upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="mb-6">
            <label for="import_file" class="block text-sm font-bold text-slate-700 mb-2">Upload CSV File</label>
            <input type="file" id="import_file" name="import_file" accept=".csv" required
                   class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-pharma-navy file:text-white hover:file:bg-slate-800 border border-slate-300 rounded-lg cursor-pointer bg-slate-50">
            @error('import_file')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
            <p class="mt-2 text-xs text-slate-500">
                Please upload a valid CSV file containing your product data. The first row must contain column headers.
            </p>
        </div>

        <button type="submit" class="px-6 py-3 bg-pharma-accent text-white font-bold rounded-xl hover:bg-blue-700 transition shadow-md">
            Upload & Map Columns
        </button>
    </form>
</div>
@endsection
