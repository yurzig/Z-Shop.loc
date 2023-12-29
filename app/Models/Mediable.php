<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Mediable
 *
 * @property int $id
 * @property int $media_id
 * @property string $mediable_type
 * @property int $mediable_id
 * @property int $placement
 * @method static \Illuminate\Database\Eloquent\Builder|Mediable newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Mediable newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Mediable query()
 * @method static \Illuminate\Database\Eloquent\Builder|Mediable whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mediable whereMediaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mediable whereMediableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mediable whereMediableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mediable wherePlacement($value)
 * @mixin \Eloquent
 */
class Mediable extends Model
{
    protected $fillable = [
        'placement',
    ];

}
