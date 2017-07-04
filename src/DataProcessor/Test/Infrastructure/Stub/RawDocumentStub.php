<?php

namespace Mpwar\DataProcessor\Test\Infrastructure\Stub;

use Mpwar\DataProcessor\Domain\Entity\RawDocument;
use Mpwar\DataProcessor\Domain\ValueObject\RawDocumentContent;
use Mpwar\DataProcessor\Domain\ValueObject\RawDocumentId;
use Mpwar\DataProcessor\Domain\ValueObject\RawDocumentKeyword;
use Mpwar\DataProcessor\Domain\ValueObject\RawDocumentSource;

class RawDocumentStub extends Stub
{
    public static function random()
    {

        return self::create(
            RawDocumentIdStub::random(),
            RawDocumentSourceStub::random(),
            RawDocumentKeywordStub::random(),
            RawDocumentContentStub::random()
        );
    }

    public static function create(RawDocumentId $id, RawDocumentSource $source, RawDocumentKeyword $keyword, RawDocumentContent $content)
    {
        return new RawDocument($id, $source, $keyword, $content);
    }

    public static function randomFromTwitter()
    {
        return self::create(
            RawDocumentIdStub::random(),
            RawDocumentSourceStub::twitter(),
            RawDocumentKeywordStub::random(),
            RawDocumentContentStub::random()
        );
    }

    public static function withInvalidSource()
    {

        return self::create(
            RawDocumentIdStub::random(),
            RawDocumentSourceStub::invalid(),
            RawDocumentKeywordStub::random(),
            RawDocumentContentStub::random()
        );
    }

    public static function emptyFromTwitter()
    {
        return self::create(
            RawDocumentIdStub::random(),
            RawDocumentSourceStub::twitter(),
            RawDocumentKeywordStub::random(),
            RawDocumentContentStub::empty()
        );
    }

    public static function customContentFromTwitter(string $content)
    {
        return self::create(
            RawDocumentIdStub::random(),
            RawDocumentSourceStub::twitter(),
            RawDocumentKeywordStub::random(),
            RawDocumentContentStub::create($content)
        );
    }

    public static function validFromTwitter()
    {
        return self::create(
            RawDocumentIdStub::random(),
            RawDocumentSourceStub::twitter(),
            RawDocumentKeywordStub::random(),
            RawDocumentContentStub::validFromTwitter()
        );
    }

    public static function invalidStructureFromTwitter()
    {
        return self::create(
            RawDocumentIdStub::random(),
            RawDocumentSourceStub::twitter(),
            RawDocumentKeywordStub::random(),
            RawDocumentContentStub::nonWellFormedTweet()
        );
    }
}