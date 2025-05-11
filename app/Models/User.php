<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Casts\Attribute;

class User extends Authenticatable
{
    use Notifiable;


    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
        'google_token',
        'google_refresh_token',
        'calendar_access',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected static function booted(): void
    {
        static::creating(static function (User $user) {
            $user->password = $user->password ?? bcrypt(Str::random(16));
        });
    }


    // Accessor a mutator pro přístupový token
    public function googleToken(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? decrypt($value) : null,
            set: fn ($value) => $value ? encrypt($value) : null,
        );
    }

    // Accessor a mutator pro obnovovací token
    public function googleRefreshToken(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? decrypt($value) : null,
            set: fn ($value) => $value ? encrypt($value) : null,
        );
    }



    // Vztah k hlasováním (1:N)
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Vztah k hlasováním (1:N)
    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    // Vztah k anketám (1:N)
    public function polls()
    {

        return $this->hasMany(Poll::class);
    }


    public function attendeePolls()
    {
        return $this->belongsToMany(Poll::class, 'votes');
    }

    public function allPolls()
    {
        return $this->polls->merge($this->attendeePolls)->unique('id');
    }

    public function events()
    {
        return $this->votes()->with('poll.event');
    }

    public function syncedEvents()
    {
        return $this->hasMany(SyncedEvent::class);
    }



}
