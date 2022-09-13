<?php

namespace App\Repositories\Blog;

use App\Models\Blog\Post as Model;
use App\Repositories\CoreRepository;

/**
 * Class PostRepository
 *
 * @package App\Repositories\Blog
 */
class PostRepository extends CoreRepository
{
    /**
     * @return string
     */
    protected function getModelClass()
    {
        return Model::class;
    }

    /**
     * Получить список категорий
     *
     * @param int|null $perPage
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAll(array $sort, array $filter, ?int $perPage = null)
    {
        $where = [];
        if($filter) {
            foreach ($filter['val'] as $key => $item) {
                if ($item) {
                    $where[] = [$key, $filter['op'][$key], $filter['op'][$key] === 'like' ? "%$item%" : $item];
                }
            }
        }
        $result = $this
            ->startConditions()
            ->where($where)
//            ->with(['parentCategory:id,title',])
            ->orderBy($sort[0], $sort[1])
            ->paginate($perPage);
        return $result;
    }

    /**
     * Получить список категорий для вывода в выпадающем списке
     *
     * @return Model
     */
    public function getForSelect()
    {
        $result = $this
            ->startConditions()
            ->select('id', 'title')
            ->toBase()
            ->get();

        return $result;
    }

    /**
     * Получить модель для редактирования в админке.
     *
     * @param int $id
     *
     * @return Model
     */
    public function getEdit(int $id)
    {
        return $this->startConditions()->find($id);
    }

    /**
     * Получить запись по слагу
     *
     * @return Model
     */
    public function getBySlug($slug)
    {
        $result = $this
            ->startConditions()
            ->where('slug', $slug)
            ->get();

        return $result;
    }

}
