<?php

namespace Mpwar\DataProcessor\Test\Infrastructure\Stub;

use Mpwar\DataProcessor\Domain\ValueObject\RawDocumentKeyword;

class RawDocumentKeywordStub extends Stub
{
    public static function random()
    {
        return self::create(self::factory()->text);
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