<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostReview extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'post_id',
        'user_id',
        'rating',
        'comment',
        'response',
        'status',
        'editor'
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

}
