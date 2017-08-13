<?php

namespace Mpwar\DataProcessor\Domain\EnrichedDocument;

use Mpwar\DataProcessor\Domain\RawDocument\RawDocument;

interface EnrichedDocumentFactory
{
    public function build(
        RawDocument $rawDocument,
        EnrichedDocumentContent $content,
        EnrichedDocumentCreatedAt $createdAt,
        EnrichedDocumentAuthor $author,
        EnrichedDocumentAuthorLocation $authorLocation,
        EnrichedDocumentLanguage $language
    ): EnrichDocument;
}
