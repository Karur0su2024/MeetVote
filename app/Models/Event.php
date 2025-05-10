<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Událost
class Event extends Model
{
    protected $fillable = [
        'poll_id',
        'title',
        'start_time',
        'end_time',
        'description',
    ];

    protected $casts = [
        'poll_id' => 'integer',
        'title' => 'string',
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
