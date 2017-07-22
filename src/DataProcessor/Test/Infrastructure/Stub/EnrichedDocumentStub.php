<?php

namespace Mpwar\DataProcessor\Test\Infrastructure\Stub;

use Mpwar\DataProcessor\Domain\EnrichedDocument\Content;
use Mpwar\DataProcessor\Domain\EnrichedDocument\EnrichedDocument;
use Mpwar\DataProcessor\Domain\RawDocument\RawDocument;

class EnrichedDocumentStub extends Stub
{
    public static function random()
    {

        return self::create(RawDocumentStub::random());
    }

    public static function create(
        RawDocument $rawDocument,
        EnrichedDocumentContent $content,
        EnrichedDocumentCreatedAt $createdAt,
        EnrichedDocumentAuthor $author,
        EnrichedDocumentAuthorLocation $authorLocation,
        EnrichedDocumentLanguage $language
    )
    {
        return new EnrichedDocument(

        );
    }

    public static function customContent(RawDocument $rawDocument, Content $content)
    {
        $enrichedDocument = self::create($rawDocument);
        $enrichedDocument->setContent($content);
        return $enrichedDocument;
    }
}