<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
        'tags',
        'status',
        'seo_title',
        'seo_description',
        'published_at',
    ];

    protected $casts = [
        'tags' => 'json',
    ];

    // к посту привязываем отзывы
    public function reviews(): HasMany
    {

        return $this->hasMany(Review::class,'post_id', 'id');
    }

    // Добавляем в модель уникальное поле slug
    protected function slug(): Attribute
    {

        return new Attribute(
            set: fn () => posts()->setSlug($this),
        );
    }
    //
//    protected function tags(): Attribute
//    {
//
//        return new Attribute(
//            set: fn () => (is_array($this)) ? json_encode($this, JSON_UNESCAPED_UNICODE) : $this,
//        );
//    }

}
