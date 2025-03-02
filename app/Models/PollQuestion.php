<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PollQuestion extends Model
{
    protected $fillable = ['poll_id', 'question_text'];

    public function poll() {
        return $this->belongsTo(Poll::class);
    }

    public function options() {
        return $this->hasMany(QuestionOption::class);
    }
}
