<?php

declare(strict_types=1);

namespace ColdDegree;

final class IsInt
{
    private string $str;

    public function __construct(string $str)
    {
        $this->str = $str;
    }

    public function toBool(): bool
    {
        return preg_match('/^\d+$/', $this->str) === 1;
    }
}