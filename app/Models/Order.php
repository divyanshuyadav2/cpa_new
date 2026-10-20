<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Order extends Model
{
    use HasFactory;

    public const STATUSES = ['Pending', 'Confirmed', 'Dispatched', 'Delivered', 'Cancelled'];

    /**
     * Web, PWA and the admin/biller API historically stored different words for
     * the same stage. Every alias (lowercase) maps to one canonical status.
     */
    public const STATUS_ALIASES = [
        'Pending'    => ['pending'],
        'Confirmed'  => ['confirmed', 'approved', 'processing'],
        'Dispatched' => ['dispatched'],
        'Delivered'  => ['delivered', 'completed'],
        'Cancelled'  => ['cancelled', 'canceled'],
    ];

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

    public static function canonicalStatus(?string $status): string
    {
        $key = strtolower(trim((string) $status));
        foreach (self::STATUS_ALIASES as $canonical => $aliases) {
            if (in_array($key, $aliases, true)) {
                return $canonical;
            }
        }

        return 'Pending';
    }

    /**
     * Canonical status for display (does not change the stored value).
     */
    public function getStatusLabelAttribute(): string
    {
        return self::canonicalStatus($this->attributes['status'] ?? null);
    }

    public function scopeWithStatus($query, string $canonical)
    {
        return $query->whereIn('status', self::STATUS_ALIASES[$canonical] ?? [strtolower($canonical)]);
    }

    public function scopeNotCancelled($query)
    {
        return $query->whereNotIn('status', self::STATUS_ALIASES['Cancelled']);
    }

    /**
     * Order counts per canonical status, e.g. ['Pending' => 3, ...].
     */
    public static function statusCounts(): \Illuminate\Support\Collection
    {
        $counts = collect(self::STATUSES)->mapWithKeys(fn ($s) => [$s => 0]);
        foreach (static::selectRaw('status, count(*) as c')->groupBy('status')->pluck('c', 'status') as $status => $c) {
            $key = self::canonicalStatus($status);
            $counts[$key] = $counts[$key] + $c;
        }

        return $counts;
    }
}
