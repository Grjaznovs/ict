<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogCategoryRelation extends Model
{
    protected $table = 'blog_category_relation';

    protected $fillable = [
        'blog_id',	'category_id'
    ];
}
