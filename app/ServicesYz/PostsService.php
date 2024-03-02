<?php

namespace App\ServicesYz;

use App\Models\Blog\Post;
use App\Yz\Services\Traits\ActionAfterSaving;
use App\Yz\Services\Traits\ACTIONS;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Yz\Services\Service;

class PostsService extends Service
{
    use ACTIONS, ActionAfterSaving;
    public const STATUS = [
        1 => 'черновик',
        2 => 'опубликована',
    ];

    /**
     * Получить список постов
     */
    public function getAll(?int $perPage = null): object
    {
        $filter = self::getFilters();
        $sort = self::getSort(['id', 'asc']);

        $query = Post::query();
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
        Сохранение поста
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->input();

        $this->saveValidate($data);

        $post = (new Post())->create($data);

        if (!$post) {

            return back()->withErrors(['msg' => 'Ошибка сохранения'])->withInput();
        }

        return $this->actionAfterSaving($post, $request);
    }

    /**
        Получить пост по id
     */
//    public function getPost(int $id): \Illuminate\Database\Eloquent\Builder|array|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
//    {
//
//        return Post::with('review')
//                     ->findOrFail($id);
//    }

    /**
        Обновить пост
     */
    public function update(Request $request, Post $post):RedirectResponse
    {
        if (empty($post)) {

            return back()
                ->withErrors(['msg' => "Запись id=[{$post->id}] не найдена"])
                ->withInput();
        }

        $data = $request->all();

        $this->saveValidate($data);

        $result = $post->update($data);

        if (!$result) {

            return back()->withErrors(['msg' => 'Ошибка сохранения'])->withInput();
        }

        return $this->actionAfterSaving($post, $request);
    }

    /**
        Удалить пост
     */
    public function delete (Post $post): RedirectResponse
    {
        $item = $post;

        $result = $post->delete();

        if (!$result) {

            return back()->withErrors(['msg' => 'Ошибка удаления']);
        }

        return redirect()
            ->route('admin.blog.posts.index')
            ->with(['success' => "Удалена запись id[$item->id] - $item->title"]);
    }

    /**
        Валидация
     */
    public function saveValidate( array $data ): void
    {
        Validator::make( $data, [
            'category_id' => 'required|integer|exists:post_categories,id',
            'user_id' => 'required|integer|exists:users,id',
            'title' => 'required|min:3|max:200',
            'slug' => 'max:200',
            'excerpt' => 'max:200',
            'content' => 'required|max:10000',
        ])->validate();
    }

    /*
     * Получить статусы поста
    */
    public function getStatuses(): array
    {
        return self::STATUS;
    }

    /**
     * Если поле slug пустое, то заполняем его конвертацией заголовка
     */
    public function setSlug(Post $post): String
    {
        if (!empty($post->slug)) {

            return $post->slug;
        }

        $slug = str($post->title)->slug();
        $slug_new = $slug;

        $i = 0;
        while (Post::where('slug', $slug_new)->withTrashed()->get()->count() > 0) {
            $slug_new = $slug . '_' . ++$i;
        }

        return $slug_new;
    }

    /**
     * Получить список постов для вывода в выпадающем списке
     */
    public function getForSelect()
    {

        return Post::select('id', 'title')->toBase()->get();
    }

    /**
     * Получить список постов с заданными тегами
     */
    public function getByTags(array $tags): object
    {

        return Post::whereJsonContains('tags', $tags)->get();
    }


}
