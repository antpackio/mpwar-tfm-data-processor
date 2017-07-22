<?php

namespace Mpwar\DataProcessor\Test\Infrastructure\Stub;

use Mpwar\DataProcessor\Domain\EnrichedDocument\AuthorLocation;

class EnrichedDocumentAuthorLocationStub extends Stub
{
    public static function random()
    {
        return self::create(self::factory()->text());
    }

    public static function create(String $authorLocation)
    {
        return new AuthorLocation($authorLocation);
    }
}
