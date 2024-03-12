<?php

namespace App\ServicesYz;

use App\Models\Blog\PostReview;
use App\Yz\Services\Service;
use App\Yz\Services\Traits\ActionAfterSaving;
use App\Yz\Services\Traits\ACTIONS;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class PostReviewsService extends Service
{
    use ACTIONS, ActionAfterSaving;
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

        $query = PostReview::query();
        if($filter) {
            foreach ($filter['val'] as $key => $item) {
                if (!is_null($item)) {
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

        $review = (new PostReview())->create($data);

        if (!$review) {

            return back()->withErrors(['msg' => 'Ошибка сохранения'])->withInput();
        }

        return $this->actionAfterSaving($review, $request);
    }

    /**
        Обновить отзыв поста
     */
    public function update(Request $request, PostReview $review): RedirectResponse
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

        return $this->actionAfterSaving($review, $request);
    }

    /**
        Удалить отзыв поста
     */
    public function delete (PostReview $review): RedirectResponse
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
            'post_id' => 'required|integer|exists:posts,id',
            'user_id' => 'required|integer|exists:users,id',
            'rating' => 'nullable|integer',
            'comment' => 'string|max:2000',
            'response' => 'nullable|string',
            'status' => 'integer',
            'editor' => 'integer',
        ])->validate();
    }

    /*
     * Получить статусы отзыва
    */
    public function getStatuses(): array
    {
        return self::STATUS;
    }
    /*
     * Получить статус отзыва
    */
    public function getStatus(int $id): string
    {
        return self::STATUS[$id];
    }

}
