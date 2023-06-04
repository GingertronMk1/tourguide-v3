<?php

namespace App\Traits;

trait Searchable
{
    public function getFields(): array
    {
        return $this->toArray();
    }
}
