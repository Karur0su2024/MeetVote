<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    // Atributy, které lze přiřadit 
    protected $fillable = [
        'user_id', 'author_name', 'author_email', 'title', 'description', 
        'anonymous_votes', 'allow_comments', 'invite_only', 'hide_results', 'status', 
        'deadline', 'password', 'public_id', 'admin_key'];

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

    // Vztah k události (1:1)
    public function event() {
        return $this->hasOne(Event::class);
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

    public function getRouteKeyName()
    {
        return 'public_id';
    }
}
