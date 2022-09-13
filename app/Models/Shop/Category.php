<?php

namespace App\Models\Shop;

use App\Models\Media;
use App\Models\Text;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected  $table = 'shop_categories';

    protected $fillable = [
        'parent_id',
        'title',
        'slug',
        'meta_title',
        'meta_description',
        'tmpl_title',
        'tmpl_description',
        'edit',
    ];
    public function texts()
    {
        return $this->morphToMany(Text::class, 'textable');
    }
    /**
     * Получить родительскую категорию
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
//    public function parentCategory()
//    {
//        return $this->belongsTo(Category::class, 'parent_id', 'id');
//    }

//    public function categoriesSecondLevel()
//    {
//        return $this->hasMany(Category::class, 'parent_id', 'id');
//    }
//    public function product()
//    {
//        return $this->hasMany(Product::class);
//    }
//    public function secondLevel()
//    {
//        return $this->hasMany(Category::class, 'parent_id', 'id')
//                    ->with('product');
//    }
//    public function children()
//    {
//        return $this->hasMany(Category::class, 'parent_id', 'id')
//                    ->with('media');
//    }
//    public function media()
//    {
//        return $this->hasMany(Media::class, 'ref_id')
//            ->where('object', 'category')
//            ->where('placement', 'first');
//    }

}
