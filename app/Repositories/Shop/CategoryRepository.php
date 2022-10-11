<?php

namespace App\Repositories\Shop;

use App\Models\Media;
use App\Models\Shop\Category as Model;
use App\Repositories\CoreRepository;

/**
 * Class ShopCategoryRepository
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
     * получить список категорий в виде дерева методом Tommy Lacroix
     *
     * @return array
     */
    public function getTree()
    {
        $categories = $this
            ->startConditions()
            ->select('id', 'title', 'parent_id')
            ->toBase()
            ->get();

        $dataSet = [];
        foreach ($categories as $row) {
            $dataSet[$row->id] = ['id' => $row->id, 'title' => $row->title, 'parent' => $row->parent_id];
        }

        $tree = [];
        foreach ($dataSet as $id => &$node) {
            if (!$node['parent']) {
                $tree[$id] = &$node;
            } else {
                $dataSet[$node['parent']]['children'][$id] = &$node;
            }
        }
        return $tree;
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

    /**
     * Получить запись по слагу
     *
     * @return Model
     */
    public function getBySlug($slug)
    {
        $result = $this
            ->startConditions()
            ->where('slug',  $slug)
            ->first();

        return $result;
    }
    public function getBySlugs($slug)
    {
        $result = $this
            ->startConditions()
            ->where('slug',  $slug)
            ->get();

        return $result;
    }

//    public function getParent($slug)
//    {
//        $result = $this
//            ->startConditions()
//            ->where('slug', $slug)
//            ->with(['children', 'product'])
//            ->first();
//
//        return $result;
//    }
//    /**
//     * Получить все категории 2-го уровня с картинками
//     *
//     * @return Model
//     */
//    public function getSecondLevel()
//    {
//        $result = $this
//            ->startConditions()
//            ->whereNotIn('parent_id', [0, 1])
//            ->with('media')
//            ->get();
//        return $result;
//
//    }
}
