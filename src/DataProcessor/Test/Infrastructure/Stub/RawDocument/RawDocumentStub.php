<?php

namespace Mpwar\DataProcessor\Test\Infrastructure\Stub\RawDocument;

use Mpwar\DataProcessor\Domain\RawDocument\RawDocument;
use Mpwar\DataProcessor\Domain\RawDocument\RawDocumentContent;
use Mpwar\DataProcessor\Domain\RawDocument\RawDocumentId;
use Mpwar\DataProcessor\Domain\RawDocument\RawDocumentKeyword;
use Mpwar\DataProcessor\Domain\RawDocument\RawDocumentSource;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\RawDocument\RawDocumentContentStub;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\RawDocument\RawDocumentIdStub;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\RawDocument\RawDocumentKeywordStub;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\RawDocument\RawDocumentSourceStub;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\Stub;

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

    public static function create(
        RawDocumentId $id,
        RawDocumentSource $source,
        RawDocumentKeyword $keyword,
        RawDocumentContent $content)
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

    public static function validFromTwitterWithNullLanguageAndAuthorFields()
    {
        return self::create(
            RawDocumentIdStub::random(),
            RawDocumentSourceStub::twitter(),
            RawDocumentKeywordStub::random(),
            RawDocumentContentStub::validFromTwitterWithNullLanguageAndAuthorFields()
        );

    }

    public static function withCustomKeyword($keyword)
    {
        return self::create(
            RawDocumentIdStub::random(),
            RawDocumentSourceStub::random(),
            RawDocumentKeywordStub::create($keyword),
            RawDocumentContentStub::random()
        );
    }
}