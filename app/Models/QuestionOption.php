<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionOption extends Model
{
    protected $fillable = ['poll_question_id', 'option_text'];
    
    public function question() {
        return $this->belongsTo(PollQuestion::class);
    }

    public function votes() {
        return $this->hasMany(VoteQuestionOption::class);
    }
}
