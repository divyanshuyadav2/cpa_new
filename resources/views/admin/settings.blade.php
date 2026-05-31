@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-extrabold text-pharma-navy">Global Settings</h1>
    <p class="text-sm text-slate-500 mt-1">Configure general agency details, address, contact coordinates, and default WhatsApp receivers.</p>
</div>

<div class="max-w-4xl bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
    <div class="p-6 sm:p-8">
        
        <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Company Name -->
                <div>
                    <label for="company_name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Company / Agency Name</label>
                    <input type="text" name="company_name" id="company_name" required value="{{ old('company_name', setting('company_name')) }}" 
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-pharma-accent focus:bg-white @error('company_name') border-red-500 @enderror">
                    @error('company_name')
                        <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tagline -->
                <div>
                    <label for="tagline" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Tagline</label>
                    <input type="text" name="tagline" id="tagline" required value="{{ old('tagline', setting('tagline')) }}" 
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-pharma-accent focus:bg-white @error('tagline') border-red-500 @enderror">
                    @error('tagline')
                        <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- WhatsApp Order Number -->
                <div>
                    <label for="whatsapp_number" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">WhatsApp Order Number</label>
                    <input type="text" name="whatsapp_number" id="whatsapp_number" required value="{{ old('whatsapp_number', setting('whatsapp_number')) }}" 
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-pharma-accent focus:bg-white @error('whatsapp_number') border-red-500 @enderror">
                    <span class="text-[10px] text-slate-400 mt-1 block font-medium">Specify the complete number with country code (e.g. 919876543210 for India). No spaces, plus signs, or hyphens.</span>
                    @error('whatsapp_number')
                        <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">General Contact Phone</label>
                    <input type="text" name="phone" id="phone" required value="{{ old('phone', setting('phone')) }}" 
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-pharma-accent focus:bg-white @error('phone') border-red-500 @enderror">
                    @error('phone')
                        <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">General Contact Email</label>
                    <input type="email" name="email" id="email" required value="{{ old('email', setting('email')) }}" 
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-pharma-accent focus:bg-white @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- GST Number -->
                <div>
                    <label for="gst_number" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">GSTIN Number</label>
                    <input type="text" name="gst_number" id="gst_number" required value="{{ old('gst_number', setting('gst_number')) }}" 
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-pharma-accent focus:bg-white @error('gst_number') border-red-500 @enderror">
                    @error('gst_number')
                        <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Address -->
            <div>
                <label for="address" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Office Address</label>
                <textarea name="address" id="address" rows="3" required
                          class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-pharma-accent focus:bg-white @error('address') border-red-500 @enderror">{{ old('address', setting('address')) }}</textarea>
                @error('address')
                    <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Actions -->
            <div class="pt-4 border-t border-slate-100 flex items-center">
                <button type="submit" class="px-6 py-2.5 bg-pharma-accent text-white font-bold text-sm rounded-xl hover:bg-blue-700 transition shadow-md">
                    Update Settings
                </button>
            </div>
        </form>

    </div>
</div>
@endsection
