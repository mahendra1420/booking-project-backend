<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payout extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id',
        'gross_amount',
        'commission_amount',
        'net_amount',
        'status',
        'transaction_ref',
        'payout_date',
        'notes',
        'processed_by',
    ];

    protected $casts = [
        'payout_date'       => 'date',
        'gross_amount'      => 'decimal:2',
        'commission_amount' => 'decimal:2',
        'net_amount'        => 'decimal:2',
    ];

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    public function processedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'processed_by');
    }
}
