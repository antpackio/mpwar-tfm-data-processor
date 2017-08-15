<?php

namespace Mpwar\DataProcessor\Test\Infrastructure\Stub;

use Mpwar\DataProcessor\Domain\Document\Author;
use Mpwar\DataProcessor\Domain\Document\AuthorLocation;
use Mpwar\DataProcessor\Domain\Document\Content;
use Mpwar\DataProcessor\Domain\Document\CreatedAt;
use Mpwar\DataProcessor\Domain\Document\Document;
use Mpwar\DataProcessor\Domain\Document\Language;
use Mpwar\DataProcessor\Domain\Document\SourceId;
use Mpwar\DataProcessor\Domain\Document\SourceKeyword;
use Mpwar\DataProcessor\Domain\Document\SourceName;

class DocumentStub extends Stub
{
    public static function random()
    {
        return self::create(
            SourceDocumentIdStub::random(),
            SourceKeywordStub::random(),
            SourceNameStub::random(),
            ContentStub::random(),
            CreatedAtStub::random(),
            AuthorStub::random(),
            AuthorLocationStub::random(),
            LanguageStub::random()
        );
    }

    public static function create(
        SourceId $sourceDocumentId,
        SourceKeyword $sourceKeyword,
        SourceName $sourceName,
        Content $content,
        CreatedAt $createdAt,
        Author $author,
        AuthorLocation $authorLocation,
        Language $language
    ) {
        return new Document(
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
