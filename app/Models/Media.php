<?php

namespace App\Models;

use App\Models\Shop\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Media extends Model
{
    use SoftDeletes;

    protected  $table = 'medias';

    protected $fillable = [
        'title',
        'link',
        'object',
        'subobject',
        'sort',
    ];
    public const OBJECTS = [
        'category' => 'категория',
        'product' => 'товар',
        'text' => 'блог',
    ];
    public function categories()
    {
        return $this->morphedByMany(Category::class, 'mediable');
    }
    public function mediable()
    {
        return $this->hasMany(Mediable::class, 'media_id', 'id');
    }
}
