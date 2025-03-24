<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use phpseclib3\File\ASN1\Maps\Attribute;

/**
 *
 */
class Poll extends Model
{

    use SoftDeletes;

    // Atributy, které lze přiřadit
    protected $fillable = [
        'user_id', 'author_name', 'author_email', 'title', 'description',
        'anonymous_votes', 'comments', 'invite_only', 'hide_results', 'status',
        'deadline', 'password', 'public_id', 'admin_key',
        'edit_votes', 'add_time_options'

    ];

    protected $attributes = [
        'deadline' => null,
        'description' => null,
        'status' => 'active'
    ];

    protected $indexed = [
        'public_id',
        'admin_key',
        'user_id',
        'status',
    ];


    protected static function booted(): void
    {
        static::creating(static function (Poll $poll) {
            $poll->public_id = Str::random(40);
            $poll->admin_key = Str::random(40);
            $poll->user_id = Auth::id();
        });
    }


    /**
     * Vztah k uživateli (M:1)
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Vztah k časovým možnostem (1:N)
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function timeOptions()
    {
        return $this->hasMany(TimeOption::class);
    }

    /**
     * Vztah k odpovědím (1:N)
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    /**
     * Vztah k události (1:1)
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function event()
    {
        return $this->hasOne(Event::class);
    }


    /**
     * Vztah k otázkám (1:N)
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questions()
    {
        return $this->hasMany(PollQuestion::class);
    }

    /**
     * Vztah ke komentářům (1:N)
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }



    /**
     * // Vztah k pozvánkám (1:N)
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invitations()
    {
        return $this->hasMany(Invitation::class);
    }

    /**
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'public_id';
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->status === 'active' && ($this->deadline > now() || $this->deadline === null);
    }

}
