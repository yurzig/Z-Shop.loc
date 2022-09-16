<?php

namespace App\Models;

use App\Models\Shop\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Text extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'content',
        'type',
        'editor',
    ];

    public const TYPES = [
        '1' => 'Основной текст',
        '2' => 'Аннотация',
        '3' => 'Реклама',
    ];

    public function categories()
    {
        return $this->morphedByMany(Category::class, 'textable');
    }
    public function textable()
    {
        return $this->morphedByMany(Textable::class, 'textable');
//        return $this->morphToMany(Text::class, 'textable');
//        return $this->morphTo();
    }
}
