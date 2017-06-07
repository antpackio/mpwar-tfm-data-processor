<?php

namespace Mpwar\DataProcessor\Test\Infrastructure;

use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

class UnitTestCase extends TestCase
{
    public function mock(string $interface): MockInterface
    {
        return Mockery::mock($interface);
    }

    public function tearDown()
    {
        parent::tearDown();
        Mockery::close();
    }
}