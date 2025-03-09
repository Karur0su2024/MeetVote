<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeOption extends Model
{
    // Později přidat celodenní možnost
    protected $fillable = ['poll_id', 'date', 'start', 'text', 'minutes'];

    public function poll()
    {
        return $this->belongsTo(Poll::class);
    }

    public function votes()
    {
        return $this->hasMany(VoteTimeOption::class);
    }
}
