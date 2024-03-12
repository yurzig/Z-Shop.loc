<?php

namespace App\ServicesYz;

use App\Models\Blog\PostTag;
use App\Yz\Services\Service;
use App\Yz\Services\Traits\ActionAfterSaving;
use App\Yz\Services\Traits\ACTIONS;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class PostTagsService extends Service
{
    use ACTIONS, ActionAfterSaving;

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

        return $this->actionAfterSaving($tag, $request);
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

        return $this->actionAfterSaving($tag, $request);
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
            ->with(['success' => "Удалена запись id[$item->id] - $item->tag"]);
    }

    /**
        Валидация
     */
    public function saveValidate( array $data ): void
    {
        Validator::make( $data, [
            'tag' => 'required|unique:post_tags',
        ])->validate();
    }

    /**
     * Получить список тегов для вывода в выпадающем списке
     */
    public function getForSelect()
    {

        return PostTag::select('id', 'tag')->toBase()->get();
    }
    /**
        Добавить тег
     */
    public function addTag(string $tag)
    {
        $data = ['tag' => $tag];

        $this->saveValidate($data);

        $result = (new PostTag())->create($data);

        if (!$result) {

            return 'Ошибка сохранения';
        }

        return 'ok';
    }
}
