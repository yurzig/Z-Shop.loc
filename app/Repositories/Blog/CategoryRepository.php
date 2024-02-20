<?php

namespace App\Repositories\Blog;

use App\Models\Blog\PostCategory as Model;
use App\Repositories\CoreRepository;

/**
 * Class BlogCategoryRepository
 *
 * @package App\Repositories
 */
class CategoryRepository extends CoreRepository
{
    /**
     * @return string
     */
    protected function getModelClass()
    {
        return Model::class;
    }

    /**
     * получить список категорий для вывода в выпадающем списке
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
