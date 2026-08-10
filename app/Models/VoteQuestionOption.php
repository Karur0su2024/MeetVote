<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VoteQuestionOption extends Model
{
    protected $fillable = ['vote_id', 'poll_question_id', 'question_option_id', 'preference'];

    /**
     * @return BelongsTo<Vote, $this>
     */
    public function vote(): BelongsTo
    {
        return $this->belongsTo(Vote::class);
    }

    /**
     * @return BelongsTo<QuestionOption, $this>
     */
    public function questionOption(): BelongsTo
    {
        return $this->belongsTo(QuestionOption::class);
    }

    /**
     * @return BelongsTo<PollQuestion, $this>
     */
    public function pollQuestion(): BelongsTo
    {
        return $this->belongsTo(PollQuestion::class);
    }
}
