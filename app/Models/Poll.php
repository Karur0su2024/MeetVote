<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    protected $fillable = ['user_id', 'title', 'description', 'allow_anonymous_votes', 'allow_comments', 'invite_only', 'hide_results', 'status', 'deadline'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function timeOptions() {
        return $this->hasMany(TimeOption::class);
    }

    public function votes() {
        return $this->hasMany(Vote::class);
    }

    public function questions() {
        return $this->hasMany(PollQuestion::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function invitations() {
        return $this->hasMany(Invitation::class);
    }
}
