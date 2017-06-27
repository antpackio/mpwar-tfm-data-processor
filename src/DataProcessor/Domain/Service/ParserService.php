<?php

namespace Mpwar\DataProcessor\Domain\Service;

use Mpwar\DataProcessor\Domain\Entity\EnrichedDocument;

interface ParserService
{
    public function execute(EnrichedDocument $enrichedDocument): EnrichedDocument;
}