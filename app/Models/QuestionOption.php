<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuestionOption extends Model
{
    protected $fillable = ['poll_question_id', 'text'];

    protected $casts = [
        'text' => 'string',
    ];

    /**
     * @return BelongsTo<PollQuestion, $this>
     */
    public function pollQuestion(): BelongsTo
    {
        return $this->belongsTo(PollQuestion::class);
    }

    /**
     * @return HasMany<VoteQuestionOption, $this>
     */
    public function votes(): HasMany
    {
        return $this->hasMany(VoteQuestionOption::class);
    }
}
