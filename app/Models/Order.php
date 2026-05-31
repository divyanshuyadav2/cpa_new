<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'phone',
        'total',
        'status',
        'cart',
    ];

    protected $casts = [
        'cart' => 'array',
        'total' => 'decimal:2',
    ];
}
