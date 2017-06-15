<?php

namespace Mpwar\DataProcessor\Test\Infrastructure\Stub;

use Mpwar\DataProcessor\Domain\Entity\EnrichedDocument;
use Mpwar\DataProcessor\Domain\Entity\RawDocument;
use Mpwar\DataProcessor\Domain\ValueObject\RawDocumentId;
use Mpwar\DataProcessor\Domain\ValueObject\RawDocumentSource;

class EnrichedDocumentStub extends Stub
{
    public static function random()
    {

        return self::create(
            RawDocumentIdStub::random(),
            RawDocumentSourceStub::random()
        );
    }

    public static function create(RawDocumentId $rawDocumentId, RawDocumentSource $source)
    {
        return new EnrichedDocument($rawDocumentId, $source);
    }

    public static function fromRawDocument(RawDocument $rawDocument)
    {
        return self::create($rawDocument->id(), $rawDocument->source());
    }
}