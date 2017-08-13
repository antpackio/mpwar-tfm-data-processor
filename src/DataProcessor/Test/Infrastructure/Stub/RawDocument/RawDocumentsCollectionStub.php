<?php

namespace Mpwar\DataProcessor\Test\Infrastructure\Stub\RawDocument;

use Mpwar\DataProcessor\Domain\RawDocument\RawDocumentsArrayCollection;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\RawDocument\RawDocumentStub;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\Stub;

class RawDocumentsCollectionStub extends Stub
{
    public static function random()
    {

        return self::create();
    }

    public static function create(...$documents)
    {
        return new RawDocumentsArrayCollection(...$documents);
    }

    public static function withTwoDocuments()
    {
        return self::create(
            RawDocumentStub::random(),
            RawDocumentStub::random()
        );
    }
}
