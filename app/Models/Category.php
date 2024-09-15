<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $table = 'c_category';

    protected $fillable = [
        'name', 'code', 'order'
    ];

    protected function casts(): array
    {
        return [
            'order' => 'int'
        ];
    }
}
