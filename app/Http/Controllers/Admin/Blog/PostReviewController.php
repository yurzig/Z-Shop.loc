<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Http\Controllers\Controller;
use App\Models\Blog\PostReview;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostReviewController extends Controller
{
    private $perPage;

    public function __construct()
    {
        $this->perPage = 25;
    }

    /**
     * Список отзывов поста
     */
    public function index()
    {
        $items = postReviews()->getAll($this->perPage);

        return view('admin.blog.reviews.index', compact('items'));
    }

    /**
     * Создание отзыва(форма)
     */
    public function create(): View
    {

        return view('admin.blog.reviews.create');
    }

    /**
     * Создание отзыва(сохранение)
     */
    public function store(Request $request): RedirectResponse
    {

        return postReviews()->store($request);
    }

    /**
     * Редактирование отзыва(форма)
     */
    public function edit(PostReview $review): View
    {

        return view('admin.blog.reviews.edit', compact('review'));
    }

    /**
     * Редактирование отзыва(сохранение)
     */
    public function update(Request $request, PostReview $review): RedirectResponse
    {

        return postReviews()->update($request, $review);
    }

    /**
     * Удаление отзыва поста.
     */
    public function destroy(PostReview $review): RedirectResponse
    {

        return postReviews()->delete($review);
    }

    /**
     * Сохранение в сессии списка видимых колонок.
     */
    public function columns(Request $request): RedirectResponse
    {
        postReviews()->setColumns($request->fields);

        return to_route('admin.blog.reviews.index');
    }

    /**
     * Сохранение в сессии примененных фильтров.
     */
    private function filter(Request $request): RedirectResponse
    {
        postReviews()->setFilters($request->filters);

        return to_route('admin.blog.reviews.index');
    }

    /**
     * Сброс и сохранение в сессии примененных фильтров.
     */
    public function filtersReset()
    {
        postReviews()->filtersReset();

        return to_route('admin.blog.reviews.index');
    }

    /**
     * Сохранение в сессии поля и направления сортировки.
     */
    public function sort(Request $request): RedirectResponse
    {
        postReviews()->setSort($request);

        return to_route('admin.blog.reviews.index');
    }

}
