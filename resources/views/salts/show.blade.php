@extends('layouts.app')

@php
    $company = setting('company_name', 'Chitranshu Pharmaceuticals Agency');
    $title = "{$salt->name} – Wholesale Supplier, Brands & Price List | {$company}";
    $desc = "Buy {$salt->name} medicines wholesale. {$products->total()} brand(s) available" . ($companies->isNotEmpty() ? ' from ' . $companies->take(4)->implode(', ') : '') . ". Check composition, packing and MRP at {$company}.";
    $canonical = route('public.salts.show', [$salt->id, \Illuminate\Support\Str::slug($salt->name)]);
@endphp

@section('title', $title)
@section('meta_description', \Illuminate\Support\Str::limit($desc, 158))
@section('canonical', $canonical)
@section('og_image', media_url(optional($products->first())->image) ?: asset('images/cpa_logo_blue.png'))

@push('head')
<script type="application/ld+json">
{!! json_encode([
    '@' . 'context' => 'https://schema.org',
    '@graph' => [
        [
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => url('/')],
                ['@type' => 'ListItem', 'position' => 2, 'name' => 'Salts', 'item' => route('public.salts.index')],
                ['@type' => 'ListItem', 'position' => 3, 'name' => $salt->name, 'item' => $canonical],
            ],
        ],
        [
            '@type' => 'ItemList',
            'name' => "{$salt->name} medicines",
            'itemListElement' => $products->values()->map(fn ($p, $i) => [
                '@type' => 'ListItem', 'position' => $i + 1,
                'url' => route('public.products.show', $p->id), 'name' => $p->name,
            ])->all(),
        ],
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
@endpush

@section('content')
<div class="bg-slate-100 py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="text-xs font-semibold text-slate-500 mb-4">
            <a href="{{ url('/') }}" class="hover:text-pharma-accent">Home</a> /
            <a href="{{ route('public.salts.index') }}" class="hover:text-pharma-accent">Salts</a> /
            <span class="text-slate-800">{{ $salt->name }}</span>
        </nav>

        <h1 class="text-3xl sm:text-4xl font-extrabold text-pharma-navy">{{ $salt->name }} – Wholesale Medicines</h1>
        <p class="text-slate-600 mt-3 max-w-3xl leading-relaxed">
            {{ $company }} supplies {{ $products->total() }} {{ $salt->name }} product(s)
            @if($companies->isNotEmpty()) from {{ $companies->implode(', ') }}@endif.
            @if($salt->description) {{ $salt->description }} @endif
        </p>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mt-8">
            @foreach($products as $product)
                <a href="{{ route('public.products.show', $product->id) }}" class="bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-lg hover:-translate-y-0.5 transition p-4 flex flex-col">
                    <div class="h-40 bg-slate-50 rounded-xl flex items-center justify-center mb-3 overflow-hidden">
                        @if($product->image)
                            <img src="{{ media_url($product->image) }}" alt="{{ $product->name }} – {{ $salt->name }}" loading="lazy" class="h-full w-full object-contain">
                        @else
                            <span class="text-5xl">💊</span>
                        @endif
                    </div>
                    <h2 class="text-sm font-bold text-slate-900 leading-snug">{{ $product->name }}</h2>
                    <p class="text-xs text-slate-500 mt-1">{{ $product->company?->name }}</p>
                    @if($product->packing)<p class="text-xs text-slate-500">Pack: {{ $product->packing }}</p>@endif
                    @if($product->is_restricted_schedule)
                        <span class="inline-flex items-center text-[9px] font-bold text-rose-700 bg-rose-50 border border-rose-200/90 rounded px-1.5 py-0.5 mt-1.5 w-fit">
                            Prescription Medicine - Retail D.L. Mandatory
                        </span>
                    @endif
                    @if($product->mrp)
                        <div class="mt-auto pt-2">
                            <p class="text-sm font-extrabold text-pharma-navy">MRP ₹{{ number_format($product->mrp, 2) }}</p>
                            <span class="text-[8px] font-bold text-amber-700 block">For Licensed Retailers Only</span>
                        </div>
                    @endif
                </a>
            @endforeach
        </div>

        <div class="mt-8">{{ $products->links() }}</div>

        @if($related->isNotEmpty())
            <div class="mt-12">
                <h2 class="text-lg font-extrabold text-pharma-navy mb-3">Related salts</h2>
                <div class="flex flex-wrap gap-2">
                    @foreach($related as $r)
                        <a href="{{ route('public.salts.show', [$r->id, \Illuminate\Support\Str::slug($r->name)]) }}" class="px-3 py-1.5 bg-white border border-slate-200 rounded-full text-xs font-semibold text-slate-700 hover:border-pharma-accent hover:text-pharma-accent transition">{{ $r->name }}</a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
