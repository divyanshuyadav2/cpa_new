@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <a href="{{ route('companies.index') }}" class="text-xs font-bold text-pharma-accent hover:underline mb-2 block">&larr; Back to Companies</a>
    <h1 class="text-3xl font-extrabold text-pharma-navy">Edit Company Profile</h1>
</div>

<div class="max-w-2xl bg-white border border-slate-200 rounded-2xl shadow-sm p-6 sm:p-8">
    <form action="{{ route('companies.update', $company->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Company Name -->
        <div>
            <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Company Name</label>
            <input type="text" name="name" id="name" required value="{{ old('name', $company->name) }}" placeholder="e.g. Cipla Ltd"
                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-pharma-accent focus:bg-white @error('name') border-red-500 @enderror">
            @error('name')
                <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
            @enderror
        </div>

        <!-- Logo Upload / URL -->
        @php
            $existingLogo = $company->logo;
            $isUrl = $existingLogo && filter_var($existingLogo, FILTER_VALIDATE_URL);
            $logoSrc = $existingLogo ? ($isUrl ? $existingLogo : asset('storage/' . $existingLogo)) : null;
            $initMode = $isUrl ? 'url' : 'upload';
            $initUrlPreview = $isUrl ? $existingLogo : '';
        @endphp

        <div x-data="imageInput('logo', '{{ $initMode }}', '{{ $logoSrc }}', '{{ $initUrlPreview }}')" class="space-y-3">
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700">Company Logo</label>

            <!-- Tab Toggle -->
            <div class="flex rounded-xl overflow-hidden border border-slate-200 w-fit text-xs font-semibold">
                <button type="button"
                    @click="mode = 'upload'; clearUrl()"
                    :class="mode === 'upload' ? 'bg-pharma-accent text-white' : 'bg-slate-50 text-slate-600 hover:bg-slate-100'"
                    class="px-4 py-2 transition">
                    📁 Upload File
                </button>
                <button type="button"
                    @click="mode = 'url'; clearFile()"
                    :class="mode === 'url' ? 'bg-pharma-accent text-white' : 'bg-slate-50 text-slate-600 hover:bg-slate-100'"
                    class="px-4 py-2 transition border-l border-slate-200">
                    🔗 Image URL
                </button>
            </div>

            <!-- Upload File Panel -->
            <div x-show="mode === 'upload'" x-transition>
                <!-- Preview: shows uploaded file preview OR existing stored image -->
                <div class="mb-3 w-24 h-24 bg-slate-50 border border-slate-200 rounded-2xl flex items-center justify-center text-3xl overflow-hidden shadow-sm"
                     x-show="preview || existingImageSrc">
                    <img :src="preview || existingImageSrc" alt="Logo Preview" class="w-full h-full object-cover">
                </div>
                <div x-show="!preview && !existingImageSrc" class="mb-3 w-24 h-24 bg-slate-50 border border-slate-200 rounded-2xl flex items-center justify-center text-3xl shadow-sm">🏢</div>

                <label class="flex flex-col items-center justify-center w-full h-28 border-2 border-dashed border-slate-300 rounded-xl cursor-pointer hover:border-pharma-accent hover:bg-blue-50/50 transition">
                    <span class="text-2xl mb-1">🖼️</span>
                    <span class="text-xs text-slate-500 font-semibold" x-text="fileName || 'Click to replace logo (Max 2MB)'"></span>
                    <input type="file" name="logo" id="logo" accept="image/*" class="hidden"
                           @change="handleFile($event)">
                </label>
                <p class="text-[10px] text-slate-400 mt-1">Leave empty to keep current logo. Supports JPG, PNG, WEBP, GIF.</p>
                @error('logo')
                    <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- URL Panel -->
            <div x-show="mode === 'url'" x-transition>
                <div class="mb-3 w-24 h-24 bg-slate-50 border border-slate-200 rounded-2xl flex items-center justify-center text-3xl overflow-hidden shadow-sm"
                     x-show="urlPreview">
                    <img :src="urlPreview" alt="URL Preview" class="w-full h-full object-cover" @@error="urlPreview = ''">
                </div>
                <div x-show="!urlPreview" class="mb-3 w-24 h-24 bg-slate-50 border border-slate-200 rounded-2xl flex items-center justify-center text-3xl shadow-sm">🏢</div>
                @php $logoUrlDefault = old('logo_url', $isUrl ? $existingLogo : ''); @endphp
                <input type="url" name="logo_url" id="logo_url"
                       placeholder="https://example.com/logo.png"
                       value="{{ $logoUrlDefault }}"
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-pharma-accent focus:bg-white"
                       @input.debounce.500ms="urlPreview = $event.target.value">
                <p class="text-[10px] text-slate-400 mt-1">Paste a direct image URL. Preview will appear above.</p>
                @error('logo_url')
                    <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Description -->
        <div>
            <label for="description" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Description</label>
            <textarea name="description" id="description" rows="4" placeholder="Brief details about the manufacturer..."
                      class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-pharma-accent focus:bg-white @error('description') border-red-500 @enderror">{{ old('description', $company->description) }}</textarea>
            @error('description')
                <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
            @enderror
        </div>

        <!-- Active Toggle -->
        <div class="flex items-center">
            <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $company->is_active) ? 'checked' : '' }}
                   class="w-4 h-4 rounded bg-slate-100 border-slate-300 text-pharma-accent focus:ring-pharma-accent">
            <label for="is_active" class="ml-2 block text-xs font-bold uppercase tracking-wider text-slate-700 cursor-pointer">
                Active Status
            </label>
        </div>

        <!-- Actions -->
        <div class="pt-4 border-t border-slate-100 flex items-center space-x-3">
            <button type="submit" class="px-6 py-2.5 bg-pharma-accent text-white font-bold text-sm rounded-xl hover:bg-blue-700 transition shadow-md">
                Update Company
            </button>
            <a href="{{ route('companies.index') }}" class="px-6 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-sm rounded-xl transition border border-slate-200">
                Cancel
            </a>
        </div>
    </form>
</div>

<script>
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
