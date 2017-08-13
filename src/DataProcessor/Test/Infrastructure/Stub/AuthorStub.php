<?php

namespace Mpwar\DataProcessor\Test\Infrastructure\Stub;

use Mpwar\DataProcessor\Domain\Author;

class AuthorStub extends Stub
{
    public static function create($value)
    {
        return new Author($value);
    }
    public static function random()
    {
        return self::create(self::factory()->name);
    }
}
