<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    protected  $table = 'blog_posts';

    protected $fillable = [
        'category_id',
        'user_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'status',
        'seo_title',
        'seo_description',
        'published_at',
    ];

    public const STATUS = [
        1 => 'черновик',
        2 => 'опубликована',
    ];


}
