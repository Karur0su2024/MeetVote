<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    protected $fillable = ['poll_id', 'email', 'status', 'key', 'sent_at'];

    public function poll()
    {
        return $this->belongsTo(Poll::class);
    }
}
