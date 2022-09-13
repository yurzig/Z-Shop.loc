<?php

namespace App\Repositories;

use App\Models\User as Model;

/**
 * Class UserRepository
 *
 * @package App\Repositories
 */
class UserRepository extends CoreRepository
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
     * Получить запись по email
     *
     * @return Model
     */
    public function getByEmail($email)
    {
        $result = $this
            ->startConditions()
            ->where('email',  $email)
            ->get();

        return $result;
    }
    /**
     * Получить список пользователей для вывода в выпадающем списке
     *
     * @return Model
     */
    public function getForSelect()
    {
        $result = $this
            ->startConditions()
            ->select('id', 'name')
            ->toBase()
            ->get();

        return $result;
    }

}
