<?php

use App\Http\Controllers\Admin\Blog\PostController;
use App\Http\Controllers\Admin\Blog\PostReviewController;
use App\Http\Controllers\Admin\Blog\PostTagController;
use App\Http\Controllers\Admin\SettingController;

Route::group(
    [
        'middleware' => 'auth',
        'prefix' => 'admin',
        'as' => 'admin.',
        'namespace' => 'App\Http\Controllers\Admin'
    ],
    function () {
        Route::get('/', 'SettingController@index')->name('home');

        Route::post('image/upload', 'ImageController@upload')->name('image.upload');

        Route::controller(SettingController::class)->group(function () {
            Route::post('settings/columns', 'columns')->name('settings.columns');
            Route::post('settings/filter', 'filter')->name('settings.filter');
            Route::get('settings/reset', 'resetFilters')->name('settings.reset');
            Route::get('settings/sort', 'sort')->name('settings.sort');
        });
        Route::resource('settings', 'SettingController')->except(['show'])->names('settings');

        Route::controller(TextController::class)->group(function () {
            Route::post('texts/columns', 'columnsSave')->name('texts.columns');
            Route::post('texts/search', 'search')->name('texts.search');
            Route::get('texts/reset', 'reset')->name('texts.reset');
            Route::get('texts/sort', 'sort')->name('texts.sort');
            Route::post('texts/row', 'ajaxGetRow')->name('texts.row');
        });
        Route::resource('texts', 'TextController')->except(['show'])->names('texts');

        Route::controller(MediaController::class)->group(function () {
            Route::post('medias/uploadimg', 'uploadImg')->name('medias.uploadimg');
            Route::post('medias/columns', 'columnsSave')->name('medias.columns');
            Route::post('medias/search', 'search')->name('medias.search');
            Route::post('medias/reset', 'reset')->name('medias.reset');
            Route::get('medias/sort', 'sort')->name('medias.sort');
        });
        Route::resource('medias', 'MediaController')->except(['show'])->names('medias');
});
Route::group(
    [
        'middleware' => 'auth',
        'prefix' => 'admin/blog',
        'as' => 'admin.',
        'namespace' => 'App\Http\Controllers\Admin\Blog'
    ],
    function () {
        Route::get('categories/add/{parent}', 'PostCategoryController@add')->name('post.categories.add');
        Route::post('categories/sortable', 'PostCategoryController@sortable')->name('post.categories.sortable');
        Route::resource('categories', 'PostCategoryController')->except(['show', 'create'])->names('post.categories');

        Route::controller(PostController::class)->group(function () {
            Route::post('posts/columns', 'columns')->name('posts.columns');
            Route::post('posts/filter', 'filter')->name('posts.filter');
            Route::get('posts/reset', 'resetFilters')->name('posts.reset');
            Route::get('posts/sort', 'sort')->name('posts.sort');
            Route::post('posts/add-tag', 'addTag')->name('posts.add_tag');
            Route::post('posts/add-block', 'addBlock')->name('posts.add_block');
            Route::post('posts/add-img', 'addImg')->name('posts.add_img');
        });
        Route::resource('posts', 'PostController')->except(['show'])->names('posts');

        Route::controller(PostReviewController::class)->group(function () {
            Route::post('reviews/columns', 'columnsSave')->name('post.reviews.columns');
            Route::post('reviews/filter', 'filter')->name('post.reviews.filter');
            Route::post('reviews/reset', 'resetFilters')->name('post.reviews.reset');
            Route::get('reviews/sort', 'sort')->name('post.reviews.sort');
        });
        Route::resource('reviews', 'PostReviewController')->except(['show'])->names('post.reviews');

        Route::controller(PostTagController::class)->group(function () {
            Route::post('tags/columns', 'columnsSave')->name('post.tags.columns');
            Route::post('tags/filter', 'filter')->name('post.tags.filter');
            Route::post('tags/reset', 'resetFilters')->name('post.tags.reset');
            Route::get('tags/sort', 'sort')->name('post.tags.sort');
        });
        Route::resource('tags', 'PostTagController')->except(['show'])->names('post.tags');
    }
);

Route::group(
    [
        'middleware' => 'auth',
        'prefix' => 'admin/shop',
        'as' => 'admin.shop.',
        'namespace' => 'App\Http\Controllers\Admin\Shop'
    ],
    function () {
//                Route::post('products/columns', 'ProductController@columnsSave')->name('products.columns');
//                Route::post('products/formlist', 'ProductController@formList')->name('products.formlist');
//                Route::get('products/sort', 'ProductController@sort')->name('products.sort');
//                Route::get('products/metaclear', 'ProductController@metaClear')->name('products.metaclear');
//                Route::get('products/metafill', 'ProductController@metaFill')->name('products.metafill');
//
//                Route::resource('products', 'ProductController')
//                    ->except(['show'])
//                    ->names('products');

    Route::get('categories/add/{parent}', 'PostCategoryController@add')->name('categories.add');
    Route::resource('categories', 'PostCategoryController')->except(['show', 'create'])->names('categories');

    }
);
