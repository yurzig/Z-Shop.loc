<?php

namespace App\ServicesYz;

use App\Models\Blog\PostReview;
use App\Models\Blog\PostTag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class PostTagsService
{
    /**
     * Получить список тегов
     */
    public function getAll(?int $perPage = null): object
    {
        $filter = self::getFilters();
        $sort = self::getSort(['id', 'asc']);

        $query = PostTag::query();
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
        Сохранение тега
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->input();

        $this->saveValidate($data);

        $tag = (new PostTag())->create($data);

        if (!$tag) {

            return back()->withErrors(['msg' => 'Ошибка сохранения'])->withInput();
        }

        return to_route('admin.blog.tags.edit', $tag)->with(['success' => 'Успешно сохранено']);
    }

    /**
        Обновить тег
     */
    public function update(Request $request, PostTag $tag): RedirectResponse
    {
        if (empty($tag)) {

            return back()
                ->withErrors(['msg' => "Запись id=[{$tag->id}] не найдена"])
                ->withInput();
        }

        $data = $request->all();

        $this->saveValidate($data);

        $result = $tag->update($data);

        if (!$result) {

            return back()->withErrors(['msg' => 'Ошибка сохранения'])->withInput();
        }

        return to_route('admin.blog.tags.edit', $tag)->with(['success' => 'Успешно сохранено']);
    }

    /**
        Удалить тег
     */
    public function delete (PostTag $tag): RedirectResponse
    {
        $item = $tag;

        $result = $tag->delete();

        if (!$result) {

            return back()->withErrors(['msg' => 'Ошибка удаления']);
        }

        return redirect()
            ->route('admin.blog.tags.index')
            ->with(['success' => "Удалена запись id[$item->id] - $item->title"]);
    }

    /**
        Валидация
     */
    public function saveValidate( array $data ): void
    {
        Validator::make( $data, [
            'title' => 'required',
        ])->validate();
    }

    /**
     * Сохранение в сессии списка видимых колонок.
     */
    public function setColumns(array $fields): void
    {
        session(['post_tags_columns' => $fields]);
    }

    /**
     * Получить список видимых колонок.
     */
    public function getColumns(array $defaultFields): array
    {

        return session('post_tags_columns', $defaultFields);
    }

    /**
     * Сохранение в сессии примененных фильтров.
     */
    public function setFilters(array $filters): void
    {
        session(['post_tags_filter' => $filters]);
    }

    /**
     * Получение примененных фильтров.
     */
    public function getFilters(): array
    {

        return session('post_tags_filter', []);
    }

    /**
     * Сброс и сохранение в сессии примененных фильтров.
     */
    public function filtersReset(): void
    {
        session(['post_tags_filter' => []]);
    }

    /**
     * Сохранение в сессии поля и направления сортировки.
     */
    public function setSort(Request $request): void
    {
        $direction = 'asc';
        if ($request->session()->has('post_tags_sort')) {
            $sort = session('post_tags_sort');
            if ($sort[0] === $request->order) {
                $direction = $sort[1] === 'asc' ? 'desc' : 'asc';
            }
        }

        session(['post_tags_sort' => [$request->order, $direction]]);
    }

    /**
     * Получение поля и направления сортировки.
     */
    public function getSort(array $defaultSort): array
    {

        return session('post_tags_sort', $defaultSort);
    }

    /**
     * Получить список тегов для вывода в выпадающем списке
     */
    public function getForSelect()
    {

        return PostTag::select('id', 'title')->toBase()->get();
    }

}
