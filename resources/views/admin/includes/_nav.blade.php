<?php

use Illuminate\Support\Facades\Route;

$menuItems = [
    'blog' => [
        'name' => 'Статьи',
        'class' => 'fa-address-card-o',
        'url' => 'post',
        'role' => 'manage-blog',
        'submenu' => [
            'post.categories' => [
                'name' => 'Категории',
                'class' => 'fa-sitemap',
                'url' => route('admin.post.categories.index'),
                'role' => 'manage-blog',
            ],
            'posts' => [
                'name' => 'Статьи',
                'class' => 'fa-address-card-o',
                'url' => route('admin.posts.index'),
                'role' => 'manage-blog',
            ],
            'post.reviews' => [
                'name' => 'Отзывы',
                'class' => 'fa-comments',
                'url' => route('admin.post.reviews.index'),
                'role' => 'manage-blog',
            ],
            'post.tags' => [
                'name' => 'Теги',
                'class' => 'fa-tags',
                'url' => route('admin.post.tags.index'),
                'role' => 'manage-blog',
            ],

        ]
    ],
    'product' => [
        'name' => 'Продукты',
        'class' => 'fa-cube',
        'url' => 'products',
        'role' => 'manage-shop',
        'submenu' => [
            'shop.categories' => [
                'name' => 'Категории',
                'class' => 'fa-sitemap',
                'url' => route('admin.shop.categories.index'),
                'role' => 'manage-shop',
            ],
            'shop.products' => [
                'name' => 'Товары',
                'class' => 'fa-cube',
                'url' => '#',
//        'url' => route('admin.shop.products.index'),
                'role' => 'manage-shop',
            ],

        ]
    ],
    'types' => [
        'name' => 'Справочники',
        'class' => 'fa-tags',
        'url' => 'types',
        'role' => 'admin',
        'submenu' => [
            'texts' => [
                'name' => 'Тексты',
                'class' => 'fa-tag',
                'url' => route('admin.texts.index'),
                'role' => 'admin',
            ],
            'medias' => [
                'name' => 'Галерея',
                'class' => 'fa-picture-o',
                'url' => route('admin.medias.index'),
                'role' => 'manage-shop',
            ],

        ]
    ],
    'shop-prices' => [
        'name' => 'Цены',
        'class' => 'fa-money',
        'url' => '#',
//        'url' => route('admin.shop.prices.index'),
        'role' => 'manage-shop',
    ],
    'shop-banners' => [
        'name' => 'Баннеры',
        'class' => 'fa-tag',
        'url' => '#',
//        'url' => route('admin.shop.banners.index'),
        'role' => 'manage-shop',
    ],
    'shop-properties-list' => [
        'name' => 'Свойства товара',
        'class' => 'fa-tags',
        'url' => '#',
//        'url' => route('admin.shop.proplist.index'),
        'role' => 'manage-shop',
    ],
    'shop-properties-options' => [
        'name' => 'Варианты свойства',
        'class' => 'fa-tags',
        'url' => '#',
//        'url' => route('admin.shop.options.index'),
        'role' => 'manage-shop',
    ],
    'shop-properties-values' => [
        'name' => 'Значения свойств',
        'class' => 'fa-tags',
        'url' => '#',
//        'url' => route('admin.shop.propvalues.index'),
        'role' => 'manage-shop',
    ],

    'shop-orders' => [
        'name' => 'Заказы',
        'class' => 'fa-shopping-cart',
        'url' => '#',
//        'url' => route('admin.shop.orders.index'),
        'role' => 'manage-shop',
    ],
    'shop-brands' => [
        'name' => 'Бренды',
        'class' => 'fa-industry',
        'url' => '#',
//        'url' => route('admin.shop.brands.index'),
        'role' => 'manage-shop',
    ],
    'shop-reviews' => [
        'name' => 'Отзывы',
        'class' => 'fa-comments',
        'url' => '#',
//        'url' => route('admin.shop.reviews.index'),
        'role' => 'manage-shop',
    ],
    'users' => [
        'name' => 'Пользователи',
        'class' => 'fa-user',
        'url' => '#',
//        'url' => route('admin.users.index'),
        'role' => 'admin',
    ],
    'settings' => [
        'name' => 'Настройки',
        'class' => 'fa-cog',
        'url' => route('admin.settings.index'),
        'role' => 'admin',
    ],
    'tests' => [
        'name' => 'Тесты',
        'class' => 'fa-microscope',
        'url' => route('debug.test'),
        'role' => 'admin',
    ],
];
$arrayRoute = explode('.', Route::currentRouteName());
array_shift($arrayRoute);
array_pop($arrayRoute);
$currentRouteName = implode('.',$arrayRoute);
?>
@foreach($menuItems as $key => $item)
    @isset($item['submenu'])
        <a class="nav-link {{ Arr::exists($item['submenu'], $currentRouteName) ? 'collapse-active' : '' }}"
           data-bs-toggle="collapse"
           aria-expanded="{{ Arr::exists($item['submenu'], $currentRouteName) ? 'true' : 'false' }}"
           aria-controls="{{ $item['url'] }}"
           href="#{{ $item['url'] }}">
            <i class="fa {{ $item['class'] }}" aria-hidden="true"></i>
            {{ $item['name'] }}
        </a>

        <div class="collapse{{ Arr::exists($item['submenu'], $currentRouteName) ? ' show' : '' }}" id="{{ $item['url'] }}">
            @foreach($item['submenu'] as $subKey => $subItem)
                @can($subItem['role'])
                    <a class="nav-link ms-3 {{ Route::is('admin.'.$subKey.'.*') ? 'active' : '' }}" href="{{ $subItem['url'] }}">
                        <i class="fa {{ $subItem['class'] }}" aria-hidden="true"></i>
                        <span class="title">{{ $subItem['name'] }}</span>
                    </a>
                @endcan
            @endforeach
        </div>
    @else
        @can($item['role'])
            <a class="nav-link {{ Route::is('admin.'.$key.'.*') ? 'active' : 'null' }}" href="{{ $item['url'] }}">
                <i class="fa {{ $item['class'] }}" aria-hidden="true"></i>
                <span class="title">{{ $item['name'] }}</span>
            </a>
        @endcan
    @endisset
@endforeach
