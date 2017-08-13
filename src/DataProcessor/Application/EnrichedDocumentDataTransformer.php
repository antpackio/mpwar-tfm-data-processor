<?php

namespace Mpwar\DataProcessor\Application;

use Mpwar\DataProcessor\Domain\EnrichedDocument;

interface EnrichedDocumentDataTransformer
{
    public function transform(EnrichedDocument $document);
}
