<?php

namespace Mpwar\DataProcessor\Test\Infrastructure\Stub;

use Mpwar\DataProcessor\Domain\Author;
use Mpwar\DataProcessor\Domain\AuthorLocation;
use Mpwar\DataProcessor\Domain\Content;
use Mpwar\DataProcessor\Domain\CreatedAt;
use Mpwar\DataProcessor\Domain\Document;
use Mpwar\DataProcessor\Domain\Language;
use Mpwar\DataProcessor\Domain\SourceDocumentId;
use Mpwar\DataProcessor\Domain\SourceKeyword;
use Mpwar\DataProcessor\Domain\SourceName;

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
        SourceDocumentId $sourceDocumentId,
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
