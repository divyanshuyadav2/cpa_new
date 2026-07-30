@extends('layouts.admin')

@section('title', 'Map Import Columns')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
    <div>
        <h2 class="text-3xl font-extrabold text-pharma-navy">Map CSV Columns</h2>
        <p class="text-sm text-slate-500 mt-1">We've auto-detected common column names. Review and adjust below, then click <strong>Process Import</strong>.</p>
    </div>
    <a href="{{ route('products.import.index') }}" class="px-4 py-2 bg-slate-200 text-slate-700 font-bold rounded-lg hover:bg-slate-300 transition mt-4 md:mt-0 flex items-center">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        Cancel
    </a>
</div>

{{-- CSV Row Preview --}}
@if(!empty($previewRows))
<div class="mb-6">
    <div class="flex items-center justify-between mb-2">
        <h3 class="text-sm font-bold text-slate-600 uppercase tracking-wide">📊 CSV Preview (showing first {{ count($previewRows) }} of {{ $totalRows ?? 'all' }} rows)</h3>
        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-800 border border-blue-200">
            Don't worry, all {{ $totalRows ?? '' }} products will be imported!
        </span>
    </div>
    <div class="overflow-x-auto rounded-xl border border-slate-200 shadow-sm">
        <table class="w-full text-left text-xs">
            <thead class="bg-pharma-navy text-white">
                <tr>
                    @foreach($headers as $header)
                        <th class="px-3 py-2 font-semibold whitespace-nowrap">{{ $header }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 bg-white">
                @foreach($previewRows as $row)
                    <tr class="hover:bg-slate-50">
                        @foreach($row as $cell)
                            <td class="px-3 py-2 text-slate-600 whitespace-nowrap max-w-[160px] truncate" title="{{ $cell }}">
                                {{ $cell ?: '—' }}
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

{{-- Mapping Form --}}
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">

    <div class="p-4 mb-6 text-sm rounded-xl bg-amber-50 border border-amber-200 flex items-start gap-2 shadow-sm">
        <svg class="w-5 h-5 flex-shrink-0 text-amber-500 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
        <div>
            <p class="font-semibold text-amber-800">Column Mapping</p>
            <p class="text-amber-700 mt-0.5">Auto-detection has pre-filled the most likely matches (highlighted in <span class="text-green-700 font-semibold">green</span>). Fields marked <span class="text-red-500 font-bold">*</span> are required. Set unmapped fields to <em>"— Ignore —"</em>.</p>
        </div>
    </div>

    {{-- Missing columns notice --}}
    @php
        $missingFields = [];
        $importantFields = [
            'tax'           => 'Tax (%)',
            'a_tax'         => 'Additional Tax / A.Tax (%)',
            'pur'           => 'Purchase Price (Pur)',
            'hsn_code'      => 'HSN Code',
            'company_name'  => 'Company Name',
            'ptr'           => 'PTR / Sale Rate',
            'pts'           => 'PTS / Np Rate',
        ];
        foreach ($importantFields as $fk => $fl) {
            if (!isset($autoMap[$fk])) {
                $missingFields[$fk] = $fl;
            }
        }
    @endphp

    @if(count($missingFields))
    <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-sm">
        <div class="flex items-start gap-2">
            <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
            <div class="flex-1">
                <p class="font-bold text-red-800">Your CSV is missing these columns — they cannot be mapped:</p>
                <div class="flex flex-wrap gap-2 mt-2">
                    @foreach($missingFields as $mk => $ml)
                        <span class="inline-block bg-red-100 border border-red-300 text-red-700 text-xs font-semibold px-2.5 py-1 rounded-full">{{ $ml }}</span>
                    @endforeach
                </div>
                <p class="text-red-700 mt-3 text-xs leading-relaxed">
                    These fields will be <strong>ignored</strong> during this import because your CSV has no matching column header for them.
                    To import Tax, Purchase Price, HSN Code etc., your CSV file must contain those column names.
                </p>
                <a href="{{ route('products.import.sample') }}" class="inline-flex items-center gap-1.5 mt-3 font-bold text-sm text-red-800 underline hover:text-red-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Download sample CSV template (has ALL columns including Tax, A.Tax, Pur, HSN)
                </a>
                <span class="text-xs text-red-600 block mt-1">Fill your data into that template and re-upload to map all fields.</span>
            </div>
        </div>
    </div>
    @endif

    <form action="{{ route('products.import.process') }}" method="POST">
        @csrf
        <input type="hidden" name="path" value="{{ $path }}">

        @if($errors->any())
            <div class="mb-4 p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="overflow-x-auto border border-slate-200 rounded-xl">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 border-b border-slate-200 text-xs font-bold text-slate-500 uppercase">
                    <tr>
                        <th class="p-4 w-2/5">Database Field</th>
                        <th class="p-4 w-3/5">CSV Column to Map</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @foreach($dbFields as $key => $label)
                    @php
                        $isAutoMapped = isset($autoMap[$key]);
                        $isRequired   = $key === 'name';
                    @endphp
                    <tr class="hover:bg-slate-50 transition {{ $isAutoMapped ? 'bg-green-50/40' : '' }}">
                        <td class="p-4">
                            <div class="flex items-center gap-2">
                                @if($isAutoMapped)
                                    <span class="inline-block w-2 h-2 rounded-full bg-green-500 flex-shrink-0" title="Auto-detected"></span>
                                @else
                                    <span class="inline-block w-2 h-2 rounded-full bg-slate-300 flex-shrink-0"></span>
                                @endif
                                <strong class="text-slate-800">{{ $label }}</strong>
                                @if($isRequired)
                                    <span class="text-red-500 font-bold">*</span>
                                @endif
                            </div>
                            @if($isAutoMapped)
                                <p class="text-xs text-green-600 mt-1 ml-4">Auto-detected from "{{ $autoMap[$key] }}"</p>
                            @endif
                        </td>
                        <td class="p-4">
                            <select name="mapping[{{ $key }}]"
                                    class="w-full bg-white border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pharma-accent transition
                                           {{ $isAutoMapped ? 'border-green-400 ring-1 ring-green-200' : 'border-slate-300' }}
                                           {{ $isRequired ? 'border-red-300' : '' }}"
                                    {{ $isRequired ? 'required' : '' }}>
                                <option value="">— Ignore —</option>
                                @foreach($headers as $header)
                                    <option value="{{ $header }}"
                                        {{ isset($autoMap[$key]) && $autoMap[$key] === $header ? 'selected' : '' }}>
                                        {{ $header }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6 flex flex-col sm:flex-row justify-between items-center gap-4">
            <p class="text-xs text-slate-500">
                <span class="inline-block w-2 h-2 rounded-full bg-green-500 mr-1"></span>Green rows were auto-detected &nbsp;|&nbsp;
                <span class="inline-block w-2 h-2 rounded-full bg-slate-300 mr-1"></span>Grey rows need manual mapping (or can be ignored)
            </p>
            <button type="submit" class="px-8 py-3 bg-green-600 text-white font-bold rounded-xl hover:bg-green-700 transition shadow-md flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                Process Import
            </button>
        </div>
    </form>
</div>
@endsection
