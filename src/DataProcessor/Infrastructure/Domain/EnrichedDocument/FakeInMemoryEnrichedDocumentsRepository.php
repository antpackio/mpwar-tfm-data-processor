<?php

namespace Mpwar\DataProcessor\Infrastructure\Domain\EnrichedDocument;

use Mpwar\DataProcessor\Domain\EnrichedDocument;
use Mpwar\DataProcessor\Domain\EnrichedDocument\EnrichedDocumentsRepository;
use Mpwar\DataProcessor\Domain\RawDocument\RawDocumentId;

class FakeInMemoryEnrichedDocumentsRepository implements EnrichedDocumentsRepository
{

    public function save(EnrichedDocument $enrichedDocument): void
    {
        echo "EnrichedDocument saved\n";
        return;
    }

    public function hasRawDocumentId(RawDocumentId $rawDocumentId): ?EnrichedDocument
    {
        return null;
    }
}
