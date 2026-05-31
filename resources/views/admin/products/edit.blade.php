@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <a href="{{ route('products.index') }}" class="text-xs font-bold text-pharma-accent hover:underline mb-2 block">&larr; Back to Products</a>
    <h1 class="text-3xl font-extrabold text-pharma-navy">Edit Product details</h1>
</div>

<div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 sm:p-8" x-data="productForm()">
    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Product Name -->
            <div>
                <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Product Name</label>
                <input type="text" name="name" id="name" required value="{{ old('name', $product->name) }}" placeholder="e.g. Paracip 650" 
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-pharma-accent focus:bg-white @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Chemical Salt Dropdown -->
            <div>
                <label for="salt_id" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Salt / Chemical Composition</label>
                <select name="salt_id" id="salt_id" required
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-pharma-accent focus:bg-white transition @error('salt_id') border-red-500 @enderror">
                    <option value="">Select a Salt</option>
                    @foreach($salts as $salt)
                        <option value="{{ $salt->id }}" {{ old('salt_id', $product->salt_id) == $salt->id ? 'selected' : '' }}>
                            {{ $salt->name }}
                        </option>
                    @endforeach
                </select>
                @error('salt_id')
                    <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Company Dropdown (Trigger) -->
            <div>
                <label for="company_id" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Company (Manufacturer)</label>
                <select name="company_id" id="company_id" required x-model="selectedCompany" @change="fetchDivisions()"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-pharma-accent focus:bg-white transition @error('company_id') border-red-500 @enderror">
                    <option value="">Select a Company</option>
                    @foreach($companies as $company)
                        <option value="{{ $company->id }}">
                            {{ $company->name }}
                        </option>
                    @endforeach
                </select>
                @error('company_id')
                    <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Division Dropdown (Filtered) -->
            <div>
                <label for="division_id" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Division</label>
                <select name="division_id" id="division_id" required x-model="selectedDivision" :disabled="!selectedCompany"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-pharma-accent focus:bg-white transition @error('division_id') border-red-500 @enderror">
                    <option value="">Select a Division</option>
                    <template x-for="div in divisions" :key="div.id">
                        <option :value="div.id" x-text="div.name" :selected="div.id == selectedDivision"></option>
                    </template>
                </select>
                @error('division_id')
                    <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Composition text -->
            <div>
                <label for="composition" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Formulation Composition details</label>
                <input type="text" name="composition" id="composition" required value="{{ old('composition', $product->composition) }}" placeholder="e.g. Paracetamol IP 650mg" 
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-pharma-accent focus:bg-white @error('composition') border-red-500 @enderror">
                @error('composition')
                    <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Packing -->
            <div>
                <label for="packing" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Packing Size</label>
                <input type="text" name="packing" id="packing" required value="{{ old('packing', $product->packing) }}" placeholder="e.g. 15 Tablets / 100ml Bottle" 
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-pharma-accent focus:bg-white @error('packing') border-red-500 @enderror">
                @error('packing')
                    <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- MRP -->
            <div>
                <label for="mrp" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">MRP Value (₹)</label>
                <input type="number" step="0.01" name="mrp" id="mrp" required value="{{ old('mrp', $product->mrp) }}" placeholder="0.00" 
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-pharma-accent focus:bg-white @error('mrp') border-red-500 @enderror">
                @error('mrp')
                    <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- PTR -->
            <div>
                <label for="ptr" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">PTR Value (Price to Retailer) (₹)</label>
                <input type="number" step="0.01" name="ptr" id="ptr" required value="{{ old('ptr', $product->ptr) }}" placeholder="0.00" 
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-pharma-accent focus:bg-white @error('ptr') border-red-500 @enderror">
                @error('ptr')
                    <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- PTS -->
            <div>
                <label for="pts" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">PTS Value (Price to Stockist) (₹)</label>
                <input type="number" step="0.01" name="pts" id="pts" required value="{{ old('pts', $product->pts) }}" placeholder="0.00" 
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-pharma-accent focus:bg-white @error('pts') border-red-500 @enderror">
                @error('pts')
                    <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Stock Qty -->
            <div>
                <label for="stock_qty" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Inventory Stock Quantity</label>
                <input type="number" name="stock_qty" id="stock_qty" required value="{{ old('stock_qty', $product->stock_qty) }}" placeholder="0" 
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-pharma-accent focus:bg-white @error('stock_qty') border-red-500 @enderror">
                @error('stock_qty')
                    <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Image preview & Upload -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Current Formulation Image</label>
                <div class="w-24 h-24 mb-4 bg-slate-50 border border-slate-200 rounded-2xl flex items-center justify-center text-3xl overflow-hidden shadow-sm">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    @else
                        💊
                    @endif
                </div>

                <label for="image" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Upload New Formulation Image</label>
                <input type="file" name="image" id="image" accept="image/*"
                       class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-pharma-light file:text-pharma-navy hover:file:bg-blue-100 transition">
                <span class="text-[10px] text-slate-400 mt-1 block">Leave empty to keep current image. Max 2MB.</span>
                @error('image')
                    <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Active Toggle -->
            <div class="flex items-center">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                       class="w-4 h-4 rounded bg-slate-100 border-slate-300 text-pharma-accent focus:ring-pharma-accent">
                <label for="is_active" class="ml-2 block text-xs font-bold uppercase tracking-wider text-slate-700 cursor-pointer">
                    Active Status
                </label>
            </div>
        </div>

        <!-- Actions -->
        <div class="pt-4 border-t border-slate-100 flex items-center space-x-3">
            <button type="submit" class="px-6 py-2.5 bg-pharma-accent text-white font-bold text-sm rounded-xl hover:bg-blue-700 transition shadow-md">
                Update Product
            </button>
            <a href="{{ route('products.index') }}" class="px-6 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-sm rounded-xl transition border border-slate-200">
                Cancel
            </a>
        </div>
    </form>
</div>

<script>
    function productForm() {
        return {
            selectedCompany: '{{ old('company_id', $product->company_id) }}',
            selectedDivision: '{{ old('division_id', $product->division_id) }}',
            divisions: [],
            
            init() {
                if (this.selectedCompany) {
                    this.fetchDivisions();
                }
            },
            
            fetchDivisions() {
                if (!this.selectedCompany) {
                    this.divisions = [];
                    return;
                }
                
                fetch(`/admin/divisions/by-company?company_id=${this.selectedCompany}`)
                    .then(response => response.json())
                    .then(data => {
                        this.divisions = data;
                        
                        // Sync current product division if company matches
                        this.$nextTick(() => {
                            if(this.selectedCompany == '{{ $product->company_id }}') {
                                this.selectedDivision = '{{ old('division_id', $product->division_id) }}';
                            } else {
                                this.selectedDivision = '{{ old('division_id') }}';
                            }
                        });
                    });
            }
        }
    }
</script>
@endsection
