<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Casts\Attribute;
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

    // Добавляем в модель уникальное поле slug
    protected function slug(): Attribute
    {

        return new Attribute(
            set: fn () => postCategories()->setSlug($this),
        );
    }

}
