<?php

namespace Mpwar\DataProcessor\Test\Infrastructure\Stub;

use Mpwar\DataProcessor\Domain\Document\SourceName;

class SourceNameStub extends Stub
{
    public static function create($value)
    {
        return new SourceName($value);
    }
    public static function random()
    {
        return self::create(self::factory()->domainName);
    }
}
