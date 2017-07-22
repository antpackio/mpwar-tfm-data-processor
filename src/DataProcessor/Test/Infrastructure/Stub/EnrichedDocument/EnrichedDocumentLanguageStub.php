<?php

namespace Mpwar\DataProcessor\Test\Infrastructure\Stub\EnrichedDocument;

use Mpwar\DataProcessor\Domain\EnrichedDocument\EnrichedDocumentLanguage;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\Stub;

class EnrichedDocumentLanguageStub extends Stub
{
    public static function random()
    {
        return self::create(self::factory()->text());
    }

    public static function create(String $language)
    {
        return new EnrichedDocumentLanguage($language);
    }
}
