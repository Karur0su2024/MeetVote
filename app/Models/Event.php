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

    protected $casts = [
        'poll_id' => 'integer',
        'title' => 'string',
        'all_day' => 'boolean',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'description' => 'string',
    ];

    public function poll()
    {
        return $this->belongsTo(Poll::class);
    }

    public function syncedEvents()
    {
        return $this->hasMany(SyncedEvent::class);
    }
}
