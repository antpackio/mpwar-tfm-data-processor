<?php

namespace Mpwar\DataProcessor\Test\Infrastructure\Stub\EnrichedDocument;

use Mpwar\DataProcessor\Domain\EnrichedDocument\EnrichedDocumentAuthor;
use Mpwar\DataProcessor\Domain\EnrichedDocument\EnrichedDocumentAuthorLocation;
use Mpwar\DataProcessor\Domain\EnrichedDocument\EnrichedDocumentContent;
use Mpwar\DataProcessor\Domain\EnrichedDocument\EnrichedDocumentCreatedAt;
use Mpwar\DataProcessor\Domain\EnrichedDocument\EnrichDocument;
use Mpwar\DataProcessor\Domain\EnrichedDocument\EnrichedDocumentLanguage;
use Mpwar\DataProcessor\Domain\RawDocument\RawDocumentId;
use Mpwar\DataProcessor\Domain\RawDocument\RawDocumentKeyword;
use Mpwar\DataProcessor\Domain\RawDocument\RawDocumentSource;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\RawDocument\RawDocumentIdStub;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\RawDocument\RawDocumentKeywordStub;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\RawDocument\RawDocumentSourceStub;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\Stub;

class EnrichedDocumentStub extends Stub
{
    public static function random()
    {

        return self::create(
            RawDocumentIdStub::random(),
            RawDocumentKeywordStub::random(),
            RawDocumentSourceStub::random(),
            EnrichedDocumentContentStub::random(),
            EnrichedDocumentCreatedAtStub::random(),
            EnrichedDocumentAuthorStub::random(),
            EnrichedDocumentAuthorLocationStub::random(),
            EnrichedDocumentLanguageStub::random()
        );
    }

    public static function create(
        RawDocumentId $rawDocumentId,
        RawDocumentKeyword $rawDocumentKeyword,
        RawDocumentSource $rawDocumentSource,
        EnrichedDocumentContent $content,
        EnrichedDocumentCreatedAt $createdAt,
        EnrichedDocumentAuthor $author,
        EnrichedDocumentAuthorLocation $authorLocation,
        EnrichedDocumentLanguage $language
    )
    {
        return new EnrichDocument(
            $rawDocumentId,
            $rawDocumentKeyword,
            $rawDocumentSource,
            $content,
            $createdAt,
            $author,
            $authorLocation,
            $language
        );
    }
}