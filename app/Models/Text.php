<?php

namespace App\Models;

use App\Models\Shop\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Text
 *
 * @property int $id
 * @property string|null $title
 * @property string $content
 * @property int $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $editor
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Category> $categories
 * @property-read int|null $categories_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Textable> $textable
 * @property-read int|null $textable_count
 * @method static \Illuminate\Database\Eloquent\Builder|Text newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Text newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Text onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Text query()
 * @method static \Illuminate\Database\Eloquent\Builder|Text whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Text whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Text whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Text whereEditor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Text whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Text whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Text whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Text whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Text withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Text withoutTrashed()
 * @mixin \Eloquent
 */
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
