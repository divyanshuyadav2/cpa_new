<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'company_name',
        'address',
        'is_active',
        'salesman_id',
        'fcm_token',
        'dl_number',
        'gst_number',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function deviceTokens()
    {
        return $this->morphMany(DeviceToken::class, 'tokenable');
    }

    public function salesman()
    {
        return $this->belongsTo(User::class, 'salesman_id');
    }

    public function retailers()
    {
        return $this->hasMany(User::class, 'salesman_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function billerOrders()
    {
        return $this->hasMany(Order::class, 'biller_id');
    }

    /**
     * Orders belonging to this salesman (placed by their assigned retailers or themselves).
     */
    public function territoryOrders()
    {
        $retailerIds = $this->retailers()->pluck('id')->push($this->id);
        return Order::where(function ($q) use ($retailerIds) {
            $q->whereIn('user_id', $retailerIds)
              ->orWhere('biller_id', $this->id);
        });
    }

    /**
     * Delivery breakdown for this salesman: total, delivered, pending/remaining, cancelled.
     */
    public function getDeliveryStatsAttribute(): array
    {
        if ($this->role !== 'salesman') {
            return ['total' => 0, 'delivered' => 0, 'pending' => 0, 'cancelled' => 0];
        }

        $retailerIds = $this->retailers()->pluck('id')->push($this->id);
        $base = Order::where(function ($q) use ($retailerIds) {
            $q->whereIn('user_id', $retailerIds)
              ->orWhere('biller_id', $this->id);
        });

        $total = (clone $base)->count();
        $delivered = (clone $base)->withStatus('Delivered')->count();
        $cancelled = (clone $base)->withStatus('Cancelled')->count();
        $pending = max(0, $total - $delivered - $cancelled);

        return [
            'total'     => $total,
            'delivered' => $delivered,
            'pending'   => $pending,
            'cancelled' => $cancelled,
        ];
    }
}
