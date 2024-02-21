<?php

namespace App\Yz\Services\Traits;

trait ResetFilters
{
    /**
     * Сброс и сохранение в сессии примененных фильтров.
     */
    public function resetFilters(): void
    {
        session([str($this->getModel())->snake() . '_filter' => []]);
    }
}
