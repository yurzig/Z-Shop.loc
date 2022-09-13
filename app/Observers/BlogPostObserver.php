<?php

namespace App\Observers;

use App\Models\Blog\Post;
use App\Repositories\Blog\PostRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BlogPostObserver
{
    /**
     * @param Post $Post
     */
    public function creating(Post $post)
    {
        $post->user_id ?? Auth::id();
        $this->setSlug($post);
    }
    /**
     * Если поле слаг пустое, то заполняем его конвертацией заголовка
     *
     * @param Post $model
     */
    protected function setSlug(Post $post)
    {
        if (empty($post->slug)) {
            $slug = Str::slug($post->title);
            $post->slug = $slug;

            $i = 0;
            while (app(PostRepository::class)->getBySlug($post->slug)->count() > 0) {
                $post->slug = $slug . '_' . ++$i;
            }
        }
    }

    /**
     * Handle the Post "created" event.
     *
     * @param  \App\Models\Blog\Post  $post
     * @return void
     */
    public function created(Post $post)
    {
        //
    }
    /**
     * @param  \App\Models\Blog\Post  $post
     * @return void
     */
    public function updating(Post $post)
    {
        $post->user_id ?? Auth::id();
        $this->setSlug($post);
    }
    /**
     * Handle the Post "updated" event.
     *
     * @param  \App\Models\Blog\Post  $post
     * @return void
     */
    public function updated(Post $post)
    {
        //
    }

    /**
     * Handle the Post "deleted" event.
     *
     * @param  \App\Models\Blog\Post  $post
     * @return void
     */
    public function deleted(Post $post)
    {
        //
    }

    /**
     * Handle the Post "restored" event.
     *
     * @param  \App\Models\Blog\Post  $post
     * @return void
     */
    public function restored(Post $post)
    {
        //
    }

    /**
     * Handle the Post "force deleted" event.
     *
     * @param  \App\Models\Blog\Post  $post
     * @return void
     */
    public function forceDeleted(Post $post)
    {
        //
    }
}
