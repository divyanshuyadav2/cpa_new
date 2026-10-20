<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Order extends Model
{
    use HasFactory;

    public const STATUSES = ['Pending', 'Confirmed', 'Dispatched', 'Delivered', 'Cancelled'];

    protected $fillable = [
        'user_id',
        'biller_id',
        'customer_name',
        'phone',
        'total',
        'status',
        'billing_status',
        'invoice_no',
        'billing_notes',
        'cart',
        'notes',
    ];

    protected $casts = [
        'cart' => 'array',
        'total' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function biller()
    {
        return $this->belongsTo(User::class, 'biller_id');
    }

    /**
     * Search by order id, customer name, phone or invoice number.
     */
    public function scopeSearch($query, ?string $term)
    {
        $term = trim((string) $term);
        if ($term === '') {
            return $query;
        }

        return $query->where(function ($q) use ($term) {
            $q->where('id', ltrim($term, '#'))
              ->orWhere('customer_name', 'like', "%{$term}%")
              ->orWhere('phone', 'like', "%{$term}%");

            if (Schema::hasColumn('orders', 'invoice_no')) {
                $q->orWhere('invoice_no', 'like', "%{$term}%");
            }
        });
    }

    /**
     * Cart line items without the internal _order_notes entry.
     */
    public function items(): array
    {
        return collect(is_array($this->cart) ? $this->cart : [])
            ->filter(fn ($item, $key) => $key !== '_order_notes' && is_array($item))
            ->values()
            ->all();
    }
}
