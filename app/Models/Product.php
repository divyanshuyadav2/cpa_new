<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'company_id',
        'division_id',
        'salt_id',
        'composition',
        'packing',
        'mrp',
        'ptr',
        'pts',
        'stock_qty',
        'image',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'mrp' => 'decimal:2',
        'ptr' => 'decimal:2',
        'pts' => 'decimal:2',
        'stock_qty' => 'integer',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function salt()
    {
        return $this->belongsTo(Salt::class);
    }
}
