<?php


namespace Mpwar\DataProcessor\Domain\Repository;

use Mpwar\DataProcessor\Domain\EnrichedDocument\EnrichedDocument;
use Mpwar\DataProcessor\Domain\ValueObject\RawDocumentId;

interface EnrichedDocumentsRepository
{

    public function save(EnrichedDocument $enrichedDocument): void;

    public function hasRawDocumentId(RawDocumentId $rawDocumentId): ?EnrichedDocument;
}
