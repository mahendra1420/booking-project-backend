<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    protected $table = 'staff';

    protected $fillable = [
        'business_id', 'name', 'email', 'phone',
        'avatar', 'specialization', 'bio', 'status',
    ];

    protected $casts = ['status' => 'boolean'];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function workingHours()
    {
        return $this->hasMany(WorkingHour::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }
}
