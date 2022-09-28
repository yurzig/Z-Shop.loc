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
            ->where($where)
            ->orderBy($sort[0], $sort[1])
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
    public function getEdit(int $id)
    {
        return $this->startConditions()->find($id);
    }

    /**
     * Получить список по категории
     *
     * @return \App\Models\Media
     */
    public function getByObject($ref_id, $object = 'product')
    {
        $result = $this
            ->startConditions()
            ->where('ref_id', $ref_id)
            ->where('object', $object)
            ->toBase()
            ->get();
        return $result;
    }

}
