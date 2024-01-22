<?php

namespace App\ServicesYz;

use App\Models\Blog\Post;
use App\Models\Blog\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


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
//
//    /**
//        Сохранение поста
//     */
//    public function store(Request $request): RedirectResponse
//    {
//        $data = $request->input();
//        $this->saveValidate($data);
//
//        $post = (new Post())->create($data);
//
//        if (!$post) {
//
//            return back()->withErrors(['msg' => 'Ошибка сохранения'])->withInput();
//        }
//
//        return to_route('admin.blog.posts.edit', $post)->with(['success' => 'Успешно сохранено']);
//    }
//
//    /**
//        Получить пост по id
//     */
////    public function getPost(int $id): \Illuminate\Database\Eloquent\Builder|array|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
////    {
////
////        return Post::with('review')
////                     ->findOrFail($id);
////    }
//
//    /**
//        Обновить пост
//     */
//    public function update(Request $request, Post $post):RedirectResponse
//    {
//        if (empty($post)) {
//
//            return back()
//                ->withErrors(['msg' => "Запись id=[{$post->id}] не найдена"])
//                ->withInput();
//        }
//
//        $data = $request->all();
//
//        $this->saveValidate($data);
//
//        $result = $post->update($data);
//
//        if (!$result) {
//
//            return back()->withErrors(['msg' => 'Ошибка сохранения'])->withInput();
//        }
//
//        return to_route('admin.blog.posts.edit', $post)->with(['success' => 'Успешно сохранено']);
//    }
//
//    /**
//        Удалить пост
//     */
//    public function delete (Post $post): RedirectResponse
//    {
//        $item = $post;
//
//        $result = $post->delete();
//
//        if (!$result) {
//
//            return back()->withErrors(['msg' => 'Ошибка удаления']);
//        }
//
//        return redirect()
//            ->route('admin.blog.posts.index')
//            ->with(['success' => "Удалена запись id[$item->id] - $item->title"]);
//    }
//
//    /**
//        Валидация
//     */
//    public function saveValidate( array $data ): void
//    {
//        Validator::make( $data, [
//            'category_id' => 'required|integer|exists:blog_categories,id',
//            'user_id' => 'required|integer|exists:users,id',
//            'title' => 'required|min:3|max:200',
//            'slug' => 'max:200',
//            'excerpt' => 'max:200',
//            'content' => 'required|max:10000',
//        ])->validate();
//    }

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

//    /**
//     * Если поле slug пустое, то заполняем его конвертацией заголовка
//     */
//    public function setSlug(Post $post): String
//    {
//        if (!empty($post->slug)) {
//
//            return $post->slug;
//        }
//
//        $slug = Str::slug($post->title);
//        $slug_new = $slug;
//
//        $i = 0;
//        while (Post::where('slug', $slug_new)->withTrashed()->get()->count() > 0) {
//            $slug_new = $slug . '_' . ++$i;
//        }
//
//        return $slug_new;
//    }
}
