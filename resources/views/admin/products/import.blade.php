@extends('layouts.admin')

@section('title', 'Import Products')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
    <div>
        <h2 class="text-3xl font-extrabold text-pharma-navy">Import Products</h2>
        <p class="text-sm text-slate-500 mt-1">Upload an Excel (.xlsx) or CSV file to dynamically map and import products into the catalogue.</p>
    </div>
    <a href="{{ route('products.index') }}" class="px-4 py-2 bg-slate-200 text-slate-700 font-bold rounded-lg hover:bg-slate-300 transition mt-4 md:mt-0 flex items-center">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Back to Products
    </a>
</div>

{{-- Success / Error Messages --}}
@if(session('success'))
    <div class="mb-4 p-4 rounded-xl bg-green-50 border border-green-200 text-green-800 text-sm font-medium">
        ✅ {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div class="mb-4 p-4 rounded-xl bg-red-50 border border-red-200 text-red-800 text-sm font-medium">
        ❌ {{ session('error') }}
    </div>
@endif

{{-- Info box --}}
<div class="mb-6 p-4 rounded-xl bg-blue-50 border border-blue-200 text-blue-800 text-sm">
    <p class="font-bold mb-2">📋 Supported Format</p>
    <p class="mb-2">You can upload <strong>Excel (.xlsx)</strong> or <strong>CSV</strong> files. The first row must be the header. The following columns are recognised automatically:</p>
    <div class="flex flex-wrap gap-2 mt-2">
        @foreach(['Name', 'Hsn', 'Company', 'MRP', 'Sale (PTR)', 'Np Rate (PTS)', 'Tax', 'A.Tax', 'Pur', 'Division', 'Salt', 'Packing', 'Stock Qty'] as $col)
            <span class="inline-block bg-blue-100 text-blue-700 text-xs font-semibold px-2 py-1 rounded-full">{{ $col }}</span>
        @endforeach
    </div>
    <p class="mt-3 text-xs text-blue-600">
        Don't have a CSV yet?
        <a href="{{ route('products.import.sample') }}" class="underline font-semibold hover:text-blue-900">Download our sample template</a>.
    </p>
</div>

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
    <form action="{{ route('products.import.upload') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-6">
            <label for="import_file" class="block text-sm font-bold text-slate-700 mb-2">Upload Excel or CSV File</label>
            <div class="flex items-center justify-center w-full">
                <label for="import_file" class="flex flex-col items-center justify-center w-full h-40 border-2 border-dashed border-slate-300 rounded-xl cursor-pointer bg-slate-50 hover:bg-slate-100 hover:border-pharma-accent transition">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <svg class="w-10 h-10 mb-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                        <p class="mb-1 text-sm text-slate-600"><span class="font-semibold">Click to upload</span> or drag &amp; drop</p>
                        <p class="text-xs text-slate-400">Excel (.xlsx) or CSV (max 10 MB)</p>
                    </div>
                    <input id="import_file" name="import_file" type="file" accept=".csv,.txt,.xlsx,.xls" class="hidden" required />
                </label>
            </div>
            <p id="file_name_display" class="mt-2 text-sm text-slatema-600 hidden text-center font-medium text-pharma-accent"></p>
            @error('import_file')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="w-full sm:w-auto px-8 py-3 bg-pharma-accent text-white font-bold rounded-xl hover:bg-blue-700 transition shadow-md flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
            Upload &amp; Map Columns
        </button>
    </form>
</div>

<script>
document.getElementById('import_file').addEventListener('change', function(e) {
    const display = document.getElementById('file_name_display');
    if (this.files.length > 0) {
        display.textContent = '📄 Selected: ' + this.files[0].name;
        display.classList.remove('hidden');
    }
});
</script>
@endsection
