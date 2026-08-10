<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

// Komentář
class Comment extends Model
{
    use SoftDeletes;

    protected $fillable = ['poll_id', 'user_id', 'author_name', 'content'];

    protected $casts = [
        'poll_id' => 'integer',
        'user_id' => 'integer',
        'author_name' => 'string',
        'content' => 'string',
    ];

    /**
     * @return BelongsTo<Poll, $this>
     */
    public function poll(): BelongsTo
    {
        return $this->belongsTo(Poll::class);
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
