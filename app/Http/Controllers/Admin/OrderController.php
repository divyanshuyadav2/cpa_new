<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Filtered listing with search, status, date range and totals.
     */
    public function index(Request $request)
    {
        $query = $this->filtered($request);

        $summary = [
            'count' => (clone $query)->count(),
            'total' => (float) (clone $query)->where('status', '!=', 'Cancelled')->sum('total'),
        ];
        $statusCounts = Order::selectRaw('status, count(*) as c')->groupBy('status')->pluck('c', 'status');
        $orders = $query->latest()->paginate(15)->withQueryString();

        return view('admin.orders.index', compact('orders', 'summary', 'statusCounts'));
    }

    protected function filtered(Request $request)
    {
        return Order::query()
            ->search($request->query('q'))
            ->when(in_array($request->query('status'), Order::STATUSES, true), fn ($q) => $q->where('status', $request->query('status')))
            ->when($request->filled('from'), fn ($q) => $q->whereDate('created_at', '>=', $request->query('from')))
            ->when($request->filled('to'), fn ($q) => $q->whereDate('created_at', '<=', $request->query('to')));
    }

    /**
     * Download the currently filtered orders as CSV.
     */
    public function export(Request $request)
    {
        $orders = $this->filtered($request)->latest()->get();

        return response()->streamDownload(function () use ($orders) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['Order ID', 'Date', 'Customer', 'Phone', 'Items', 'Total', 'Status', 'Invoice No', 'Notes']);
            foreach ($orders as $o) {
                fputcsv($out, [
                    $o->id, $o->created_at->format('Y-m-d H:i'), $o->customer_name, $o->phone,
                    count($o->items()), $o->total, $o->status, $o->invoice_no, $o->notes,
                ]);
            }
            fclose($out);
        }, 'orders-' . now()->format('Ymd-His') . '.csv', ['Content-Type' => 'text/csv']);
    }

    /**
     * Printable invoice / packing slip.
     */
    public function invoice(Order $order)
    {
        return view('admin.orders.invoice', compact('order'));
    }

    /**
     * Update the status of many orders at once.
     */
    public function bulkStatus(Request $request)
    {
        $data = $request->validate([
            'ids'    => 'required|array|min:1',
            'ids.*'  => 'integer',
            'status' => 'required|in:' . implode(',', Order::STATUSES),
        ]);

        $count = Order::whereIn('id', $data['ids'])->update(['status' => $data['status']]);

        return back()->with('success', "{$count} order(s) marked as {$data['status']}.");
    }

    public function show(Order $order)
    {
        $order->load(['user', 'biller']);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update the status of the order.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:' . implode(',', Order::STATUSES),
        ]);

        $oldStatus = $order->status;
        $order->update(['status' => $request->input('status')]);

        return back()->with('success', "Order #{$order->id} status updated from {$oldStatus} to {$order->status}!");
    }

    /**
     * Generate a WhatsApp confirmation link and redirect.
     */
    public function sendConfirmation(Order $order)
    {
        $companyName = setting('company_name', 'Chitranshu Pharmaceuticals Agency');
        
        $message = "Hello *{$order->customer_name}*,\n\n";
        $message .= "Your order *#{$order->id}* with *{$companyName}* has been updated!\n";
        $message .= "*Current Status:* *{$order->status}*\n\n";
        $message .= "*Order Details:*\n";
        
        $i = 1;
        {
            foreach ($order->items() as $item) {
                $subtotal = ($item['qty'] ?? 1) * ($item['price'] ?? 0);
                $packing = !empty($item['packing']) ? " ({$item['packing']})" : "";
                $unit = $item['unit'] ?? 'Box';
                $message .= "{$i}. {$item['name']}{$packing} - {$item['qty']} {$unit}(s) = ₹" . number_format($subtotal, 2) . "\n";
                $i++;
            }
        }

        $message .= "\n*Total Amount:* *₹" . number_format($order->total, 2) . "*\n";
        if (!empty($order->notes)) {
            $message .= "*Order Note:* {$order->notes}\n";
        }
        $message .= "\n";
        
        if ($order->status == 'Confirmed') {
            $message .= "We have confirmed your order and it is currently being packed. We will update you once it is dispatched.";
        } elseif ($order->status == 'Delivered') {
            $message .= "Your order has been delivered. Thank you for your business!";
        } elseif ($order->status == 'Cancelled') {
            $message .= "Your order has been cancelled. Please contact us if you have any questions.";
        } elseif ($order->status == 'Dispatched') {
            $message .= "Great news! Your order has been dispatched and is on its way to you.";
        } else {
            $message .= "Your order is currently pending review. We will contact you shortly.";
        }

        // Sanitize client phone number
        $phone = preg_replace('/[^0-9]/', '', $order->phone);
        // Prepend India country code if 10 digits
        if (strlen($phone) === 10) {
            $phone = '91' . $phone;
        }

        $url = "https://wa.me/{$phone}?text=" . rawurlencode($message);

        return redirect()->away($url);
    }
}
