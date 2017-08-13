<?php

namespace Mpwar\DataProcessor\Test\Infrastructure\Stub;

use Mpwar\DataProcessor\Domain\SourceKeyword;

class SourceKeywordStub extends Stub
{
    public static function create($value)
    {
        return new SourceKeyword($value);
    }
    public static function random()
    {
        return self::create(self::factory()->word);
    }
}
