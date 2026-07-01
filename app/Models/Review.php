<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'business_id', 'appointment_id',
        'rating', 'comment', 'is_approved', 'approved_at',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
        'approved_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }
}
