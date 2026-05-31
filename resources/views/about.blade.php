@extends('layouts.app')

@section('title', 'About Us & Stockistship - ' . setting('company_name', 'Chitranshu Pharmaceuticals Agency'))

@section('content')
<!-- Hero Section -->
<div class="relative overflow-hidden bg-gradient-to-br from-pharma-navy to-slate-900 text-white py-12 sm:py-16">
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-3xl sm:text-5xl font-extrabold tracking-tight font-display mb-4">
            About Our Agency
        </h1>
        <p class="max-w-2xl mx-auto text-sm sm:text-base text-slate-300 leading-relaxed">
            Distributing authentic and quality pharmaceutical formulations with dedicated support across regions.
        </p>
    </div>
</div>

<div class="bg-slate-100 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
            
            <!-- Left: About & Map -->
            <div class="space-y-6">
                <!-- Info Card -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                    <h2 class="text-xl font-bold text-pharma-navy mb-4">Who We Are</h2>
                    <p class="text-sm text-slate-600 leading-relaxed mb-4">
                        {{ setting('company_name', 'Chitranshu Pharmaceuticals Agency') }} is a leading name in pharmaceutical distribution. We represent top-tier pharmaceutical manufacturers and maintain a rigorous supply chain to deliver high-quality tablets, capsules, liquids, and topical formulations.
                    </p>
                    <div class="text-sm border-t border-slate-100 pt-4 space-y-2">
                        <p class="text-slate-500 font-bold uppercase text-[10px]">Office Address:</p>
                        <p class="text-slate-800 font-semibold italic">📍 {{ setting('address', 'Nathupur Bhullanpur P.A.C Varanasi') }}</p>
                        <p class="text-slate-500 font-bold uppercase text-[10px] mt-2">Contact Details:</p>
                        <p class="text-slate-800 font-semibold">📞 Mob: {{ setting('phone', '8299770727') }}</p>
                        <p class="text-slate-800 font-semibold">✉️ Email: {{ setting('email', 'info@chitranshupharma.com') }}</p>
                    </div>
                </div>

                <!-- Google Map Embed Card -->
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden h-80 flex flex-col">
                    <div class="px-6 py-3 border-b border-slate-100 bg-slate-50 text-xs font-bold text-slate-600 uppercase tracking-wider">
                        Office Location Map
                    </div>
                    <div class="flex-grow w-full h-full relative">
                        <iframe class="absolute inset-0 w-full h-full border-0" 
                                src="https://maps.google.com/maps?q=Nathupur%20Bhullanpur%20PAC%20Varanasi&t=&z=14&ie=UTF8&iwloc=&output=embed" 
                                allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>

            <!-- Right: Stockistship / Contact Form -->
            <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm h-fit">
                <h2 class="text-xl font-bold text-pharma-navy mb-2">Apply for Stockistship</h2>
                <p class="text-xs text-slate-500 mb-6">Are you looking to partner with us for distribution? Fill out this application form, and our stockist team will review your business credentials.</p>
                
                <form action="{{ route('about.submit') }}" method="POST" class="space-y-4">
                    @csrf
                    
                    <!-- Applicant/Agency Name -->
                    <div>
                        <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Applicant / Agency Name</label>
                        <input type="text" name="name" id="name" required value="{{ old('name') }}" placeholder="e.g. John Doe / Apex Pharmacy" 
                               class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-pharma-accent focus:bg-white @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Email Address</label>
                        <input type="email" name="email" id="email" required value="{{ old('email') }}" placeholder="e.g. contact@agency.com" 
                               class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-pharma-accent focus:bg-white @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone Number -->
                    <div>
                        <label for="phone" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Contact Mobile Number</label>
                        <input type="text" name="phone" id="phone" required value="{{ old('phone') }}" placeholder="e.g. 9876543210" 
                               class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-pharma-accent focus:bg-white @error('phone') border-red-500 @enderror">
                        @error('phone')
                            <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Business / Agency Address -->
                    <div>
                        <label for="address" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Agency / Business Address</label>
                        <textarea name="address" id="address" rows="3" required placeholder="Provide full shipping or license address..." 
                                  class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-pharma-accent focus:bg-white @error('address') border-red-500 @enderror">{{ old('address') }}</textarea>
                        @error('address')
                            <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Message -->
                    <div>
                        <label for="message" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Drug License details / Additional Queries</label>
                        <textarea name="message" id="message" rows="3" placeholder="Enter details about your license, experience, or query..." 
                                  class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-pharma-accent focus:bg-white @error('message') border-red-500 @enderror">{{ old('message') }}</textarea>
                        @error('message')
                            <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit -->
                    <button type="submit" class="w-full mt-4 py-3 bg-gradient-to-r from-pharma-accent to-pharma-navy text-white text-sm font-bold rounded-xl hover:opacity-95 transition shadow-md">
                        Submit Application
                    </button>
                </form>
            </div>

        </div>

    </div>
</div>
@endsection
