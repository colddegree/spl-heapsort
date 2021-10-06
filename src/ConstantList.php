<?php

declare(strict_types=1);

namespace ColdDegree;

final class ConstantList implements MyList
{
    private $values;

    public function __construct(...$values)
    {
        $this->values = $values;
    }

    public function toArray(): array
    {
        return $this->values;
    }
}