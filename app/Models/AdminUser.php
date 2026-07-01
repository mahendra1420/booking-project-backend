<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class AdminUser extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'role_id', 'name', 'email', 'password',
        'avatar', 'phone', 'status', 'two_fa_enabled',
        'two_fa_secret', 'last_login_at', 'last_login_ip',
    ];

    protected $hidden = ['password', 'remember_token', 'two_fa_secret'];

    protected $casts = [
        'status'          => 'boolean',
        'two_fa_enabled'  => 'boolean',
        'last_login_at'   => 'datetime',
    ];

    public function role() { return $this->belongsTo(Role::class); }

    public function hasPermission(string $slug): bool
    {
        return $this->role?->permissions()->where('slug', $slug)->exists() ?? false;
    }

    public function can($abilities, $arguments = []): bool
    {
        if (is_string($abilities)) {
            return $this->hasPermission($abilities);
        }
        return parent::can($abilities, $arguments);
    }
}
