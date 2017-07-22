<?php

namespace Mpwar\DataProcessor\Domain\EnrichmentService;

use Mpwar\DataProcessor\Domain\EnrichedDocument\EnrichedDocument;

interface EnrichmentDocumentService
{
    public function execute(EnrichedDocument $document): EnrichedDocument;
}
