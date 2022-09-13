<?php

namespace App\Observers;

use App\Models\Blog\Category;
use App\Repositories\Blog\CategoryRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BlogCategoryObserver
{
    /**
     * @param Category $Category
     */
    public function creating(Category $category)
    {
        $category->editor = Auth::id();
        $this->setSlug($category);
    }
    /**
     * Если поле слаг пустое, то заполняем его конвертацией заголовка
     *
     * @param Category $model
     */
    protected function setSlug(Category $category)
    {
        if (empty($category->slug)) {
            $slug = Str::slug($category->title);
            $category->slug = $slug;

            $i = 0;
            while (app(CategoryRepository::class)->getBySlug($category->slug)->count() > 0) {
                $category->slug = $slug . '_' . ++$i;
            }
        }
    }

    /**
     * Handle the Category "created" event.
     *
     * @param  \App\Models\Blog\Category  $category
     * @return void
     */
    public function created(Category $category)
    {
        //
    }
    /**
     * @param Category $category
     */
    public function updating(Category $category)
    {
        $category->editor = Auth::id();
        $this->setSlug($category);
    }

    /**
     * Handle the Category "updated" event.
     *
     * @param  \App\Models\Blog\Category  $category
     * @return void
     */
    public function updated(Category $category)
    {
        //
    }

    /**
     * Handle the Category "deleted" event.
     *
     * @param  \App\Models\Blog\Category  $category
     * @return void
     */
    public function deleted(Category $category)
    {
        //
    }

    /**
     * Handle the Category "restored" event.
     *
     * @param  \App\Models\Blog\Category  $category
     * @return void
     */
    public function restored(Category $category)
    {
        //
    }

    /**
     * Handle the Category "force deleted" event.
     *
     * @param  \App\Models\Blog\Category  $category
     * @return void
     */
    public function forceDeleted(Category $category)
    {
        //
    }
}
