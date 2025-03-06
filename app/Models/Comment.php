<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;

    protected $fillable = ['poll_id', 'user_id', 'author_name', 'content'];

    public function poll() {
        return $this->belongsTo(Poll::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    protected $dates = ['deleted_at'];
}
