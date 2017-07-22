<?php

namespace Mpwar\DataProcessor\Test\Infrastructure\Stub;

use Mpwar\DataProcessor\Domain\EnrichedDocument\Language;

class EnrichedDocumentLanguageStub extends Stub
{
    public static function random()
    {
        return self::create(self::factory()->text());
    }

    public static function create(String $language)
    {
        return new Language($language);
    }
}
