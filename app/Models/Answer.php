<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    /** @use HasFactory<\Database\Factories\AnswerFactory> */
    use HasFactory;

    protected $fillable = [
        'user_answer_id', 
        'preference_id', 
        'question_id', 
        'option_id',
        'open_answer'
    ];

    public function userAnswer()
    {
        return $this->belongsTo(UserAnswer::class);
    }

    public function option()
    {
        return $this->belongsTo(Option::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function preference()
    {
        return $this->belongsTo(Preference::class);
    }
}
