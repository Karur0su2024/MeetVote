<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeOption extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = ['poll_id', 'date', 'start', 'end', 'text'];

    protected $casts = [
        'text' => 'string',
    ];


    public function poll()
    {
        return $this->belongsTo(Poll::class);
    }

    public function votes()
    {
        return $this->hasMany(VoteTimeOption::class);
    }

}
