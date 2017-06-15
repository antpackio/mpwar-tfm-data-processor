<?php

namespace Mpwar\DataProcessor\Domain\Entity;

use Mpwar\DataProcessor\Domain\ValueObject\RawDocumentId;
use Mpwar\DataProcessor\Domain\ValueObject\RawDocumentSource;

class EnrichedDocument
{
    private $rawDocumentId;
    private $source;

    public function __construct(RawDocumentId $rawDocumentId, RawDocumentSource $source)
    {
        $this->rawDocumentId = $rawDocumentId;
        $this->source = $source;
    }

    public function source(): RawDocumentSource
    {
        return $this->source;
    }

    public function rawDocumentId(): RawDocumentId
    {
        return $this->rawDocumentId;
    }
}