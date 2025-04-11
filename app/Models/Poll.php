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
        'anonymous_votes', 'comments', 'invite_only', 'hide_results', 'status',
        'deadline', 'password', 'public_id', 'admin_key',
        'edit_votes', 'add_time_options', 'settings',

    ];

    protected $attributes = [
        'deadline' => null,
        'description' => null,
        'status' => PollStatus::ACTIVE,
    ];

    protected $hidden = [
        'admin_key',
        'password',
    ];

    protected $casts = [
        'anonymous_votes' => 'boolean',
        'comments' => 'boolean',
        'invite_only' => 'boolean',
        'hide_results' => 'boolean',
        'edit_votes' => 'boolean',
        'add_time_options' => 'boolean',
        'status' => PollStatus::class,
        'updated_at' => 'string',
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
            get: fn() => [
                'anonymous_votes' => $this->getAttribute('anonymous_votes') ?? false,
                'comments' => $this->getAttribute('comments') ?? false,
                'invite_only' => $this->getAttribute('invite_only') ?? false,
                'hide_results' => $this->getAttribute('hide_results') ?? false,
                'edit_votes' => $this->getAttribute('edit_votes') ?? false,
                'add_time_options' => $this->getAttribute('add_time_options') ?? false,
            ],
            set: fn($array) => [
                'anonymous_votes' => $array['anonymous_votes'] ?? false,
                'comments' => $array['comments'] ?? false,
                'invite_only' => $array['invite_only'] ?? false,
                'hide_results' => $array['hide_results'] ?? false,
                'edit_votes' => $array['edit_votes'] ?? false,
                'add_time_options' => $array['add_time_options'] ?? false,
            ],
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
