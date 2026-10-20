@php
    $status = \App\Models\Order::canonicalStatus($status);
    $map = [
        'Pending'    => 'bg-yellow-100 text-yellow-800 border-yellow-200',
        'Confirmed'  => 'bg-blue-100 text-blue-800 border-blue-200',
        'Dispatched' => 'bg-purple-100 text-purple-800 border-purple-200',
        'Delivered'  => 'bg-emerald-100 text-emerald-800 border-emerald-200',
        'Cancelled'  => 'bg-red-100 text-red-800 border-red-200',
    ];
@endphp
<span class="inline-flex px-2 py-0.5 rounded-full text-[10px] font-bold border {{ $map[$status] ?? 'bg-slate-100 text-slate-700 border-slate-200' }}">{{ $status }}</span>
