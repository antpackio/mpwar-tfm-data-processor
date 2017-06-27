<?php

namespace Mpwar\DataProcessor\Test\Infrastructure\Stub;

use Mpwar\DataProcessor\Domain\ValueObject\EnrichedDocumentContent;

class EnrichedDocumentContentStub extends Stub
{
    public static function random()
    {
        return self::create(self::factory()->text());
    }

    public static function create(String $content)
    {
        return new EnrichedDocumentContent($content);
    }

}