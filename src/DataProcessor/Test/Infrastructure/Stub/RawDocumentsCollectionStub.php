<?php

namespace Mpwar\DataProcessor\Test\Infrastructure\Stub;

use Mpwar\DataProcessor\Domain\ValueObject\RawDocumentsCollection;

class RawDocumentsCollectionStub extends Stub
{
    public static function random()
    {

        return self::create();
    }

    public static function create(...$documents)
    {
        return new RawDocumentsCollection(...$documents);
    }

    public static function withTwoDocuments()
    {
        return self::create(
            RawDocumentStub::random(),
            RawDocumentStub::random()
        );
    }
}
