<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkingHour extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id', 'staff_id', 'day_of_week',
        'open_time', 'close_time', 'is_closed',
    ];

    protected $casts = ['is_closed' => 'boolean'];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }
}
