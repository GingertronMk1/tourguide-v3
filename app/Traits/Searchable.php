<?php

declare(strict_types=1);

namespace App\Traits;

trait Searchable
{
    public function getFields(): array
    {
        return $this->toArray();
    }
}
