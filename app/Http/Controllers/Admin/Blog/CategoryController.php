<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Http\Controllers\Controller;
use App\Models\Blog\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class CategoryController extends Controller
{

    public function __construct()
    {
    }

    /**
     * Вывод списка категорий в виде дерева.
     */
    public function index(): View
    {

        return view('admin.blog.categories.index');
    }
    /**
     * Добавление новой категории(форма)
     */
    public function add($parent): View
    {

        return view('admin.blog.categories.create', compact('parent'));
    }

    /**
     * Добавление новой категории(сохранить)
     */
    public function store(Request $request): RedirectResponse
    {

        return postCategories()->store($request);
    }

    /**
     * Редактирование категории (форма)
     */
    public function edit(Category $category): View
    {
        $categories = postCategories()->getTree();

        return view('admin.blog.categories.edit', compact('category','categories'));
    }

    /**
     * Редактирование категории (сохранить)
     */
    public function update(Request $request, Category $category): RedirectResponse
    {

        return postCategories()->update($request, $category);
    }

    /**
        Удаление категории.
     */
    public function destroy(Category $category): RedirectResponse
    {

        return postCategories()->delete($category);
    }
}
