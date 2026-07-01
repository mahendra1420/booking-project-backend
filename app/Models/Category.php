<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id', 'name', 'slug', 'icon',
        'description', 'image', 'sort_order', 'status',
    ];

    protected $casts = ['status' => 'boolean'];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function businesses()
    {
        return $this->hasMany(Business::class);
    }
}
