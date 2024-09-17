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

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query->where(fn($query) => $query
                ->where('title', 'like', "%{$search}%")
                ->orWhere('message', 'like', "%{$search}%")
            );
        });
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function blogCategoryRelationSync()
    {
        return $this->belongsToMany(BlogCategoryRelation::class, 'blog_category_relation','blog_id', 'category_id');
    }

    public function blogCategoryRelation()
    {
        return $this->HasMany(BlogCategoryRelation::class, 'blog_id','id');
    }

    public function comment()
    {
        return $this->HasMany(Comment::class, 'blog_id','id');
    }
}
