<?php

namespace App\Models\Shop;

use App\Models\Media;
use App\Models\Text;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Shop\Category
 *
 * @property int $id
 * @property int $parent_id
 * @property string $title
 * @property string $slug
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property string|null $tmpl_title
 * @property string|null $tmpl_description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $editor
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Media> $medias
 * @property-read int|null $medias_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Text> $texts
 * @property-read int|null $texts_count
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereEditor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereTmplDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereTmplTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Category withoutTrashed()
 * @mixin \Eloquent
 */
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
    public function medias()
    {
        return $this->morphToMany(Media::class, 'mediable')->withPivot('placement');
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
