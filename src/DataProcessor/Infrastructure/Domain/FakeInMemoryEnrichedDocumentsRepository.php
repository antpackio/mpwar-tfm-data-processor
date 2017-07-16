<?php

namespace Mpwar\DataProcessor\Infrastructure\Domain;

use Mpwar\DataProcessor\Domain\EnrichedDocument\EnrichedDocument;
use Mpwar\DataProcessor\Domain\Repository\EnrichedDocumentsRepository;
use Mpwar\DataProcessor\Domain\ValueObject\RawDocumentId;

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
