<?php

namespace Mpwar\DataProcessor\Domain\Parser;

use Mpwar\DataProcessor\Domain\EnrichedDocument\EnrichedDocument;

interface ParserService
{
    public function execute(EnrichedDocument $enrichedDocument): EnrichedDocument;
}