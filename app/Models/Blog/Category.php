<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected  $table = 'blog_categories';

    protected $fillable = [
        'parent_id',
        'title',
        'slug',
        'editor',
    ];
}
