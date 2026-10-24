@foreach($products as $product)
    <div class="flex flex-col bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden hover:shadow-md transition duration-200 product-card">
        
        <!-- Header Badge & Image -->
        <div class="h-44 bg-slate-50 border-b border-slate-100 flex items-center justify-center text-4xl relative overflow-hidden">
            @if($product->image)
                <img src="{{ media_url($product->image) }}" alt="{{ $product->name }}" loading="lazy" class="w-full h-full object-cover">
            @else
                <span class="select-none">💊</span>
            @endif
        </div>

        <!-- Card Details -->
        <div class="p-5 flex-grow flex flex-col">
            <span class="text-[9px] font-bold text-pharma-gold uppercase tracking-wider">{{ $product->company?->name ?? 'N/A' }} | {{ $product->division?->name ?? 'N/A' }}</span>
            
            <h3 class="text-base font-bold text-slate-800 mt-1 truncate" title="{{ $product->name }}">
                <a href="{{ route('public.products.show', $product->id) }}" class="hover:text-pharma-accent transition">{{ $product->name }}</a>
            </h3>
            
            <p class="text-xs text-slate-500 font-semibold mt-1">Composition: {{ Str::limit($product->composition, 40) }}</p>
            <p class="text-xs text-slate-400 mt-2 italic">Packing: {{ $product->packing }}</p>

            <!-- Salt badge -->
            @if($product->salt?->name)
                <div class="mt-3">
                    <span class="inline-block text-[10px] font-semibold bg-slate-100 text-slate-600 px-2 py-0.5 rounded-md border border-slate-200 truncate max-w-full">
                        {{ $product->salt->name }}
                    </span>
                </div>
            @endif

            <!-- Restricted Schedule Tag -->
            @if($product->is_restricted_schedule)
                <div class="mt-2">
                    <span class="inline-flex items-center gap-1 text-[9px] font-bold text-rose-700 bg-rose-50 border border-rose-200/90 rounded-md px-1.5 py-0.5" title="Prescription Medicine - Retail Drug License Mandatory under Drugs and Cosmetics Act">
                        <span>⚠️</span> Prescription Medicine - Retail D.L. Mandatory
                    </span>
                </div>
            @endif

            <!-- Price & Cart Button -->
            <div class="mt-6 pt-4 border-t border-slate-100 flex justify-between items-center mt-auto">
                <div>
                    <span class="block text-[8px] uppercase font-bold text-slate-400">MRP Value</span>
                    <span class="text-base font-extrabold text-pharma-navy">₹{{ number_format($product->mrp, 2) }}</span>
                    <span class="block text-[8px] font-bold text-amber-700 bg-amber-50 border border-amber-200/80 rounded px-1.5 py-0.5 mt-1 w-fit">
                        For Licensed Retailers Only
                    </span>
                </div>

                <form action="{{ route('cart.add') }}" method="POST" class="flex items-center space-x-1">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="number" name="quantity" value="1" min="1" 
                           class="w-12 px-2 py-1 bg-slate-100 border border-slate-200 rounded-lg text-xs font-semibold text-center focus:outline-none focus:border-pharma-accent">
                    <button type="submit" class="px-3 py-1 bg-pharma-accent hover:bg-pharma-navy text-white text-xs font-bold rounded-lg transition shadow-sm">
                        Add
                    </button>
                </form>
            </div>
        </div>
    </div>
@endforeach

