<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    // Atributy, které lze přiřadit 
    protected $fillable = [
        'user_id', 'author_name', 'author_email', 'title', 'description', 
        'anonymous_votes', 'comments', 'invite_only', 'hide_results', 'status', 
        'deadline', 'password'];

    // Vztah k uživateli (M:1)
    public function user() {
        return $this->belongsTo(User::class);
    }

    // Vztah k časovým možnostem (1:N)
    public function timeOptions() {
        return $this->hasMany(TimeOption::class);
    }

    // Vztah k odpovědím (1:N)
    public function votes() {
        return $this->hasMany(Vote::class);
    }

    // Vztah k otázkám (1:N)
    public function questions() {
        return $this->hasMany(PollQuestion::class);
    }

    // Vztah ke komentářům (1:N)
    public function comments() {
        return $this->hasMany(Comment::class);
    }

    // Vztah k pozvánkám (1:N)
    public function invitations() {
        return $this->hasMany(Invitation::class);
    }
}
