<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Setting
 *
 * @property int $id
 * @property string $slug
 * @property string $description
 * @property array|null $setting
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $editor
 * @method static \Illuminate\Database\Eloquent\Builder|Setting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting query()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereEditor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereSetting($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting withoutTrashed()
 * @mixin \Eloquent
 */
class Setting extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'slug',
        'description',
        'setting',
        'editor',
    ];

    protected $casts = [
        'setting' => 'array'
    ];

    public function setSettingAttribute($value)
    {
        $settings = [];
        foreach ($value as $array_item) {
            if(!is_null($array_item['key'])) {
                $settings[] = $array_item;
            }
        }
        $this->attributes['setting'] = json_encode($settings);
    }
}
