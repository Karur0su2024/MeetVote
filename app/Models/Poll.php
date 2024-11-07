<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    /** @use HasFactory<\Database\Factories\PollFactory> */
    use HasFactory;

    protected $fillable = [
        'title', 
        'description', 
        'username', 
        'user_id', 
        'email', 
        'deadline', 
        'status', 
        'comments',
        'poll_settings',
        'admin_key',
        'password',
        'anonymous_voting'
    ];

    protected $attributes = [
        'anonymous_voting' => false,
        'comments' => false,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function userAnswers()
    {
        return $this->hasMany(UserAnswer::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function invitations()
    {
        return $this->hasMany(Invitation::class);
    }

    public function normalQuestions()
    {
        return $this->questions()->where('question_type', 'normal')->get();
    }
    
    public function timeOptions()
    {
        return $this->hasManyThrough(Option::class, Question::class)->where('question_type', 'time');
    }
    



}
