@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-extrabold text-pharma-navy">Stockistship Applications</h1>
    <p class="text-sm text-slate-500 mt-1">Review and manage business applications submitted via the About us & Contact page.</p>
</div>

<!-- Table Card -->
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    @if($applications->isEmpty())
        <div class="p-12 text-center text-slate-400">
            <span class="text-4xl block mb-3">📄</span>
            No stockistship applications received yet.
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50 text-[10px] font-bold text-slate-500 uppercase">
                        <th class="p-4">Applicant Name</th>
                        <th class="p-4">Email</th>
                        <th class="p-4">Phone</th>
                        <th class="p-4">Agency Address</th>
                        <th class="p-4">Status</th>
                        <th class="p-4">Submission Date</th>
                        <th class="p-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @foreach($applications as $app)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="p-4 font-bold text-slate-900">{{ $app->name }}</td>
                            <td class="p-4 text-slate-600 font-semibold">{{ $app->email }}</td>
                            <td class="p-4 font-medium text-slate-700">{{ $app->phone }}</td>
                            <td class="p-4 text-xs text-slate-500 max-w-xs truncate" title="{{ $app->address }}">{{ $app->address }}</td>
                            <td class="p-4">
                                @if($app->status == 'Pending')
                                    <span class="inline-flex px-2 py-0.5 rounded-full text-[10px] font-bold bg-yellow-100 text-yellow-800 border border-yellow-200">Pending</span>
                                @elseif($app->status == 'Reviewed')
                                    <span class="inline-flex px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-800 border border-blue-200">Reviewed</span>
                                @else
                                    <span class="inline-flex px-2 py-0.5 rounded-full text-[10px] font-bold bg-green-100 text-green-800 border border-green-200">Actioned</span>
                                @endif
                            </td>
                            <td class="p-4 text-xs text-slate-500">{{ $app->created_at->format('d-M-Y h:i A') }}</td>
                            <td class="p-4 text-right flex justify-end items-center space-x-2 h-14">
                                <a href="{{ route('applications.show', $app->id) }}" class="px-2.5 py-1 bg-slate-100 text-slate-700 font-semibold text-xs rounded border border-slate-200 hover:bg-slate-200 transition">
                                    View Details
                                </a>
                                <form action="{{ route('applications.destroy', $app->id) }}" method="POST" 
                                      onsubmit="return confirm('Are you sure you want to delete this application?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-2.5 py-1 bg-red-50 text-red-600 font-semibold text-xs rounded border border-red-200 hover:bg-red-600 hover:text-white transition">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-slate-200 bg-slate-50">
            {{ $applications->links() }}
        </div>
    @endif
</div>
@endsection
