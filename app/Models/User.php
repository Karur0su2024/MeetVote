<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

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

    /**
     * @return HasMany<Comment, $this>
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    // Vztah k hlasováním (1:N)

    /**
     * @return HasMany<Vote, $this>
     */
    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }

    // Vztah k anketám (1:N)

    /**
     * @return HasMany<Poll, $this>
     */
    public function polls(): HasMany
    {

        return $this->hasMany(Poll::class);
    }

    /**
     * @return BelongsToMany<Poll, $this>
     */
    public function attendeePolls(): BelongsToMany
    {
        return $this->belongsToMany(Poll::class, 'votes');
    }

    public function allPolls()
    {
        return $this->polls->merge($this->attendeePolls)->unique('id');
    }

    /**
     * @return HasMany<Event, $this>
     */
    public function events(): HasMany
    {
        return $this->votes()->with('poll.event');
    }

    /**
     * @return HasMany<SyncedEvent, $this>
     */
    public function syncedEvents(): HasMany
    {
        return $this->hasMany(SyncedEvent::class);
    }
}
