<?php

namespace ColdDegree\Tests;

use PHPUnit\Framework\TestCase;

class SampleTest extends TestCase
{
    public function test(): void
    {
        self::assertSame(4, 2 + 2);
    }
}
