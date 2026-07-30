@extends('layouts.admin')

@section('title', 'Edit Product')

@section('content')
<div class="mb-8 flex items-center justify-between">
    <div>
        <a href="{{ route('products.index') }}" class="text-xs font-bold text-pharma-accent hover:underline mb-2 block">&larr; Back to Products</a>
        <h1 class="text-3xl font-extrabold text-pharma-navy">Edit Product</h1>
        <p class="text-sm text-slate-500 mt-1">Update product details, pricing, tax and purchase information.</p>
    </div>
    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-700 border border-amber-300">
        ✏️ Editing: {{ $product->name }}
    </span>
</div>

<div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden" x-data="productForm()">
    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- ─── SECTION 1: Product Identity ──────────────────────────────── --}}
        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-3">
            <h2 class="text-white font-bold text-sm tracking-wide uppercase">📦 Product Identity</h2>
        </div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- Product Name -->
            <div>
                <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Product Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" required value="{{ old('name', $product->name) }}" placeholder="e.g. Paracip 650"
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white @error('name') border-red-500 @enderror">
                @error('name') <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p> @enderror
            </div>

            <!-- HSN Code -->
            <div>
                <label for="hsn_code" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">HSN Code <span class="font-normal text-slate-400 normal-case">(optional)</span></label>
                <input type="text" name="hsn_code" id="hsn_code" value="{{ old('hsn_code', $product->hsn_code) }}" placeholder="e.g. 300490"
                       class="w-full px-3.5 py-2.5 bg-indigo-50 border border-indigo-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:bg-white @error('hsn_code') border-red-500 @enderror">
                @error('hsn_code') <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p> @enderror
            </div>

            <!-- Company -->
            <div>
                <label for="company_id" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Company (Manufacturer)</label>
                <select name="company_id" id="company_id" x-model="selectedCompany" @change="fetchDivisions()"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition @error('company_id') border-red-500 @enderror">
                    <option value="">Select a Company</option>
                    @foreach($companies as $company)
                        <option value="{{ $company->id }}" {{ old('company_id', $product->company_id) == $company->id ? 'selected' : '' }}>
                            {{ $company->name }}
                        </option>
                    @endforeach
                </select>
                @error('company_id') <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p> @enderror
            </div>

            <!-- Division -->
            <div>
                <label for="division_id" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Division</label>
                <select name="division_id" id="division_id" x-model="selectedDivision" :disabled="!selectedCompany"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition @error('division_id') border-red-500 @enderror">
                    <option value="">Select a Division</option>
                    <template x-for="div in divisions" :key="div.id">
                        <option :value="div.id" x-text="div.name" :selected="div.id == selectedDivision"></option>
                    </template>
                </select>
                @error('division_id') <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p> @enderror
            </div>

            <!-- Salt / Composition -->
            <div>
                <label for="salt_id" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Salt / Composition</label>
                <select name="salt_id" id="salt_id"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition @error('salt_id') border-red-500 @enderror">
                    <option value="">Select a Salt</option>
                    @foreach($salts as $salt)
                        <option value="{{ $salt->id }}" {{ old('salt_id', $product->salt_id) == $salt->id ? 'selected' : '' }}>
                            {{ $salt->name }}
                        </option>
                    @endforeach
                </select>
                @error('salt_id') <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p> @enderror
            </div>

            <!-- Composition Text -->
            <div>
                <label for="composition" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Formulation Composition</label>
                <input type="text" name="composition" id="composition" value="{{ old('composition', $product->composition) }}" placeholder="e.g. Paracetamol IP 650mg"
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white @error('composition') border-red-500 @enderror">
                @error('composition') <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p> @enderror
            </div>

            <!-- Packing -->
            <div>
                <label for="packing" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Packing Size</label>
                <input type="text" name="packing" id="packing" value="{{ old('packing', $product->packing) }}" placeholder="e.g. 10x10 Tablets"
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white @error('packing') border-red-500 @enderror">
                @error('packing') <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p> @enderror
            </div>

        </div>{{-- /product identity --}}

        {{-- ─── SECTION 2: Pricing ─────────────────────────────────────────── --}}
        <div class="bg-gradient-to-r from-emerald-600 to-teal-600 px-6 py-3">
            <h2 class="text-white font-bold text-sm tracking-wide uppercase">💰 Pricing</h2>
        </div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">

            <!-- MRP -->
            <div>
                <label for="mrp" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">MRP (₹) <span class="text-red-500">*</span></label>
                <input type="number" step="0.01" name="mrp" id="mrp" required value="{{ old('mrp', $product->mrp) }}" placeholder="0.00"
                       class="w-full px-3.5 py-2.5 bg-emerald-50 border border-emerald-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:bg-white @error('mrp') border-red-500 @enderror">
                @error('mrp') <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p> @enderror
            </div>

            <!-- PTR -->
            <div>
                <label for="ptr" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">PTR / Sale Rate (₹) <span class="text-red-500">*</span></label>
                <input type="number" step="0.01" name="ptr" id="ptr" required value="{{ old('ptr', $product->ptr) }}" placeholder="0.00"
                       class="w-full px-3.5 py-2.5 bg-emerald-50 border border-emerald-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:bg-white @error('ptr') border-red-500 @enderror">
                @error('ptr') <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p> @enderror
            </div>

            <!-- PTS -->
            <div>
                <label for="pts" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">PTS / Np Rate (₹) <span class="text-red-500">*</span></label>
                <input type="number" step="0.01" name="pts" id="pts" required value="{{ old('pts', $product->pts) }}" placeholder="0.00"
                       class="w-full px-3.5 py-2.5 bg-emerald-50 border border-emerald-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:bg-white @error('pts') border-red-500 @enderror">
                @error('pts') <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p> @enderror
            </div>

        </div>{{-- /pricing --}}

        {{-- ─── SECTION 3: Tax & Purchase Price ──────────────────────────── --}}
        <div class="bg-gradient-to-r from-orange-500 to-amber-500 px-6 py-3">
            <h2 class="text-white font-bold text-sm tracking-wide uppercase">🧾 Tax &amp; Purchase Price</h2>
        </div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">

            <!-- Tax -->
            <div>
                <label for="tax" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Tax (%) <span class="font-normal text-slate-400 normal-case">(optional)</span></label>
                <input type="number" step="0.01" min="0" name="tax" id="tax" value="{{ old('tax', $product->tax) }}" placeholder="e.g. 2.50"
                       class="w-full px-3.5 py-2.5 bg-orange-50 border border-orange-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 focus:bg-white @error('tax') border-red-500 @enderror">
                @error('tax') <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p> @enderror
            </div>

            <!-- A.Tax -->
            <div>
                <label for="a_tax" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">A.Tax / Additional Tax (%) <span class="font-normal text-slate-400 normal-case">(optional)</span></label>
                <input type="number" step="0.01" min="0" name="a_tax" id="a_tax" value="{{ old('a_tax', $product->a_tax) }}" placeholder="e.g. 2.50"
                       class="w-full px-3.5 py-2.5 bg-orange-50 border border-orange-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 focus:bg-white @error('a_tax') border-red-500 @enderror">
                @error('a_tax') <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p> @enderror
            </div>

            <!-- Purchase Price -->
            <div>
                <label for="pur" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Purchase Price / Pur (₹) <span class="font-normal text-slate-400 normal-case">(optional)</span></label>
                <input type="number" step="0.01" min="0" name="pur" id="pur" value="{{ old('pur', $product->pur) }}" placeholder="0.00"
                       class="w-full px-3.5 py-2.5 bg-orange-50 border border-orange-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 focus:bg-white @error('pur') border-red-500 @enderror">
                @error('pur') <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p> @enderror
            </div>

        </div>{{-- /tax --}}

        {{-- ─── SECTION 4: Stock, Image & Status ─────────────────────────── --}}
        <div class="bg-gradient-to-r from-slate-600 to-slate-800 px-6 py-3">
            <h2 class="text-white font-bold text-sm tracking-wide uppercase">📊 Stock, Image &amp; Status</h2>
        </div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- Stock Qty -->
            <div>
                <label for="stock_qty" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Stock Quantity <span class="text-red-500">*</span></label>
                <input type="number" name="stock_qty" id="stock_qty" required value="{{ old('stock_qty', $product->stock_qty) }}" placeholder="0"
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-pharma-accent focus:bg-white @error('stock_qty') border-red-500 @enderror">
                @error('stock_qty') <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p> @enderror
            </div>

            <!-- Active Toggle -->
            <div class="flex items-center pt-6">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                       class="w-4 h-4 rounded bg-slate-100 border-slate-300 text-pharma-accent focus:ring-pharma-accent">
                <label for="is_active" class="ml-2 block text-xs font-bold uppercase tracking-wider text-slate-700 cursor-pointer">
                    Active Status
                </label>
            </div>

            <!-- Image Upload / URL -->
            @php
                $existingImg = $product->image;
                $isImgUrl    = $existingImg && filter_var($existingImg, FILTER_VALIDATE_URL);
                $imgSrc      = media_url($existingImg);
                $imgInitMode = $isImgUrl ? 'url' : 'upload';
                $imgInitUrl  = $isImgUrl ? $existingImg : '';
            @endphp
            <div x-data="imageInput('image', '{{ $imgInitMode }}', '{{ $imgSrc }}', '{{ $imgInitUrl }}')" class="space-y-3 md:col-span-2">
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700">Product Image</label>

                <div class="flex rounded-xl overflow-hidden border border-slate-200 w-fit text-xs font-semibold">
                    <button type="button" @click="mode = 'upload'; clearUrl()"
                            :class="mode === 'upload' ? 'bg-pharma-accent text-white' : 'bg-slate-50 text-slate-600 hover:bg-slate-100'"
                            class="px-4 py-2 transition">📁 Upload File</button>
                    <button type="button" @click="mode = 'url'; clearFile()"
                            :class="mode === 'url' ? 'bg-pharma-accent text-white' : 'bg-slate-50 text-slate-600 hover:bg-slate-100'"
                            class="px-4 py-2 transition border-l border-slate-200">🔗 Image URL</button>
                </div>

                <div x-show="mode === 'upload'" x-transition>
                    <div class="mb-2 w-20 h-20 bg-slate-50 border border-slate-200 rounded-xl flex items-center justify-center text-2xl overflow-hidden"
                         x-show="preview || existingImageSrc">
                        <img :src="preview || existingImageSrc" alt="Preview" class="w-full h-full object-cover">
                    </div>
                    <div x-show="!preview && !existingImageSrc" class="mb-2 w-20 h-20 bg-slate-50 border border-slate-200 rounded-xl flex items-center justify-center text-2xl">💊</div>
                    <label class="flex flex-col items-center justify-center w-full h-24 border-2 border-dashed border-slate-300 rounded-xl cursor-pointer hover:border-pharma-accent hover:bg-blue-50/50 transition">
                        <span class="text-xl mb-1">🖼️</span>
                        <span class="text-xs text-slate-500 font-semibold" x-text="fileName || 'Click to replace image (Max 2MB)'"></span>
                        <input type="file" name="image" id="image" accept="image/*" class="hidden" @change="handleFile($event)">
                    </label>
                    @error('image') <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p> @enderror
                </div>

                <div x-show="mode === 'url'" x-transition>
                    <div class="mb-2 w-20 h-20 bg-slate-50 border border-slate-200 rounded-xl flex items-center justify-center text-2xl overflow-hidden" x-show="urlPreview">
                        <img :src="urlPreview" alt="Preview" class="w-full h-full object-cover" @@error="urlPreview = ''">
                    </div>
                    <div x-show="!urlPreview" class="mb-2 w-20 h-20 bg-slate-50 border border-slate-200 rounded-xl flex items-center justify-center text-2xl">💊</div>
                    @php $imgUrlDefault = old('image_url', $isImgUrl ? $existingImg : ''); @endphp
                    <input type="url" name="image_url" id="image_url"
                           placeholder="https://example.com/product.jpg"
                           value="{{ $imgUrlDefault }}"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-pharma-accent focus:bg-white"
                           @input.debounce.500ms="urlPreview = $event.target.value">
                    @error('image_url') <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p> @enderror
                </div>
            </div>

        </div>{{-- /stock --}}

        {{-- ─── Actions ─────────────────────────────────────────────────────── --}}
        <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 flex items-center gap-3">
            <button type="submit" class="px-8 py-2.5 bg-pharma-accent text-white font-bold text-sm rounded-xl hover:bg-blue-700 transition shadow-md">
                💾 Update Product
            </button>
            <a href="{{ route('products.index') }}" class="px-6 py-2.5 bg-white hover:bg-slate-100 text-slate-700 font-bold text-sm rounded-xl transition border border-slate-200">
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
                        this.$nextTick(() => {
                            if (this.selectedCompany == '{{ $product->company_id }}') {
                                this.selectedDivision = '{{ old('division_id', $product->division_id) }}';
                            } else {
                                this.selectedDivision = '{{ old('division_id') }}';
                            }
                        });
                    });
            }
        }
    }

    function imageInput(fieldName, initMode, existingImageSrc, initUrlPreview) {
        return {
            mode: initMode || 'upload',
            preview: null,
            urlPreview: initUrlPreview || '',
            existingImageSrc: existingImageSrc || '',
            fileName: '',
            handleFile(event) {
                const file = event.target.files[0];
                if (!file) return;
                this.fileName = file.name;
                const reader = new FileReader();
                reader.onload = (e) => { this.preview = e.target.result; };
                reader.readAsDataURL(file);
            },
            clearFile() {
                this.preview = null;
                this.fileName = '';
                const inp = document.getElementById(fieldName);
                if (inp) inp.value = '';
            },
            clearUrl() {
                this.urlPreview = '';
                const inp = document.getElementById(fieldName + '_url');
                if (inp) inp.value = '';
            }
        };
    }
</script>
@endsection
