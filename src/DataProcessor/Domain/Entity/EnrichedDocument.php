<?php

namespace Mpwar\DataProcessor\Domain\Entity;

use Mpwar\DataProcessor\Domain\ValueObject\EnrichedDocumentContent;
use Mpwar\DataProcessor\Domain\ValueObject\RawDocumentId;
use Mpwar\DataProcessor\Domain\ValueObject\RawDocumentSource;

class EnrichedDocument
{
    private $rawDocumentId;
    private $source;
    private $content;

    public function __construct(RawDocumentId $rawDocumentId, RawDocumentSource $source, EnrichedDocumentContent $content)
    {
        $this->rawDocumentId = $rawDocumentId;
        $this->source = $source;
        $this->content = $content;
    }

    public function source(): RawDocumentSource
    {
        return $this->source;
    }

    public function content(): EnrichedDocumentContent
    {
        return $this->content;
    }

    public function rawDocumentId(): RawDocumentId
    {
        return $this->rawDocumentId;
    }
}