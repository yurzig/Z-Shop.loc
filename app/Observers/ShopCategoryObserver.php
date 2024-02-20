<?php

namespace App\Observers;

use App\Models\Shop\Category;
use App\Repositories\Shop\CategoryRepository;
use Illuminate\Support\Facades\Auth;

class ShopCategoryObserver
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
            $slug = \Str::slug($category->title);
            $category->slug = $slug;

            $i = 0;
            while (app(CategoryRepository::class)->getBySlugs($category->slug)->count() > 0) {
                $category->slug = $slug . '_' . ++$i;
            }
        }
    }

    /**
     * Handle the PostCategory "created" event.
     *
     * @param  \App\Models\Shop\Category  $category
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
     * Handle the PostCategory "updated" event.
     *
     * @param  \App\Models\Shop\Category  $category
     * @return void
     */
    public function updated(Category $category)
    {
        //
    }

    /**
     * Handle the PostCategory "deleted" event.
     *
     * @param  \App\Models\Shop\Category  $category
     * @return void
     */
    public function deleted(Category $category)
    {
        //
    }

    /**
     * Handle the PostCategory "restored" event.
     *
     * @param  \App\Models\Shop\Category  $category
     * @return void
     */
    public function restored(Category $category)
    {
        //
    }

    /**
     * Handle the PostCategory "force deleted" event.
     *
     * @param  \App\Models\Shop\Category  $category
     * @return void
     */
    public function forceDeleted(Category $category)
    {
        //
    }
}
