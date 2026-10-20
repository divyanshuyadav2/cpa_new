@extends('layouts.app')

@section('title', 'Medicines by Salt / Composition A-Z | ' . setting('company_name', 'Chitranshu Pharmaceuticals Agency'))
@section('meta_description', 'Browse our wholesale range of medicines by salt and composition (A-Z). Find tablets, injections, syrups and surgicals from trusted pharma brands at Chitranshu Pharmaceuticals Agency.')

@section('content')
<div class="bg-slate-100 py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl sm:text-4xl font-extrabold text-pharma-navy">Medicines by Salt / Composition</h1>
        <p class="text-slate-600 mt-2 max-w-2xl">Pick a salt to see every brand and pack we supply wholesale.</p>

        <div class="flex flex-wrap gap-1.5 mt-6">
            @foreach($salts->keys() as $letter)
                <a href="#letter-{{ $letter }}" class="w-8 h-8 flex items-center justify-center rounded-lg bg-white border border-slate-200 text-xs font-bold text-slate-600 hover:bg-pharma-navy hover:text-white transition">{{ $letter }}</a>
            @endforeach
        </div>

        <div class="mt-8 space-y-8">
            @foreach($salts as $letter => $group)
                <section id="letter-{{ $letter }}">
                    <h2 class="text-xl font-extrabold text-pharma-navy mb-3">{{ $letter }}</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2">
                        @foreach($group as $salt)
                            <a href="{{ route('public.salts.show', [$salt->id, \Illuminate\Support\Str::slug($salt->name)]) }}"
                               class="flex justify-between items-center px-4 py-2.5 bg-white rounded-xl border border-slate-200 hover:border-pharma-accent transition text-sm">
                                <span class="font-semibold text-slate-800">{{ $salt->name }}</span>
                                <span class="text-xs text-slate-400">{{ $salt->products_count }}</span>
                            </a>
                        @endforeach
                    </div>
                </section>
            @endforeach
        </div>
    </div>
</div>
@endsection
