<?php

declare(strict_types=1);

namespace ColdDegree;

/**
 * @see \ColdDegree\Tests\HeapSortedAscendingListTest
 */
final class HeapSortedAscendingList implements MyList
{
    private MyList $origin;

    public function __construct(MyList $origin)
    {
        $this->origin = $origin;
    }

    public function toArray(): array
    {
        $minHeap = new \SplMinHeap();
        foreach ($this->origin->toArray() as $value) {
            $minHeap->insert($value);
        }

        $sortedValues = [];
        while (!$minHeap->isEmpty()) {
            $sortedValues[] = $minHeap->extract();
        }
        return $sortedValues;
    }
}