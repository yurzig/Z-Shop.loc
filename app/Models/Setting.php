<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
