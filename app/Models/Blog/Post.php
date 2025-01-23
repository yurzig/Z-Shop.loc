<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'category_id',
        'user_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'tags',
        'is_published',
        'seo_title',
        'seo_description',
        'published_at',
    ];

    protected $casts = [
        'tags' => 'json',
        'content' => 'array',
    ];

    // к посту привязываем отзывы
    public function reviews(): HasMany
    {

        return $this->hasMany(PostReview::class,'post_id', 'id');
    }

    // Добавляем в модель уникальное поле slug
    protected function slug(): Attribute
    {

        return new Attribute(
            set: fn () => posts()->setSlug($this),
        );
    }

}
