<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'poll_id',
        'title',
        'all_day',
        'start_time',
        'end_time',
        'description',
    ];

    public function poll()
    {
        return $this->belongsTo(Poll::class);
    }
}
