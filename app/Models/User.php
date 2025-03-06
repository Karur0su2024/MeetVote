<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Vztah k anketám (1:N)
    public function polls() {
        return $this->hasMany(Poll::class);
    }

    // Vztah k hlasováním (1:N)
    public function comments() {
        return $this->hasMany(Comment::class);
    }

    // Vztah k hlasováním (1:N)
    public function votes() {
        return $this->hasMany(Vote::class);
    }

    public function attendeePolls(){
        return $this->belongsToMany(Poll::class, 'votes');
    }

    public function events(){
        return $this->votes()->with('poll.event');
    }
}
