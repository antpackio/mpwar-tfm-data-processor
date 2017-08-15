<?php

namespace Mpwar\DataProcessor\Test\Infrastructure\Stub;

use Mpwar\DataProcessor\Domain\Document\Language;

class LanguageStub extends Stub
{
    public static function random()
    {
        return self::create(self::factory()->languageCode);
    }

    public static function create($value)
    {
        return new Language($value);
    }
}
