<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Http\Controllers\Controller;
use App\Models\Blog\Post;
use App\Services\Blog\PostService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Repositories\Blog\PostRepository;
use Illuminate\View\View;

class PostController extends Controller
{
    private $perPage;

    public function __construct()
    {
        $this->perPage = 25;
    }

    /**
     * Список постов
     */
    public function index(): View
    {
        $items = posts()->getAll($this->perPage);

        return view('admin.blog.posts.index', compact('items'));
    }

    /**
     * Создание поста(форма)
     */
    public function create(): View
    {

        return view('admin.blog.posts.create');
    }

    /**
     * Создание поста(сохранение)
     */
    public function store(Request $request): RedirectResponse
    {

        return posts()->store($request);
    }

    /**
     * Редактирование поста(форма)
     */
    public function edit(Post $post): View
    {

        return view('admin.blog.posts.edit', compact('post'));
    }

    /**
     * Редактирование поста(сохранение)
     */
    public function update(Request $request, Post $post): RedirectResponse
    {

        return posts()->update($request, $post);
    }

    /**
     * Удаление поста.
     */
    public function destroy(Post $post): RedirectResponse
    {

        return posts()->delete($post);
    }

     /**
     * Сохранение в сессии списка видимых колонок.
     */
    public function columns(Request $request): RedirectResponse
    {
        posts()->setColumns($request->fields);

        return to_route('admin.blog.posts.index');
    }

    /**
     * Сохранение в сессии примененных фильтров.
     */
    public function filter(Request $request): RedirectResponse
    {
        posts()->setFilters($request->filters);

        return to_route('admin.blog.posts.index');
    }

    /**
     * Сброс и сохранение в сессии примененных фильтров.
     */
    public function filtersReset(): RedirectResponse
    {
        posts()->filtersReset();

        return to_route('admin.blog.posts.index');
    }

    /**
     * Сохранение в сессии поля и направления сортировки.
     */
    public function sort(Request $request)
    {
        posts()->setSort($request);

        return to_route('admin.blog.posts.index');
    }

}
