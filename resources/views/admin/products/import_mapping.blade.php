@extends('layouts.admin')

@section('title', 'Map Import Columns')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
    <div>
        <h2 class="text-3xl font-extrabold text-pharma-navy">Map CSV Columns</h2>
        <p class="text-sm text-slate-500 mt-1">Match your uploaded CSV columns to the database fields.</p>
    </div>
    <a href="{{ route('products.import.index') }}" class="px-4 py-2 bg-slate-200 text-slate-700 font-bold rounded-lg hover:bg-slate-300 transition mt-4 md:mt-0 flex items-center">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        Cancel
    </a>
</div>

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
    <div class="p-4 mb-6 text-sm text-blue-800 rounded-xl bg-blue-50 border border-blue-200 flex items-center shadow-sm">
        <svg class="w-5 h-5 flex-shrink-0 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
        Please select which column from your CSV matches the required database fields.
    </div>

    <form action="{{ route('products.import.process') }}" method="POST">
        @csrf
        <input type="hidden" name="path" value="{{ $path }}">

        <div class="overflow-x-auto border border-slate-200 rounded-lg">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 border-b border-slate-200 text-xs font-bold text-slate-500 uppercase">
                    <tr>
                        <th class="p-4 w-1/3">Database Field</th>
                        <th class="p-4 w-2/3">CSV Column</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @foreach($dbFields as $key => $label)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="p-4">
                            <strong class="text-slate-800">{{ $label }}</strong>
                            @if($key === 'name')
                                <span class="text-red-500 ml-1">*</span>
                            @endif
                        </td>
                        <td class="p-4">
                            <select name="mapping[{{ $key }}]" class="w-full bg-white border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pharma-accent transition @if($key === 'name') border-red-300 @endif" @if($key === 'name') required @endif>
                                <option value="">-- Ignore this field --</option>
                                @foreach($headers as $header)
                                    <option value="{{ $header }}">{{ $header }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6 flex justify-end">
            <button type="submit" class="px-6 py-3 bg-green-600 text-white font-bold rounded-xl hover:bg-green-700 transition shadow-md flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                Process Import
            </button>
        </div>
    </form>
</div>
@endsection
