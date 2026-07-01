<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'business_id', 'staff_id',
        'appointment_date', 'start_time', 'end_time',
        'status', 'notes', 'total_price',
        'coupon_code', 'discount_amount',
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'total_price'      => 'float',
        'discount_amount'  => 'float',
    ];

    // ─── Relationships ──────────────────────────────────────────────────────────

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'appointment_services')
                    ->withPivot('price', 'duration_minutes')
                    ->withTimestamps();
    }

    public function appointmentServices()
    {
        return $this->hasMany(AppointmentService::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    // ─── Scopes ─────────────────────────────────────────────────────────────────

    public function scopeUpcoming($query)
    {
        return $query->where('appointment_date', '>=', now()->toDateString())
                     ->whereIn('status', ['pending', 'confirmed']);
    }

    public function scopeForUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeForBusiness($query, int $businessId)
    {
        return $query->where('business_id', $businessId);
    }
}
