<?php

namespace Mpwar\DataProcessor\Test\Infrastructure\Stub\EnrichedDocument;

use Mpwar\DataProcessor\Domain\EnrichedDocument\EnrichedDocumentContent;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\Stub;

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