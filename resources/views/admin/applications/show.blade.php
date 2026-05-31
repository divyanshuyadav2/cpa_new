@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <a href="{{ route('applications.index') }}" class="text-xs font-bold text-pharma-accent hover:underline mb-2 block">&larr; Back to Applications</a>
    <h1 class="text-3xl font-extrabold text-pharma-navy">Application Details</h1>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <!-- Left: Application Details (2 columns on lg) -->
    <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8 space-y-6">
        <div>
            <h2 class="text-lg font-bold text-slate-800 border-b border-slate-100 pb-2 mb-4">Applicant & Agency Information</h2>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <span class="block text-[10px] font-bold text-slate-400 uppercase">Agency / Business Name</span>
                    <strong class="text-slate-900 text-base">{{ $application->name }}</strong>
                </div>
                <div>
                    <span class="block text-[10px] font-bold text-slate-400 uppercase">Contact Mobile</span>
                    <strong class="text-slate-900 text-base">{{ $application->phone }}</strong>
                </div>
                <div>
                    <span class="block text-[10px] font-bold text-slate-400 uppercase">Email Address</span>
                    <a href="mailto:{{ $application->email }}" class="text-pharma-accent font-bold hover:underline">{{ $application->email }}</a>
                </div>
                <div>
                    <span class="block text-[10px] font-bold text-slate-400 uppercase">Date Submitted</span>
                    <strong class="text-slate-900">{{ $application->created_at->format('d-M-Y h:i A') }}</strong>
                </div>
            </div>
        </div>

        <div>
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Agency Location / Address</h3>
            <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm leading-relaxed">
                {{ $application->address }}
            </div>
        </div>

        <div>
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Business License / Query Details</h3>
            <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm leading-relaxed whitespace-pre-line">
                {{ $application->message ?? 'No additional details provided.' }}
            </div>
        </div>
    </div>

    <!-- Right: Application Status Form (1 column on lg) -->
    <div class="lg:col-span-1 space-y-6">
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4 border-b border-slate-100 pb-2">Status Actions</h3>
            
            <form action="{{ route('applications.update-status', $application->id) }}" method="POST" class="space-y-4">
                @csrf
                @method('PATCH')
                
                <div>
                    <label for="status" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Application Status</label>
                    <select name="status" id="status" required
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pharma-accent focus:bg-white transition">
                        <option value="Pending" {{ $application->status == 'Pending' ? 'selected' : '' }}>Pending Review</option>
                        <option value="Reviewed" {{ $application->status == 'Reviewed' ? 'selected' : '' }}>Reviewed / Shortlisted</option>
                        <option value="Actioned" {{ $application->status == 'Actioned' ? 'selected' : '' }}>Actioned / Approved</option>
                    </select>
                </div>

                <button type="submit" class="w-full py-2.5 bg-slate-800 hover:bg-slate-900 text-white font-bold text-sm rounded-xl transition shadow-sm">
                    Update Status
                </button>
            </form>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm text-center">
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Email Notification</h3>
            <p class="text-xs text-slate-500 mb-4">Start composing a direct mail response to this applicant in your default client.</p>
            <a href="mailto:{{ $application->email }}?subject=Stockistship%20Application%20Review%20-%20Chitranshu%20Pharma" 
               class="w-full py-2.5 bg-pharma-light text-pharma-navy font-bold text-sm rounded-xl hover:bg-pharma-navy hover:text-white transition shadow-sm flex justify-center items-center">
                ✉️ Send Email Response
            </a>
        </div>
    </div>

</div>
@endsection
