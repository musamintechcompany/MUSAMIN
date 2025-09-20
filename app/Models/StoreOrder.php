<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class StoreOrder extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';

    const STATUS_PENDING = 'pending';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_PROCESSING = 'processing';
    const STATUS_SHIPPED = 'shipped';
    const STATUS_DELIVERED = 'delivered';
    const STATUS_COMPLETED = 'completed';

    const PAYMENT_PENDING = 'pending';
    const PAYMENT_COMPLETED = 'completed';

    protected $fillable = [
        'user_id', 'store_id', 'order_number', 'subtotal', 'shipping_cost',
        'total_amount', 'total_coins_used', 'status', 'payment_status',
        'delivery_name', 'delivery_email', 'delivery_phone', 'delivery_address',
        'delivery_city', 'delivery_state', 'delivery_country', 'delivery_postal_code',
        'notes', 'shipped_at', 'delivered_at', 'completed_at'
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
        'completed_at' => 'datetime'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = Str::uuid();
            }
            if (empty($model->order_number)) {
                $model->order_number = 'ORD-' . strtoupper(Str::random(8));
            }
        });
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function items()
    {
        return $this->hasMany(StoreOrderItem::class, 'order_id');
    }

    public function markAsShipped()
    {
        $this->update([
            'status' => self::STATUS_SHIPPED,
            'shipped_at' => now()
        ]);
    }

    public function markAsDelivered()
    {
        $this->update([
            'status' => self::STATUS_DELIVERED,
            'delivered_at' => now()
        ]);
    }

    public function markAsCompleted()
    {
        $this->update([
            'status' => self::STATUS_COMPLETED,
            'completed_at' => now()
        ]);

        // Release pending coins to store owner
        $storeOwner = $this->store->user;
        $storeOwner->increment('earned_coins', $this->total_coins_used);
        $storeOwner->decrement('pending_earned_coins', $this->total_coins_used);
    }

    public function hasPhysicalProducts()
    {
        return $this->items()->whereHas('product', function($query) {
            $query->whereIn('type', ['physical', 'both']);
        })->exists();
    }

    public function hasDigitalProducts()
    {
        return $this->items()->whereHas('product', function($query) {
            $query->whereIn('type', ['digital', 'both']);
        })->exists();
    }
}