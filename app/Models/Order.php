<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

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
}
