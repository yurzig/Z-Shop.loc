<?php

namespace App\Repositories;

use App\Models\Text as Model;

/**
 * Class TextRepository
 *
 * @package App\Repositories
 */
class TextRepository extends CoreRepository
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
     * Получить модель для редактирования.
     *
     * @param int $id
     *
     * @return Model
     */
    public function getRow(int $id)
    {
        return $this->startConditions()->find($id);
    }
    public function getForSelect()
    {
        $texts = $this->startConditions()
            ->leftJoin('textables', 'texts.id', 'text_id')
            ->where('textable_type', 'shopCategory')
            ->select('texts.id', 'title', 'type')
            ->orderBy('type')
            ->get();

        return $texts;
    }
}
