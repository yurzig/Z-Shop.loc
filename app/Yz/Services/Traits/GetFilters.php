<?php

namespace App\Yz\Services\Traits;

trait GetFilters
{
    /**
     * Получение примененных фильтров.
     */
    public function getFilters(): array
    {

        return session(str($this->getModel())->snake() . '_filters', []);
    }
}
