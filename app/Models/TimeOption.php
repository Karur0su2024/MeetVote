<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeOption extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = ['poll_id', 'date', 'start', 'end', 'text'];


    /**
     * Anketa, ke které tato časová možnost patří
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function poll()
    {
        return $this->belongsTo(Poll::class);
    }

    /**
     * Hlasy k této časové možnosti
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function votes()
    {
        return $this->hasMany(VoteTimeOption::class);
    }
}
