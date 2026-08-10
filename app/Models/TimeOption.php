<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TimeOption extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = ['poll_id', 'date', 'start', 'end', 'text'];

    protected $casts = [
        'text' => 'string',
    ];

    /**
     * @return BelongsTo<Poll, $this>
     */
    public function poll(): BelongsTo
    {
        return $this->belongsTo(Poll::class);
    }

    /**
     * @return HasMany<VoteTimeOption, $this>
     */
    public function votes(): HasMany
    {
        return $this->hasMany(VoteTimeOption::class);
    }
}
