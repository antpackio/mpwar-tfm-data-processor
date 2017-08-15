<?php


namespace Mpwar\DataProcessor\Infrastructure\Domain\Document;

use Mpwar\DataProcessor\Domain\Document\Author;
use Mpwar\DataProcessor\Domain\Document\AuthorLocation;
use Mpwar\DataProcessor\Domain\Document\Content;
use Mpwar\DataProcessor\Domain\Document\CreatedAt;
use Mpwar\DataProcessor\Domain\Document\Document;
use Mpwar\DataProcessor\Domain\Document\DocumentFactory;
use Mpwar\DataProcessor\Domain\Document\Language;
use Mpwar\DataProcessor\Domain\Document\SourceId;
use Mpwar\DataProcessor\Domain\Document\SourceKeyword;
use Mpwar\DataProcessor\Domain\Document\SourceName;

class DoctrineDocumentFactory implements DocumentFactory
{

    public function build(
        SourceId $sourceDocumentId,
        SourceKeyword $sourceKeyword,
        SourceName $sourceName,
        Content $content,
        CreatedAt $createdAt,
        Author $author,
        AuthorLocation $authorLocation,
        Language $language
    ): Document
    {
        return new DoctrineDocument(
            $sourceDocumentId,
            $sourceKeyword,
            $sourceName,
            $content,
            $createdAt,
            $author,
            $authorLocation,
            $language
        );
    }
}