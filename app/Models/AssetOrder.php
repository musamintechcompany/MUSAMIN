<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Hashids\Hashids;

class AssetOrder extends Model
{
    use HasFactory;

    const ORDER_TYPE_PURCHASE = 'purchase';
    const ORDER_TYPE_RENTAL = 'rental';

    const STATUS_PENDING = 'pending';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_REFUNDED = 'refunded';

    const RENTAL_PERIOD_DAILY = 'daily';
    const RENTAL_PERIOD_WEEKLY = 'weekly';
    const RENTAL_PERIOD_MONTHLY = 'monthly';
    const RENTAL_PERIOD_YEARLY = 'yearly';

    const PURCHASE_TYPE_SOURCE = 'source';
    const PURCHASE_TYPE_HOSTING = 'hosting';
    const PURCHASE_TYPE_ENTERPRISE = 'enterprise';
    const PURCHASE_TYPE_WHITELABEL = 'whitelabel';

    protected $fillable = [
        'user_id',
        'asset_id',
        'order_type',
        'amount_paid',
        'coins_used',
        'platform_share',
        'user_share',
        'system_managed_at_purchase',
        'rental_period',
        'rental_duration',
        'rental_starts_at',
        'rental_expires_at',
        'purchase_type',
        'status',
        'payment_method',
        'transaction_id',
        'hashid',
    ];

    protected $casts = [
        'amount_paid' => 'decimal:2',
        'platform_share' => 'decimal:2',
        'user_share' => 'decimal:2',
        'system_managed_at_purchase' => 'boolean',
        'rental_starts_at' => 'datetime',
        'rental_expires_at' => 'datetime',
    ];

    protected $keyType = 'string';
    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = Str::uuid();
            }

            if (empty($model->hashid)) {
                $model->hashid = $model->generateHashid();
            }
        });

        static::created(function ($model) {
            if ($model->status === self::STATUS_COMPLETED) {
                // Increment downloads count on asset
                $model->asset?->increment('downloads_count');
            }
        });

        static::updated(function ($model) {
            if ($model->wasChanged('status') && $model->status === self::STATUS_COMPLETED) {
                // Increment downloads count on asset
                $model->asset?->increment('downloads_count');
            }
        });
    }

    public function generateHashid(): string
    {
        $hashids = new Hashids(
            config('hashids.connections.main.salt'),
            config('hashids.connections.main.length'),
            config('hashids.connections.main.alphabet')
        );

        $numericId = crc32($this->id);
        return $hashids->encode($numericId);
    }

    public static function findByHashid(string $hashid): ?AssetOrder
    {
        return static::where('hashid', $hashid)->first();
    }

    public function getRouteKeyName(): string
    {
        return 'hashid';
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function asset()
    {
        return $this->belongsTo(DigitalAsset::class, 'asset_id');
    }

    // Scopes
    public function scopePurchases($query)
    {
        return $query->where('order_type', self::ORDER_TYPE_PURCHASE);
    }

    public function scopeRentals($query)
    {
        return $query->where('order_type', self::ORDER_TYPE_RENTAL);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', self::STATUS_COMPLETED);
    }

    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeActiveRentals($query)
    {
        return $query->rentals()
                    ->completed()
                    ->where('rental_expires_at', '>', now());
    }

    public function scopeExpiredRentals($query)
    {
        return $query->rentals()
                    ->completed()
                    ->where('rental_expires_at', '<=', now());
    }

    // Methods
    public function isPurchase(): bool
    {
        return $this->order_type === self::ORDER_TYPE_PURCHASE;
    }

    public function isRental(): bool
    {
        return $this->order_type === self::ORDER_TYPE_RENTAL;
    }

    public function isCompleted(): bool
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isActive(): bool
    {
        if ($this->isPurchase()) {
            return $this->isCompleted();
        }

        if ($this->isRental()) {
            return $this->isCompleted() && 
                   $this->rental_expires_at && 
                   $this->rental_expires_at->isFuture();
        }

        return false;
    }

    public function isExpired(): bool
    {
        if ($this->isRental()) {
            return $this->isCompleted() && 
                   $this->rental_expires_at && 
                   $this->rental_expires_at->isPast();
        }

        return false;
    }

    public function complete()
    {
        $this->update(['status' => self::STATUS_COMPLETED]);
    }

    public function cancel()
    {
        $this->update(['status' => self::STATUS_CANCELLED]);
    }

    public function refund()
    {
        $this->update(['status' => self::STATUS_REFUNDED]);
    }
}