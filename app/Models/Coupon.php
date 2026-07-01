<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id', 'code', 'type', 'value',
        'minimum_order', 'maximum_discount',
        'max_uses', 'used_count', 'status',
        'starts_at', 'expires_at',
    ];

    protected $casts = [
        'value'            => 'float',
        'minimum_order'    => 'float',
        'maximum_discount' => 'float',
        'status'           => 'boolean',
        'starts_at'        => 'datetime',
        'expires_at'       => 'datetime',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function isValid(): bool
    {
        if (! $this->status) return false;
        if ($this->max_uses && $this->used_count >= $this->max_uses) return false;
        if ($this->starts_at && now()->lt($this->starts_at)) return false;
        if ($this->expires_at && now()->gt($this->expires_at)) return false;

        return true;
    }

    public function calculateDiscount(float $amount): float
    {
        if ($amount < $this->minimum_order) return 0;

        $discount = $this->type === 'percentage'
            ? ($amount * $this->value / 100)
            : $this->value;

        if ($this->maximum_discount) {
            $discount = min($discount, $this->maximum_discount);
        }

        return round($discount, 2);
    }

    public function scopeActive($query)
    {
        return $query->where('status', true)
                     ->where(fn ($q) => $q->whereNull('expires_at')->orWhere('expires_at', '>', now()));
    }
}
