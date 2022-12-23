<?php

namespace App\Repositories;

use App\Models\Media as Model;

/**
 * Class ShopCategoryRepository
 *
 * @package App\Repositories
 */
class MediaRepository extends CoreRepository
{
    /**
     * @return string
     */
    protected function getModelClass()
    {
        return Model::class;
    }

    /**
     * Получить список
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
            ->with('mediable')
            ->where($where)
            ->orderBy($sort[0], $sort[1])
            ->paginate($perPage);

        return $result;
    }
    /**
     * Получить список медиа с фильтром.
     *
     * @param array $param
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getGallery($perPage = null)
    {
        $result = $this
            ->startConditions()
            ->with('mediable')
            ->paginate($perPage);

        return $result;
    }

   /**
     * Получить модель для редактирования в админке.
     *
     * @param int $id
     *
     * @return Model
     */
    public function getRow(int $id)
    {
        return $this->startConditions()->find($id);
    }

}
