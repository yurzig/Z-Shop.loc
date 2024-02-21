<?php

namespace App\Yz\Services\Traits;

trait GetColumns
{
    /**
     * Получить список видимых колонок.
     */
    public function getColumns(array $defaultFields): array
    {

        return session(str($this->getModel())->snake() .'_columns', $defaultFields);
    }
    
}
