<?php

namespace Mpwar\DataProcessor\Test\Infrastructure\Stub;

use Mpwar\DataProcessor\Domain\RawDocument\RawDocumentKeyword;

class RawDocumentKeywordStub extends Stub
{
    public static function random()
    {
        return self::create(self::factory()->word);
    }

    public static function create(string $content)
    {
        return new RawDocumentKeyword($content);
    }

    public static function empty()
    {
        return self::create("");
    }
}
