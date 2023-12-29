<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Textable
 *
 * @property int $id
 * @property int $text_id
 * @property string $textable_type
 * @property int $textable_id
 * @method static \Illuminate\Database\Eloquent\Builder|Textable newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Textable newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Textable query()
 * @method static \Illuminate\Database\Eloquent\Builder|Textable whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Textable whereTextId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Textable whereTextableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Textable whereTextableType($value)
 * @mixin \Eloquent
 */
class Textable extends Model
{
    protected $fillable = [
        'text_id',
        'textable_type',
        'textable_id',
    ];

//    public function text()
//    {
//        return $this->hasOne(Text::class, 'id', 'textable_id');
//    }
//    public function textable()
//    {
//        return $this->morphTo();
//    }

}
