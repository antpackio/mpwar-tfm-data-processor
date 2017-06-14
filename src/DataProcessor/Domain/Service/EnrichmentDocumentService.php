<?php


namespace Mpwar\DataProcessor\Domain\Service;

use Mpwar\DataProcessor\Domain\Entity\EnrichedDocument;

interface EnrichmentDocumentService
{

    public function execute(EnrichedDocument $document): EnrichedDocument;
}