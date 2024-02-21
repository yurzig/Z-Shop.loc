<?php

namespace App\Yz\Services\Traits;

trait SetColumns
{
    /**
     * Сохранение в сессии списка видимых колонок.
     */
    public function setColumns(array $fields): void
    {
        session([str($this->getModel())->snake() .'_columns' => $fields]);
    }

}
