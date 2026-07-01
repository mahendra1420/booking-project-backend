<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id', 'category_id', 'city_id', 'name', 'slug',
        'description', 'address', 'latitude', 'longitude',
        'phone', 'email', 'website', 'logo',
        'average_rating', 'total_reviews', 'status',
    ];

    protected $casts = [
        'latitude'       => 'float',
        'longitude'      => 'float',
        'average_rating' => 'float',
    ];

    // ─── Relationships ──────────────────────────────────────────────────────────

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function staff()
    {
        return $this->hasMany(Staff::class);
    }

    public function workingHours()
    {
        return $this->hasMany(WorkingHour::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function images()
    {
        return $this->hasMany(BusinessImage::class);
    }

    public function primaryImage()
    {
        return $this->hasOne(BusinessImage::class)->where('is_primary', true);
    }

    public function coupons()
    {
        return $this->hasMany(Coupon::class);
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }

    // ─── Scopes ─────────────────────────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByCategory($query, int $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeByCity($query, int $cityId)
    {
        return $query->where('city_id', $cityId);
    }
}
