<?php

namespace App\Yz\Services\Traits;

use Illuminate\Http\Request;

trait Sort
{
    /**
     * Сохранение в сессии поля и направления сортировки.
     */
    public function setSort(Request $request): void
    {
        $item_name = str($this->getModel())->snake() . '_sort';

        $direction = 'asc';
        if ($request->session()->has($item_name)) {
            $sort = session($item_name);
            if ($sort[0] === $request->order) {
                $direction = $sort[1] === 'asc' ? 'desc' : 'asc';
            }
        }

        session([$item_name => [$request->order, $direction]]);
    }

    /**
     * Получение поля и направления сортировки.
     */
    public function getSort(array $defaultSort): array
    {

        return session(str($this->getModel())->snake() . '_sort', $defaultSort);
    }
}
