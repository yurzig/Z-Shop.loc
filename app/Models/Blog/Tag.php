<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected  $table = 'blog_tags';

    protected $fillable = [
        'title',
    ];
}
