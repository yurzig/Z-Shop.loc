<?php

namespace App\Yz\Services\Traits;

trait Filters
{
    /**
     * Сохранение в сессии примененных фильтров.
     */
    public function setFilters(array $filters): void
    {
        session([str($this->getModel())->snake() . '_filters' => $filters]);
    }

    /**
     * Получение примененных фильтров.
     */
    public function getFilters(): array
    {

        return session(str($this->getModel())->snake() . '_filters', []);
    }

    /**
     * Сброс и сохранение в сессии примененных фильтров.
     */
    public function resetFilters(): void
    {
        session([str($this->getModel())->snake() . '_filter' => []]);
    }
}
