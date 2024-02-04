<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\Blog\Review
 *
 * @property int $id
 * @property int $post_id
 * @property int $user_id
 * @property string $name
 * @property string $email
 * @property int $rating
 * @property string $comment
 * @property string $response
 * @property int $status
 * @property \Carbon\Carbon|false $created_at
 * @property \Carbon\Carbon|false $updated_at
 * @property Carbon|null $deleted_at
 * @property int $editor
 * @property-read \App\Models\Blog\Post $post
 * @method static \Illuminate\Database\Eloquent\Builder|Review newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Review newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Review onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Review query()
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereEditor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereResponse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Review withoutTrashed()
 * @mixin \Eloquent
 */
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
     */
    public function getCreatedAtAttribute($value): string
    {
        if($value) {
            return Carbon::createFromFormat('Y-m-d H:i:s', $value)->timezone('Europe/Moscow');
        }

        return '';
    }

    /**
     * Преобразует дату и время обновления из UTC в Europe/Moscow
     */
    public function getUpdatedAtAttribute($value): string
    {
        if($value) {

            return Carbon::createFromFormat('Y-m-d H:i:s', $value)->timezone('Europe/Moscow');
        }

        return '';
    }

}
