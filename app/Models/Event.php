<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'title',
        'description',
        'start_datetime',
        'end_datetime',
        'allday',
    ];

    public function poll()
    {
        return $this->belongsTo(Poll::class);
    }
}
