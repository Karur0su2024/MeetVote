<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VoteQuestionOption extends Model
{
    protected $fillable = ['vote_id', 'poll_question_id', 'question_option_id', 'preference'];

    public function vote()
    {
        return $this->belongsTo(Vote::class);
    }

    public function questionOption()
    {
        return $this->belongsTo(QuestionOption::class);
    }


    public function pollQuestion()
    {
        return $this->belongsTo(PollQuestion::class);
    }

}
