<?php

namespace App\Yz\Services\Traits;

trait Test
{
    public function test()
    {
        dd(__METHOD__, $this->getModel());
    }
}
