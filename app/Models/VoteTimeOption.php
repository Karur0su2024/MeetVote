<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VoteTimeOption extends Model
{
    protected $fillable = ['vote_id', 'time_option_id', 'preference'];

    protected $casts = [
        'preference' => 'integer',
    ];

    /**
     * @return BelongsTo<Vote, $this>
     */
    public function vote(): BelongsTo
    {
        return $this->belongsTo(Vote::class);
    }

    /**
     * @return BelongsTo<TimeOption, $this>
     */
    public function timeOption(): BelongsTo
    {
        return $this->belongsTo(TimeOption::class);
    }
}
