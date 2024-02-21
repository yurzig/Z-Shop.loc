<?php

namespace App\Yz\Services\Traits;

trait Columns
{
    /**
     * Сохранение в сессии списка видимых колонок.
     */
    public function setColumns(array $fields): void
    {
        session([str($this->getModel())->snake() .'_columns' => $fields]);
    }

    /**
     * Получить список видимых колонок.
     */
    public function getColumns(array $defaultFields): array
    {

        return session(str($this->getModel())->snake() .'_columns', $defaultFields);
    }

}
