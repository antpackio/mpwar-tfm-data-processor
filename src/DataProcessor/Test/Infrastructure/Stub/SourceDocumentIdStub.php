<?php

namespace Mpwar\DataProcessor\Test\Infrastructure\Stub;

use Mpwar\DataProcessor\Domain\SourceId;

class SourceDocumentIdStub extends Stub
{
    public static function random()
    {
        return self::create(self::factory()->uuid);
    }

    public static function create($value)
    {
        return new SourceId($value);
    }
}
