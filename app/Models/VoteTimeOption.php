<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VoteTimeOption extends Model
{
    protected $fillable = ['vote_id', 'time_option_id', 'preference'];

    public function vote()
    {
        return $this->belongsTo(Vote::class);
    }

    public function timeOption()
    {
        return $this->belongsTo(TimeOption::class);
    }
}
