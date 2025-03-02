<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $fillable = ['user_id', 'poll_id', 'voter_email', 'voter_name'];

    public function poll() {
        return $this->belongsTo(Poll::class);
    }

    public function voteTimeOptions() {
        return $this->hasMany(VoteTimeOption::class);
    }

    public function voteQuestionOptions() {
        return $this->hasMany(VoteQuestionOption::class);
    }
}
