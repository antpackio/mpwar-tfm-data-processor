<?php

namespace Mpwar\DataProcessor\Test\Infrastructure\Stub;

use Mpwar\DataProcessor\Domain\Entity\RawDocument;
use Mpwar\DataProcessor\Domain\ValueObject\RawDocumentContent;
use Mpwar\DataProcessor\Domain\ValueObject\RawDocumentId;
use Mpwar\DataProcessor\Domain\ValueObject\RawDocumentSource;

class RawDocumentStub extends Stub
{
    public static function random()
    {

        return self::create(
            RawDocumentIdStub::random(),
            RawDocumentSourceStub::random(),
            RawDocumentContentStub::random()
        );
    }

    public static function create(RawDocumentId $id, RawDocumentSource $source, RawDocumentContent $content)
    {
        return new RawDocument($id, $source, $content);
    }

    public static function randomFromTwitter()
    {
        return self::create(
            RawDocumentIdStub::random(),
            RawDocumentSourceStub::twitter(),
            RawDocumentContentStub::random()
        );
    }

    public static function withInvalidSource()
    {

        return self::create(
            RawDocumentIdStub::random(),
            RawDocumentSourceStub::invalid(),
            RawDocumentContentStub::random()
        );
    }

    public static function emptyFromTwitter()
    {
        return self::create(
            RawDocumentIdStub::random(),
            RawDocumentSourceStub::twitter(),
            RawDocumentContentStub::empty()
        );
    }

    public static function customContentFromTwitter(string $content)
    {
        return self::create(
            RawDocumentIdStub::random(),
            RawDocumentSourceStub::twitter(),
            RawDocumentContentStub::create($content)
        );
    }

    public static function validFromTwitter()
    {
    }
}