<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['poll_id', 'final_datetime', 'allday', 'description', 'duration'];

    public function poll() {
        return $this->belongsTo(Poll::class);
    }
}
