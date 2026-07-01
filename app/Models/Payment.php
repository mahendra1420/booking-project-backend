<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_id', 'user_id', 'amount',
        'method', 'status', 'transaction_id',
        'payment_data', 'paid_at',
    ];

    protected $casts = [
        'amount'       => 'float',
        'payment_data' => 'array',
        'paid_at'      => 'datetime',
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isPaid(): bool
    {
        return $this->status === 'paid';
    }
}
