<?php

namespace App\Yz\Debug\Controllers;

use App\Http\Controllers\Controller;

class TestController extends Controller
{

    /**
     * Здесь можно прописывать код, функции и т.д. и тестировать в браузере по адресу /debug/test
     */
    public function index()
    {
        // получить посты с заданными тегами
        dd(posts()->getByTags(['Тег 2','дорога']));

        return view('debug.test',[]);
    }
}

