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
        'placement',
        'status',
        'editor',
    ];
    public function categories()
    {
        return $this->morphedByMany(Category::class, 'mediable');
    }
}
