<?php

namespace App\Repositories\Blog;

use App\Models\Blog\PostReview as Model;
use App\Repositories\CoreRepository;

/**
 * Class ReviewRepository
 *
 * @package App\Repositories
 */
class ReviewRepository extends CoreRepository
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
     * Получить все отзывы на статью.
     *
     * @param int $id
     *
     * @return Model
     */
    public function getByPost(int $post_id)
    {
        return $this->startConditions()
            ->where('post_id', $post_id)
            ->orderBy('created_at', 'desc')
            ->get();
    }
    /**
     * Получить среднее значение рейтинга продукта.
     *
     * @param int $product_id
     *
     * @return int $ratingAvg
     */
//    public function getRatingAvg(int $product_id)
//    {
//        return $this->startConditions()
//            ->where('product_id', $product_id)
//            ->where('status', Model::OPUBLIKOVAN)
//            ->avg('rating');
//    }

}
