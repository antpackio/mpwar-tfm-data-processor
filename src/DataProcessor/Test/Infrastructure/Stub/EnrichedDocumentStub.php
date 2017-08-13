<?php

namespace Mpwar\DataProcessor\Test\Infrastructure\Stub;

use Mpwar\DataProcessor\Domain\Document;
use Mpwar\DataProcessor\Domain\EnrichedDocument;

class EnrichedDocumentStub extends Stub
{
    public static function create(
        Document $document
    ) {
        return EnrichedDocument::fromDocument($document);
    }
    public static function random()
    {
        return self::create(
            DocumentStub::random()
        );
    }
}
