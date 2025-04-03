<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionOption extends Model
{
    protected $fillable = ['poll_question_id', 'text'];

    protected $casts = [
        'text' => 'string',
    ];

    public function pollQuestion()
    {
        return $this->belongsTo(PollQuestion::class);
    }

    public function votes()
    {
        return $this->hasMany(VoteQuestionOption::class);
    }
}
