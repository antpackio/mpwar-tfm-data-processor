<?php


namespace Mpwar\DataProcessor\Infrastructure\Domain\Document;

use Mpwar\DataProcessor\Domain\Author;
use Mpwar\DataProcessor\Domain\AuthorLocation;
use Mpwar\DataProcessor\Domain\Content;
use Mpwar\DataProcessor\Domain\CreatedAt;
use Mpwar\DataProcessor\Domain\Document;
use Mpwar\DataProcessor\Domain\DocumentFactory;
use Mpwar\DataProcessor\Domain\Language;
use Mpwar\DataProcessor\Domain\SourceId;
use Mpwar\DataProcessor\Domain\SourceKeyword;
use Mpwar\DataProcessor\Domain\SourceName;

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