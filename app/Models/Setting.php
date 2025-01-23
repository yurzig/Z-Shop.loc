<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setting extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'slug',
        'title',
        'setting_values',
        'editor',
    ];

    protected $casts = [
        'setting_values' => 'array',
    ];

}
