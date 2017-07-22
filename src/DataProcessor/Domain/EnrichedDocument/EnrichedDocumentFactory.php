<?php

namespace Mpwar\DataProcessor\Domain\EnrichedDocument;

use Mpwar\DataProcessor\Domain\RawDocument\RawDocument;

interface EnrichedDocumentFactory
{
    public function build(
        RawDocument $rawDocument,
        Content $content,
        CreatedAt $createdAt,
        Author $author,
        AuthorLocation $authorLocation,
        Language $language
    ): EnrichedDocument;
}
