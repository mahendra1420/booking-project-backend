<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id', 'name', 'description',
        'price', 'duration_minutes', 'image', 'status',
    ];

    protected $casts = [
        'price'  => 'float',
        'status' => 'boolean',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function appointmentServices()
    {
        return $this->hasMany(AppointmentService::class);
    }

    public function appointments()
    {
        return $this->belongsToMany(Appointment::class, 'appointment_services')
                    ->withPivot('price', 'duration_minutes')
                    ->withTimestamps();
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }
}
