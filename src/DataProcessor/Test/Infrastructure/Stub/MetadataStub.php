<?php

namespace Mpwar\DataProcessor\Test\Infrastructure\Stub;

use Mpwar\DataProcessor\Domain\Document\Metadata;

class MetadataStub extends Stub
{
    public static function create(string $name, string $value)
    {
        return new Metadata($name, $value);
    }
    public static function random()
    {
        return self::create(self::factory()->domainName, self::factory()->word);
    }
}
