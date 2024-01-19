<?php

use App\Http\Controllers\Admin\Blog\PostController;

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
            Route::post('settings/columns', 'columnsSave')->name('settings.columns');
            Route::post('settings/search', 'search')->name('settings.search');
            Route::get('settings/reset', 'reset')->name('settings.reset');
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
        'as' => 'admin.blog.',
        'namespace' => 'App\Http\Controllers\Admin\Blog'
    ],
    function () {
        Route::get('categories/add/{parent}', 'CategoryController@add')->name('categories.add');
        Route::post('categories/sortable', 'CategoryController@sortable')->name('categories.sortable');
        Route::resource('categories', 'CategoryController')->except(['show', 'create'])->names('categories');

        Route::controller(PostController::class)->group(function () {
            Route::post('posts/columns', 'columns')->name('posts.columns');
            Route::post('posts/filter', 'filter')->name('posts.filter');
            Route::get('posts/reset', 'filtersReset')->name('posts.reset');
            Route::get('posts/sort', 'sort')->name('posts.sort');
        });
        Route::resource('posts', 'PostController')->except(['show'])->names('posts');

        Route::controller(ReviewController::class)->group(function () {
            Route::post('reviews/columns', 'columnsSave')->name('reviews.columns');
            Route::post('reviews/search', 'search')->name('reviews.search');
            Route::post('reviews/reset', 'reset')->name('reviews.reset');
            Route::get('reviews/sort', 'sort')->name('reviews.sort');
        });
        Route::resource('reviews', 'ReviewController')->except(['show'])->names('reviews');
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

    Route::get('categories/add/{parent}', 'CategoryController@add')->name('categories.add');
    Route::resource('categories', 'CategoryController')->except(['show', 'create'])->names('categories');

    }
);
