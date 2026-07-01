<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    protected $fillable = ['user_id','ticket_number','subject','description','status','priority','assigned_to','resolved_at'];
    protected $casts = ['resolved_at' => 'datetime'];

    public function user() { return $this->belongsTo(User::class); }
    public function assignedAdmin() { return $this->belongsTo(AdminUser::class, 'assigned_to'); }
    public function replies() { return $this->hasMany(TicketReply::class, 'ticket_id'); }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($ticket) {
            $ticket->ticket_number = 'TKT-' . strtoupper(substr(uniqid(), -8));
        });
    }
}
