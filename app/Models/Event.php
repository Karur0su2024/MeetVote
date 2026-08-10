<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    /**
     * @return BelongsTo<Poll, $this>
     */
    public function poll(): BelongsTo
    {
        return $this->belongsTo(Poll::class);
    }

    /**
     * @return HasMany<SyncedEvent, $this>
     */
    public function syncedEvents(): HasMany
    {
        return $this->hasMany(SyncedEvent::class);
    }
}
