<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $fillable = ['state_id', 'name', 'status'];

    protected $casts = ['status' => 'boolean'];

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function businesses()
    {
        return $this->hasMany(Business::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
