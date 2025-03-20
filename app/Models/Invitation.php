<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    public function poll()
    {
        return $this->belongsTo(Poll::class);
    }
}
