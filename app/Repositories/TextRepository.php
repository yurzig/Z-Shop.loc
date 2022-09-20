<?php

namespace App\Repositories;

use App\Models\Text as Model;
use App\Models\Textable;

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
        if ($filter) {
            foreach ($filter['val'] as $key => $item) {
                if ($item) {
                    $where[] = [$key, $filter['op'][$key], $filter['op'][$key] === 'like' ? "%$item%" : $item];
                }
            }
        }
        $result = $this
            ->startConditions()
            ->with('textable')
            ->where($where)
            ->orderBy($sort[0], $sort[1])
            ->paginate($perPage);
//dd($result, $result[4]->textable->count());
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
            ->orWhereNull('textable_type')
            ->select('texts.id', 'title', 'type')
            ->orderBy('type')
            ->get()
            ->unique('id');

        return $texts;
    }

    public function getUsage(int $id)
    {
        $items = Textable::where('text_id', $id)
            ->orderBy('textable_type')
            ->toBase()
            ->get();

        return $items;
    }
}
