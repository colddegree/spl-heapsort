<?php

namespace ColdDegree\Tests;

use ColdDegree\ConstantList;
use ColdDegree\HeapSortedAscendingList;
use PHPUnit\Framework\TestCase;

class HeapSortedAscendingListTest extends TestCase
{
    public function testSortingInts(): void
    {
        self::assertSame(
            [1, 1, 1, 2, 2, 3, 42, 54],
            (new HeapSortedAscendingList(
                new ConstantList(3, 42, 2, 1, 54, 1, 1, 2),
            ))->toArray(),
        );
    }

    public function testSortingEmptyList(): void
    {
        self::assertSame(
            [],
            (new HeapSortedAscendingList(
                new ConstantList(),
            ))->toArray(),
        );
    }

    public function testSortingStrings(): void
    {
        self::assertSame(
            ['a', 'b', 'c'],
            (new HeapSortedAscendingList(
                new ConstantList('c', 'b', 'a'),
            ))->toArray(),
        );
    }
}
