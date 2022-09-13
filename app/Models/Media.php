<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Media extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'link',
        'placement',
        'status',
        'editor',
    ];
    public const PLACEMENT = [
        '1' => 'Первая картинка',
        '2' => 'Вторая картинка',
        '3' => 'Галерея',
    ];
}
