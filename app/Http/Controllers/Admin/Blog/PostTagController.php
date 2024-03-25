<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Http\Controllers\Controller;
use App\Models\Blog\PostTag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostTagController extends Controller
{
    private $perPage;

    public function __construct()
    {
        $this->perPage = 25;
    }

    /**
     * Список тегов
     */
    public function index()
    {
        $items = postTags()->getAll($this->perPage);

        return view('admin.blog.tags.index', compact('items'));
    }

    /**
     * Создание тега(форма)
     */
    public function create(): View
    {

        return view('admin.blog.tags.create');
    }

    /**
     * Создание тега(сохранение)
     */
    public function store(Request $request): RedirectResponse
    {

        return postTags()->store($request);
    }

    /**
     * Редактирование тега(форма)
     */
    public function edit(PostTag $tag): View
    {

        return view('admin.blog.tags.edit', compact('tag'));
    }

    /**
     * Редактирование тега(сохранение)
     */
    public function update(Request $request, PostTag $tag): RedirectResponse
    {

        return postTags()->update($request, $tag);
    }

    /**
     * Удаление тега.
     */
    public function destroy(PostTag $tag)
    {

        return postReviews()->delete($review);
    }

    /**
     * Сохранение в сессии списка видимых колонок.
     */
    public function columns(Request $request): RedirectResponse
    {
        postTags()->setColumns($request->fields);

        return to_route('admin.blog.tags.index');
    }

    /**
     * Сохранение в сессии примененных фильтров.
     */
    private function filter(Request $request): RedirectResponse
    {
        postTags()->setFilters($request->filters);

        return to_route('admin.blog.tags.index');
    }

    /**
     * Сброс и сохранение в сессии примененных фильтров.
     */
    public function filtersReset()
    {
        postTags()->filtersReset();

        return to_route('admin.blog.tags.index');
    }

    /**
     * Сохранение в сессии поля и направления сортировки.
     */
    public function sort(Request $request): RedirectResponse
    {
        postTags()->setSort($request);

        return to_route('admin.blog.tags.index');
    }

}
