<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;

    protected $table = 'comment';

    protected $fillable = [
        'blog_id', 'user_id', 'message'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
