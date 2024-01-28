<?php

namespace App\ServicesYz;

use App\Models\Blog\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class PostReviewsService
{
    public const STATUS = [
        1 => 'Скрыт',
        2 => 'Опубликован',
    ];

    /**
     * Получить список отзывов постов
     */
    public function getAll(?int $perPage = null): object
    {
        $filter = self::getFilters();
        $sort = self::getSort(['status', 'asc']);

        $query = Review::query();
        if($filter) {
            foreach ($filter['val'] as $key => $item) {
                if ($item) {
                    $query->where($key, $filter['op'][$key], $filter['op'][$key] === 'like' ? "%$item%" : $item);
                }
            }
        }
        $result = $query
            ->orderBy($sort[0], $sort[1])
            ->paginate($perPage);

        return $result;
    }

    /**
        Сохранение отзыва
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->input();
        $data['editor'] = Auth::id();
        if (!isset($data['name']) and $data['user_id']) {
            $user = users()->getUser($data['user_id']);
            $data['name'] = $user->name;
            $data['email'] = $user->email;
        }

        $this->saveValidate($data);

        $review = (new Review())->create($data);

        if (!$review) {

            return back()->withErrors(['msg' => 'Ошибка сохранения'])->withInput();
        }

        return to_route('admin.blog.reviews.edit', $review)->with(['success' => 'Успешно сохранено']);
    }

    /**
        Обновить отзыв поста
     */
    public function update(Request $request, Review $review): RedirectResponse
    {
        if (empty($review)) {

            return back()
                ->withErrors(['msg' => "Запись id=[{$review->id}] не найдена"])
                ->withInput();
        }

        $data = $request->all();
        $data['editor'] = Auth::id();


        $this->saveValidate($data);

        $result = $review->update($data);

        if (!$result) {

            return back()->withErrors(['msg' => 'Ошибка сохранения'])->withInput();
        }

        return to_route('admin.blog.reviews.edit', $review)->with(['success' => 'Успешно сохранено']);
    }

    /**
        Удалить отзыв поста
     */
    public function delete (Review $review): RedirectResponse
    {
        $item = $review;

        $result = $review->delete();

        if (!$result) {

            return back()->withErrors(['msg' => 'Ошибка удаления']);
        }

        return redirect()
            ->route('admin.blog.reviews.index')
            ->with(['success' => "Удалена запись id[$item->id] для статьи - $item->post->title"]);
    }

    /**
        Валидация
     */
    public function saveValidate( array $data ): void
    {
        Validator::make( $data, [
            'post_id' => 'required|integer|exists:blog_posts,id',
            'user_id' => 'required|integer|exists:users,id',
            'rating' => 'nullable|integer',
            'comment' => 'string|max:2000',
            'response' => 'nullable|string',
            'status' => 'integer',
            'editor' => 'integer',
        ])->validate();
    }

    /**
     * Сохранение в сессии списка видимых колонок.
     */
    public function setColumns(array $fields): void
    {
        session(['post_reviews_columns' => $fields]);
    }

    /**
     * Получить список видимых колонок.
     */
    public function getColumns(array $defaultFields): array
    {

        return session('post_reviews_columns', $defaultFields);
    }

    /**
     * Сохранение в сессии примененных фильтров.
     */
    public function setFilters(array $filters): void
    {
        session(['post_reviews_filter' => $filters]);
    }

    /**
     * Получение примененных фильтров.
     */
    public function getFilters(): array
    {

        return session('post_reviews_filter', []);
    }

    /**
     * Сброс и сохранение в сессии примененных фильтров.
     */
    public function filtersReset(): void
    {
        session(['posts_review_filter' => []]);
    }

    /**
     * Сохранение в сессии поля и направления сортировки.
     */
    public function setSort(Request $request): void
    {
        $direction = 'asc';
        if ($request->session()->has('post_reviews_sort')) {
            $sort = session('post_reviews_sort');
            if ($sort[0] === $request->order) {
                $direction = $sort[1] === 'asc' ? 'desc' : 'asc';
            }
        }

        session(['post_reviews_sort' => [$request->order, $direction]]);
    }

    /**
     * Получение поля и направления сортировки.
     */
    public function getSort(array $defaultSort): array
    {

        return session('post_reviews_sort', $defaultSort);
    }

    /*
     * Получить статусы отзыва
    */
    public function getStatuses(): array
    {
        return self::STATUS;
    }

    /**
     * Получение даты/времени по Москве
     */
    public function getMoscowTime($value): string
    {
        if($value) {

            return Carbon::createFromFormat('Y-m-d H:i:s', $value)->timezone('Europe/Moscow');
        }

        return '';
    }
}
