<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice #{{ $order->id }}</title>
    <style>
        body { font-family: Arial, sans-serif; color: #111; max-width: 800px; margin: 24px auto; padding: 0 16px; font-size: 13px; }
        h1 { margin: 0; font-size: 22px; } .muted { color: #666; }
        .head { display: flex; justify-content: space-between; border-bottom: 2px solid #111; padding-bottom: 12px; margin-bottom: 16px; }
        table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        th, td { border-bottom: 1px solid #ddd; padding: 8px 6px; text-align: left; }
        th { background: #f3f4f6; font-size: 11px; text-transform: uppercase; } .r { text-align: right; } .c { text-align: center; }
        .total { font-size: 16px; font-weight: bold; } .note { margin-top: 16px; padding: 10px; background: #fffbeb; border: 1px solid #fcd34d; }
        .bar { text-align: right; margin-bottom: 12px; } button { padding: 8px 16px; cursor: pointer; }
        @media print { .bar { display: none; } body { margin: 0; } }
    </style>
</head>
<body>
    <div class="bar"><button onclick="window.print()">🖨 Print</button></div>
    <div class="head">
        <div>
            <h1>{{ setting('company_name', 'Chitranshu Pharmaceuticals Agency') }}</h1>
            @if(setting('company_address'))<div class="muted">{{ setting('company_address') }}</div>@endif
            @if(setting('company_phone'))<div class="muted">Phone: {{ setting('company_phone') }}</div>@endif
        </div>
        <div class="r">
            <strong>ORDER #{{ $order->id }}</strong><br>
            {{ $order->created_at->format('d M Y, h:i A') }}<br>
            Status: {{ $order->status_label }}
            @if($order->invoice_no)<br>Invoice: {{ $order->invoice_no }}@endif
        </div>
    </div>

    <strong>Bill to:</strong> {{ $order->customer_name }}<br>
    <span class="muted">Phone: {{ $order->phone }}@if($order->user?->address) &middot; {{ $order->user->address }}@endif</span>

    <table>
        <thead><tr><th>#</th><th>Item</th><th>Packing</th><th class="c">Qty</th><th class="r">Price</th><th class="r">Amount</th></tr></thead>
        <tbody>
        @foreach($order->items() as $i => $item)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $item['name'] ?? 'Product' }}@if(!empty($item['company']))<br><span class="muted">{{ $item['company'] }}</span>@endif</td>
                <td>{{ $item['packing'] ?? '' }}</td>
                <td class="c">{{ $item['qty'] ?? 0 }} {{ $item['unit'] ?? '' }}</td>
                <td class="r">₹{{ number_format($item['price'] ?? 0, 2) }}</td>
                <td class="r">₹{{ number_format(($item['qty'] ?? 0) * ($item['price'] ?? 0), 2) }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot><tr><td colspan="5" class="r total">Total</td><td class="r total">₹{{ number_format($order->total, 2) }}</td></tr></tfoot>
    </table>

    @php $noteText = $order->notes ?: (is_array($order->cart) ? ($order->cart['_order_notes'] ?? null) : null); @endphp
    @if($noteText)<div class="note"><strong>Notes:</strong> {{ $noteText }}</div>@endif
</body>
</html>
