<?php
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

        Route::post('settings/columns', 'SettingController@columnsSave')->name('settings.columns');
        Route::post('settings/search', 'SettingController@search')->name('settings.search');
        Route::get('settings/reset', 'SettingController@reset')->name('settings.reset');
        Route::get('settings/sort', 'SettingController@sort')->name('settings.sort');

        Route::resource('settings', 'SettingController')
            ->except(['show'])
            ->names('settings');

        Route::post('texts/columns', 'TextController@columnsSave')->name('texts.columns');
        Route::post('texts/search', 'TextController@search')->name('texts.search');
        Route::get('texts/reset', 'TextController@reset')->name('texts.reset');
        Route::get('texts/sort', 'TextController@sort')->name('texts.sort');
        Route::post('texts/row', 'TextController@ajaxGetRow')->name('texts.row');

        Route::resource('texts', 'TextController')
            ->except(['show'])
            ->names('texts');

        Route::post('medias/uploadimg', 'MediaController@uploadImg')->name('medias.uploadimg');
        Route::post('medias/columns', 'MediaController@columnsSave')->name('medias.columns');
        Route::post('medias/search', 'MediaController@search')->name('medias.search');
        Route::post('medias/reset', 'MediaController@reset')->name('medias.reset');
        Route::get('medias/sort', 'MediaController@sort')->name('medias.sort');

        Route::resource('medias', 'MediaController')
            ->except(['show'])
            ->names('medias');

        Route::group(
            [
                'prefix' => 'blog',
                'as' => 'blog.',
                'namespace' => 'Blog'
            ],
            function () {
                Route::get('categories/add/{parent}', 'CategoryController@add')->name('categories.add');

                Route::resource('categories', 'CategoryController')
                    ->except(['show', 'create'])
                    ->names('categories');

                Route::post('posts/columns', 'PostController@columnsSave')->name('posts.columns');
                Route::post('posts/search', 'PostController@search')->name('posts.search');
                Route::get('posts/reset', 'PostController@reset')->name('posts.reset');
                Route::get('posts/sort', 'PostController@sort')->name('posts.sort');

                Route::resource('posts', 'PostController')
                    ->except(['show'])
                    ->names('posts');

                Route::post('reviews/columns', 'ReviewController@columnsSave')->name('reviews.columns');
                Route::post('reviews/search', 'ReviewController@search')->name('reviews.search');
                Route::post('reviews/reset', 'ReviewController@reset')->name('reviews.reset');
                Route::get('reviews/sort', 'ReviewController@sort')->name('reviews.sort');

                Route::resource('reviews', 'ReviewController')
                    ->except(['show'])
                    ->names('reviews');

            }
        );

        Route::group(
            [
                'prefix' => 'shop',
                'as' => 'shop.',
                'namespace' => 'Shop'
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

                Route::resource('categories', 'CategoryController')
                    ->except(['show', 'create'])
                    ->names('categories');

            }
        );
    }
);
