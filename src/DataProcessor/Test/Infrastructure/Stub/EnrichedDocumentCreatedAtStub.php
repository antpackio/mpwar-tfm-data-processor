<?php

namespace Mpwar\DataProcessor\Test\Infrastructure\Stub;

use Mpwar\DataProcessor\Domain\EnrichedDocument\CreatedAt;

class EnrichedDocumentCreatedAtStub extends Stub
{
    public static function random()
    {

        return self::create(self::factory()->date());
    }

    public static function create(string $string): CreatedAt
    {
        return new CreatedAt($string);
    }
}
