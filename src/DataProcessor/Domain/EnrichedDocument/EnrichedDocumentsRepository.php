<?php

namespace Mpwar\DataProcessor\Domain\EnrichedDocument;

use Mpwar\DataProcessor\Domain\EnrichedDocument;

interface EnrichedDocumentsRepository
{

    public function save(EnrichedDocument $enrichedDocument): void;
}
