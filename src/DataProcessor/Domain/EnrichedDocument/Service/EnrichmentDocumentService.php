<?php


namespace Mpwar\DataProcessor\Domain\EnrichedDocument\Service;

use Mpwar\DataProcessor\Domain\EnrichedDocument\EnrichedDocument;

interface EnrichmentDocumentService
{

    public function execute(EnrichedDocument $document): EnrichedDocument;
}