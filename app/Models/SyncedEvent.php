<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SyncedEvent extends Model
{

    protected $primaryKey = 'id';

    protected $fillable = [
        'calendar_event_id',
        'user_id',
        'event_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
