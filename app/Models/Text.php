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

    public const ROUTES = [
        'shopCategory' => 'admin.shop.categories.edit',
    ];

    public function categories()
    {
        return $this->morphedByMany(Category::class, 'textable');
    }
    public function textable()
    {
        return $this->hasMany(Textable::class, 'text_id', 'id');
    }
}
