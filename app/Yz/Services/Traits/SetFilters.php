<?php

namespace App\Yz\Services\Traits;

trait SetFilters
{
    /**
     * Сохранение в сессии примененных фильтров.
     */
    public function setFilters(array $filters): void
    {
        session([str($this->getModel())->snake() . '_filters' => $filters]);
    }

}
