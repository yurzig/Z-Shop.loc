<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
