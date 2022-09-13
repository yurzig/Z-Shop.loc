<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Review extends Model
{
    use SoftDeletes;

    protected  $table = 'blog_reviews';

    protected $fillable = [
        'post_id',
        'user_id',
        'rating',
        'comment',
        'response',
        'status',
        'editor'
    ];
    public const STATUSES = [
        1 => 'Скрыт',
        2 => 'Опубликован',
    ];
    public const SKRIT = '1';
    public const OPUBLIKOVAN = '2';

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Преобразует дату и время создания из UTC в Europe/Moscow
     *
     * @param $value
     * @return \Carbon\Carbon|false
     */
    public function getCreatedAtAttribute($value) {
        return Carbon::createFromFormat('Y-m-d H:i:s', $value)->timezone('Europe/Moscow');
    }

    /**
     * Преобразует дату и время обновления из UTC в Europe/Moscow
     *
     * @param $value
     * @return \Carbon\Carbon|false
     */
    public function getUpdatedAtAttribute($value) {
        return Carbon::createFromFormat('Y-m-d H:i:s', $value)->timezone('Europe/Moscow');
    }

}
