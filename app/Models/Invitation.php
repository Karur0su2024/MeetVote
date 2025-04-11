<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Invitation extends Model
{
    protected $fillable = ['poll_id', 'email', 'status', 'key', 'sent_at'];

    protected $casts = [
        'poll_id' => 'integer',
        'email' => 'string',
        'status' => 'string',
        'key' => 'string',
        'sent_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(static function (Invitation $invitation) {
            $invitation->status = 'pending';
            $invitation->key = Str::random(40);
            $invitation->sent_at = now();
        });
    }

    public function poll()
    {
        return $this->belongsTo(Poll::class);
    }
}
