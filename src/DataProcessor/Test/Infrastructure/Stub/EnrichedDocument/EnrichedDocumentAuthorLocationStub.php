<?php

namespace Mpwar\DataProcessor\Test\Infrastructure\Stub\EnrichedDocument;

use Mpwar\DataProcessor\Domain\EnrichedDocument\EnrichedDocumentAuthorLocation;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\Stub;

class EnrichedDocumentAuthorLocationStub extends Stub
{
    public static function random()
    {
        return self::create(self::factory()->text());
    }

    public static function create(String $authorLocation)
    {
        return new EnrichedDocumentAuthorLocation($authorLocation);
    }
}
