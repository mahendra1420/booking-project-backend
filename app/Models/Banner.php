<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = ['title','image','redirect_link','redirect_type','redirect_id','start_date','end_date','sort_order','status'];
    protected $casts = ['status' => 'boolean', 'start_date' => 'date', 'end_date' => 'date'];

    public function scopeActive($q) { return $q->where('status', true)->where(fn($q) => $q->whereNull('end_date')->orWhere('end_date', '>=', now()->toDateString())); }
}
