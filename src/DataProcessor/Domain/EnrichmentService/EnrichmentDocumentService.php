<?php

namespace Mpwar\DataProcessor\Domain\EnrichmentService;

use Mpwar\DataProcessor\Domain\Document;
use Mpwar\DataProcessor\Domain\EnrichedDocument;

interface EnrichmentDocumentService
{
    public function execute(Document $documentdocument): EnrichedDocument;
}
