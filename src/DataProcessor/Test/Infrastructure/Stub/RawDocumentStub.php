<?php

namespace Mpwar\DataProcessor\Test\Infrastructure\Stub;

use Mpwar\DataProcessor\Domain\Entity\RawDocument;
use Mpwar\DataProcessor\Domain\ValueObject\RawDocumentId;
use Mpwar\DataProcessor\Domain\ValueObject\RawDocumentSource;

class RawDocumentStub extends Stub
{
    public static function random()
    {

        return self::create(
            RawDocumentIdStub::random(),
            RawDocumentSourceStub::random()
        );
    }

    public static function create(RawDocumentId $id, RawDocumentSource $source)
    {
        return new RawDocument($id, $source);
    }

    public static function randomFromTwitter()
    {
        return self::create(
            RawDocumentIdStub::random(),
            RawDocumentSourceStub::twitter()
        );
    }
}