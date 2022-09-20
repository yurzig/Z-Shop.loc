<?php

namespace App\Repositories;

use App\Models\Setting as Model;
use function PHPUnit\Framework\isNull;

/**
 * Class SettingRepository
 *
 * @package App\Repositories
 */
class SettingRepository extends CoreRepository
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
    public function getEdit(int $id)
    {
        return $this->startConditions()->find($id);
    }
    /**
     * Получить массив настроек.
     *
     * @param string $slug
     *
     * @return array
     */
    public function getSetting($slug)
    {
//        dd(__METHOD__,$slug);
        $items = $this->startConditions()
                      ->where('slug', $slug)
                      ->value('setting');

        if(!isset($items)) {
            return [];
        }
        $setting = [];
        foreach ($items as $item) {
            $setting[$item['key']] = $item['value'];
        }

        return $setting;
    }

}
