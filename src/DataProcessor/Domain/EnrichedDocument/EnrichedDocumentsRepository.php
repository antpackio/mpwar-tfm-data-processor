<?php


namespace Mpwar\DataProcessor\Domain\EnrichedDocument;

use Mpwar\DataProcessor\Domain\RawDocument\RawDocumentId;

interface EnrichedDocumentsRepository
{

    public function save(EnrichedDocument $enrichedDocument): void;

    public function hasRawDocumentId(RawDocumentId $rawDocumentId): ?EnrichedDocument;
}
