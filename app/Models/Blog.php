<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use SoftDeletes;

    protected $table = 'blog';

    protected $fillable = [
        'user_id', 'title', 'message', 'created_at'
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime:d.m.Y H:i',
        ];
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function blogCategoryRelation()
    {
        return $this->hasMany(BlogCategoryRelation::class, 'blog_id','id');
    }
}
