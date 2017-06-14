<?php


namespace Mpwar\DataProcessor\Domain\Repository;

use Mpwar\DataProcessor\Domain\Entity\EnrichedDocument;

interface EnrichedDocumentsRepository
{

    public function save(EnrichedDocument $enrichedDocument): void;
}
