<?php

namespace Mpwar\DataProcessor\Test\Infrastructure\Stub;

use Mpwar\DataProcessor\Domain\ValueObject\EnrichedDocumentCreatedAt;

class EnrichedDocumentCreatedAtStub extends Stub
{
    public static function random()
    {

        return self::create(self::factory()->date());
    }

    public static function create(string $string): EnrichedDocumentCreatedAt
    {
        return new EnrichedDocumentCreatedAt($string);
    }
}
