<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class Vote extends Model
{
    protected $fillable = ['user_id', 'poll_id', 'voter_email', 'voter_name', 'message'];

    protected $casts = [
        'voter_email' => 'string',
        'voter_name' => 'string',
    ];

    protected static function booted(): void
    {
        static::creating(static function (Vote $vote) {
            $vote->user_id = Auth::id();
        });
    }

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
    public function timeOptions(): HasMany
    {
        return $this->hasMany(VoteTimeOption::class);
    }

    /**
     * @return HasMany<VoteQuestionOption, $this>
     */
    public function questionOptions(): HasMany
    {
        return $this->hasMany(VoteQuestionOption::class);
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
