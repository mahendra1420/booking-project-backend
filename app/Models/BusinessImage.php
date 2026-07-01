<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id', 'image_path', 'alt_text', 'is_primary', 'sort_order',
    ];

    protected $casts = ['is_primary' => 'boolean'];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}
