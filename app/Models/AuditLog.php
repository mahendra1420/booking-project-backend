<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    protected $fillable = [
        'admin_user_id', 'action', 'module', 'record_id',
        'old_data', 'new_data', 'description', 'ip_address', 'user_agent',
    ];

    protected $casts = [
        'old_data' => 'array',
        'new_data' => 'array',
    ];

    public function adminUser() { return $this->belongsTo(AdminUser::class); }

    public static function log(string $action, string $module, ?int $recordId = null, ?array $oldData = null, ?array $newData = null, ?string $description = null): void
    {
        static::create([
            'admin_user_id' => auth('admin')->id(),
            'action'        => $action,
            'module'        => $module,
            'record_id'     => $recordId,
            'old_data'      => $oldData,
            'new_data'      => $newData,
            'description'   => $description,
            'ip_address'    => request()->ip(),
            'user_agent'    => request()->userAgent(),
        ]);
    }
}
