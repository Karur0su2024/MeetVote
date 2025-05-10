<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
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

    public function poll()
    {
        return $this->belongsTo(Poll::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
