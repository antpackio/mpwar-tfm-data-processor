<?php

namespace Mpwar\DataProcessor\Test\Infrastructure\Stub;

use Mpwar\DataProcessor\Domain\AuthorLocation;

class AuthorLocationStub extends Stub
{
    public static function random()
    {
        return self::create(self::factory()->country);
    }

    public static function create($value)
    {
        return new AuthorLocation($value);
    }
}
