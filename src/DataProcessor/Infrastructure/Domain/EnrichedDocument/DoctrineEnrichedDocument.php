<?php

namespace Mpwar\DataProcessor\Infrastructure\Domain\EnrichedDocument;

use Mpwar\DataProcessor\Domain\EnrichedDocument\EnrichedDocument;

class DoctrineEnrichedDocument extends EnrichedDocument
{
    private $id;

    public function __construct(EnrichedDocument $enrichedDocument)
    {
        parent::__construct(
            $enrichedDocument->rawDocumentId(),
            $enrichedDocument->keyword(),
            $enrichedDocument->source(),
            $enrichedDocument->content(),
            $enrichedDocument->createdAt(),
            $enrichedDocument->author(),
            $enrichedDocument->authorLocation(),
            $enrichedDocument->language()
        );

        $this->id = null;
        $this->metadata = $enrichedDocument->metadata();
    }
}
