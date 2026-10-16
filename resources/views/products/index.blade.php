@extends('layouts.app')

@section('content')
<div class="bg-slate-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center">
            <div>
                <h1 class="text-3xl font-extrabold text-pharma-navy">Product Catalog</h1>
                <p class="text-sm text-slate-500 mt-1">Explore our range of pharmaceutical products, active compositions, and salts.</p>
            </div>
            <div class="mt-4 md:mt-0 text-sm font-bold text-slate-600 bg-white px-4 py-2 rounded-xl border border-slate-200 shadow-sm">
                Showing <span id="showing-first">{{ $products->firstItem() ?? 0 }}</span> - <span id="showing-last">{{ $products->lastItem() ?? 0 }}</span> of <span id="showing-total">{{ $products->total() }}</span> Products
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            
            <!-- Filters Sidebar -->
            <div class="lg:col-span-1 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm h-fit">
                <form action="{{ route('public.products.index') }}" method="GET" id="filter-form">
                    
                    <!-- Search Keyword -->
                    <div class="mb-6">
                        <label for="search" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Search Products</label>
                        <div class="flex items-center gap-2">
                            <div class="relative flex-grow">
                                <input type="text" name="search" id="search" value="{{ request('search') }}" 
                                       placeholder="Name, composition, salt..." 
                                       class="w-full pl-3 pr-8 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-pharma-accent focus:bg-white shadow-inner">
                                @if(request('search'))
                                    <a href="{{ route('public.products.index', request()->except('search')) }}" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-red-500 font-bold">×</a>
                                @endif
                            </div>
                            <button type="submit" class="px-4 py-2.5 bg-pharma-accent hover:bg-pharma-navy text-white text-sm font-bold rounded-xl transition shadow-sm flex items-center justify-center gap-1.5 shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                <span>Search</span>
                            </button>
                        </div>
                    </div>

                    <!-- Company Filter -->
                    <div class="mb-6">
                        <label for="company_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Company</label>
                        <select name="company_id" id="company_id" onchange="document.getElementById('filter-form').submit()" 
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-pharma-accent focus:bg-white transition">
                            <option value="">All Companies</option>
                            @foreach($companies as $company)
                                <option value="{{ $company->id }}" {{ request('company_id') == $company->id ? 'selected' : '' }}>
                                    {{ $company->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Division Filter -->
                    <div class="mb-6">
                        <label for="division_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Division</label>
                        <select name="division_id" id="division_id" onchange="document.getElementById('filter-form').submit()" 
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-pharma-accent focus:bg-white transition">
                            <option value="">All Divisions</option>
                            @foreach($divisions as $division)
                                <option value="{{ $division->id }}" {{ request('division_id') == $division->id ? 'selected' : '' }}>
                                    {{ $division->name }} ({{ $division->company->name }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Reset Button -->
                    @if(request()->anyFilled(['search', 'company_id', 'division_id']))
                        <a href="{{ route('public.products.index') }}" class="block text-center py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition">
                            Clear All Filters
                        </a>
                    @endif

                </form>
            </div>

            <!-- Products Listing Grid -->
            <div class="lg:col-span-3">
                @if($products->isEmpty())
                    <div class="bg-white p-12 rounded-2xl border border-slate-200 shadow-sm text-center">
                        <div class="text-4xl mb-4">💊</div>
                        <h3 class="text-lg font-bold text-slate-800">No products found</h3>
                        <p class="text-sm text-slate-500 mt-2">Try adjusting your filters or search keywords to find what you are looking for.</p>
                        <a href="{{ route('public.products.index') }}" class="inline-block mt-6 px-5 py-2.5 bg-pharma-accent text-white text-sm font-semibold rounded-xl hover:bg-pharma-navy transition">
                            Clear Filters
                        </a>
                    </div>
                @else
                    <!-- Products Grid -->
                    <div id="products-grid" class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6 mb-8">
                        @include('products._card_list', ['products' => $products])
                    </div>

                    <!-- Sentinel to trigger infinite scroll -->
                    <div id="scroll-sentinel" class="w-full h-8"></div>

                    <!-- Loading Spinner -->
                    <div id="infinite-scroll-loader" class="hidden my-8 flex justify-center items-center">
                        <div class="inline-flex items-center gap-3 px-6 py-3.5 bg-white border border-slate-200 rounded-2xl shadow-md text-pharma-navy text-sm font-bold">
                            <svg class="animate-spin h-5 w-5 text-pharma-accent" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span>Aur products load ho rahe hain...</span>
                        </div>
                    </div>

                    <!-- End of List Indicator -->
                    <div id="infinite-scroll-end" class="{{ $products->hasMorePages() ? 'hidden' : '' }} my-8 text-center">
                        <div class="inline-flex items-center gap-2 px-6 py-3 bg-white border border-slate-200 rounded-2xl text-slate-500 text-xs font-bold shadow-sm">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Sabhi products load ho chuke hain (Total <span id="showing-total-end">{{ $products->total() }}</span> Products)</span>
                        </div>
                    </div>

                    <!-- Network Error / Retry Notice -->
                    <div id="infinite-scroll-error" class="hidden my-8 text-center">
                        <div class="inline-flex items-center gap-3 px-6 py-3 bg-red-50 border border-red-200 rounded-2xl text-red-600 text-sm font-semibold shadow-sm">
                            <span>Products load karne mein problem aayi.</span>
                            <button type="button" id="retry-load-btn" class="px-3.5 py-1.5 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-xl transition shadow">
                                Retry Karein
                            </button>
                        </div>
                    </div>

                    <!-- Fallback Pagination (hidden when JS is active) -->
                    <div id="pagination-container" class="bg-white px-4 py-4 border border-slate-200 rounded-2xl shadow-sm hidden">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    let nextPageUrl = @json($products->nextPageUrl());
    let isLoading = false;

    const sentinel = document.getElementById('scroll-sentinel');
    const loader = document.getElementById('infinite-scroll-loader');
    const endNotice = document.getElementById('infinite-scroll-end');
    const errorNotice = document.getElementById('infinite-scroll-error');
    const retryBtn = document.getElementById('retry-load-btn');
    const productsGrid = document.getElementById('products-grid');
    const showingLast = document.getElementById('showing-last');
    const paginationContainer = document.getElementById('pagination-container');

    // Ensure fallback pagination is hidden when JS is active
    if (paginationContainer) {
        paginationContainer.classList.add('hidden');
    }

    if (!sentinel || !productsGrid) return;

    function loadMoreProducts() {
        if (!nextPageUrl || isLoading) return;

        isLoading = true;
        if (loader) loader.classList.remove('hidden');
        if (errorNotice) errorNotice.classList.add('hidden');

        fetch(nextPageUrl, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('HTTP status ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            if (data.html) {
                productsGrid.insertAdjacentHTML('beforeend', data.html);
            }

            nextPageUrl = data.next_page_url;

            if (showingLast && data.to) {
                showingLast.textContent = data.to;
            }

            isLoading = false;
            if (loader) loader.classList.add('hidden');

            if (!data.has_more || !nextPageUrl) {
                if (observer) observer.disconnect();
                if (endNotice) endNotice.classList.remove('hidden');
            }
        })
        .catch(err => {
            console.error('Error fetching more products:', err);
            isLoading = false;
            if (loader) loader.classList.add('hidden');
            if (errorNotice) errorNotice.classList.remove('hidden');
        });
    }

    if (retryBtn) {
        retryBtn.addEventListener('click', function () {
            loadMoreProducts();
        });
    }

    let observer = null;
    if (nextPageUrl && 'IntersectionObserver' in window) {
        observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && !isLoading && nextPageUrl) {
                    loadMoreProducts();
                }
            });
        }, {
            root: null,
            rootMargin: '350px 0px', // trigger 350px before bottom for seamless scroll
            threshold: 0
        });

        observer.observe(sentinel);
    } else if (nextPageUrl) {
        // Fallback for older browsers
        window.addEventListener('scroll', function () {
            if (isLoading || !nextPageUrl) return;
            const scrollPosition = window.innerHeight + window.scrollY;
            const threshold = document.documentElement.scrollHeight - 450;
            if (scrollPosition >= threshold) {
                loadMoreProducts();
            }
        }, { passive: true });
    }
});
</script>
@endpush
