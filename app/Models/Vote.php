<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Vote extends Model
{
    protected $fillable = ['user_id', 'poll_id', 'voter_email', 'voter_name'];

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


    public function poll()
    {
        return $this->belongsTo(Poll::class);
    }

    public function timeOptions()
    {
        return $this->hasMany(VoteTimeOption::class);
    }

    public function questionOptions()
    {
        return $this->hasMany(VoteQuestionOption::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
