<?php

namespace Mpwar\DataProcessor\Test\Infrastructure\Stub\EnrichedDocument;

use Mpwar\DataProcessor\Domain\EnrichedDocument\EnrichedDocumentCreatedAt;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\Stub;

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
