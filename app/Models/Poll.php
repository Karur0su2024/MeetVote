<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Enums\PollStatus;

/**
 *
 */
class Poll extends Model
{

    use SoftDeletes;
    use HasFactory;

    // Atributy, které lze přiřadit
    protected $fillable = [
        'user_id', 'author_name', 'author_email', 'title', 'description',
        'status', 'deadline', 'password', 'public_id', 'admin_key',
        'timezone', 'settings',

    ];

    protected $attributes = [
        'deadline' => null,
        'description' => null,
        'status' => PollStatus::ACTIVE,
        'timezone' => 'UTC',
    ];

    protected $hidden = [
        'admin_key',
        'password',
    ];

    protected $casts = [
        'status' => PollStatus::class,
        'updated_at' => 'string',
        'settings' => 'array',
    ];




    protected static function booted(): void
    {
        static::creating(static function (Poll $poll) {
            $poll->public_id = Str::random(40);
            $poll->admin_key = Str::random(40);
            $poll->user_id = Auth::id();
        });
    }


    public function settings(): Attribute
    {
        return Attribute::make(
            get: fn() => json_decode($this->attributes['settings'] ?? '{}', true),
            set: fn($array) => json_encode($array, JSON_THROW_ON_ERROR),
        );
    }


    /**
     * Vztah k uživateli (M:1)
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function timeOptions()
    {
        return $this->hasMany(TimeOption::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function event()
    {
        return $this->hasOne(Event::class);
    }

    public function questions()
    {
        return $this->hasMany(PollQuestion::class);
    }

    public function pollComments()
    {
        return $this->hasMany(Comment::class);
    }

    public function invitations()
    {
        return $this->hasMany(Invitation::class);
    }

    public function getRouteKeyName()
    {
        return 'public_id';
    }

    public function isActive(): bool
    {
        if($this->deadline && $this->deadline <= today()) {
            return false;
        }
        return $this->status === PollStatus::ACTIVE;
    }

}
