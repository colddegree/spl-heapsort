<?php

declare(strict_types=1);

namespace ColdDegree;

final class IntList implements MyList
{
    private array $values;

    public function __construct(int ...$values)
    {
        $this->values = $values;
    }

    public static function fromStrings(string ...$values): self
    {
        foreach ($values as $value) {
            if (!(new IsInt($value))->toBool()) {
                throw new \DomainException("Non int value received: \"$value\"");
            }
        }
        return new self(...array_map('\intval', $values));
    }

    public function toArray(): array
    {
        return $this->values;
    }
}