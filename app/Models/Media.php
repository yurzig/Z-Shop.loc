<?php

namespace App\Models;

use App\Models\Shop\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Media
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $object
 * @property string|null $subobject
 * @property string $link
 * @property int|null $sort
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Category> $categories
 * @property-read int|null $categories_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Mediable> $mediable
 * @property-read int|null $mediable_count
 * @method static \Illuminate\Database\Eloquent\Builder|Media newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Media newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Media onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Media query()
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereObject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereSubobject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Media withoutTrashed()
 * @mixin \Eloquent
 */
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
