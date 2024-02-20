<?php

namespace App\Providers;

use App\Models\Blog\Post;
use App\Observers\BlogCategoryObserver;
use App\Models\Blog\PostCategory as BlogCategory;
use App\Models\Shop\Category as ShopCategory;
use App\Observers\BlogPostObserver;
use App\Observers\ShopCategoryObserver;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrapFive();

        ShopCategory::observe(ShopCategoryObserver::class);

        Relation::enforceMorphMap([
            'shopCategory' => 'App\Models\Shop\Category',
        ]);
    }
}
