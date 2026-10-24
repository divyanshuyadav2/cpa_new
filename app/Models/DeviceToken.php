<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceToken extends Model
{
    use HasFactory;

    protected $fillable = [
        'tokenable_type',
        'tokenable_id',
        'token',
        'platform',
    ];

    /**
     * Get the owning tokenable model (User or Admin).
     */
    public function tokenable()
    {
        return $this->morphTo();
    }
}
