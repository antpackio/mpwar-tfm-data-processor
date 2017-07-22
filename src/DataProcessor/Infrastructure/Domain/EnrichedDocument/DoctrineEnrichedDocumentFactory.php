<?php


namespace Mpwar\DataProcessor\Infrastructure\Domain\EnrichedDocument;


use Mpwar\DataProcessor\Domain\EnrichedDocument\EnrichedDocument;
use Mpwar\DataProcessor\Domain\EnrichedDocument\EnrichedDocumentAuthor;
use Mpwar\DataProcessor\Domain\EnrichedDocument\EnrichedDocumentAuthorLocation;
use Mpwar\DataProcessor\Domain\EnrichedDocument\EnrichedDocumentContent;
use Mpwar\DataProcessor\Domain\EnrichedDocument\EnrichedDocumentCreatedAt;
use Mpwar\DataProcessor\Domain\EnrichedDocument\EnrichedDocumentFactory;
use Mpwar\DataProcessor\Domain\EnrichedDocument\EnrichedDocumentLanguage;
use Mpwar\DataProcessor\Domain\RawDocument\RawDocument;

class DoctrineEnrichedDocumentFactory implements EnrichedDocumentFactory
{

    public function build(
        RawDocument $rawDocument,
        EnrichedDocumentContent $content,
        EnrichedDocumentCreatedAt $createdAt,
        EnrichedDocumentAuthor $author,
        EnrichedDocumentAuthorLocation $authorLocation,
        EnrichedDocumentLanguage $language
    ): EnrichedDocument
    {
        return new DoctrineEnrichedDocument(
            $rawDocument->id(),
            $rawDocument->keyword(),
            $rawDocument->source(),
            $content,
            $createdAt,
            $author,
            $authorLocation,
            $language
        );
    }
}