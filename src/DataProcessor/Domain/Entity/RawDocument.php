<?php

namespace Mpwar\DataProcessor\Domain\Entity;

use Mpwar\DataProcessor\Domain\ValueObject\RawDocumentId;
use Mpwar\DataProcessor\Domain\ValueObject\RawDocumentSource;

class RawDocument
{
    private $id;
    private $source;

    public function __construct(RawDocumentId $id, RawDocumentSource $source)
    {
        $this->id = $id;
        $this->source = $source;
    }

    public function source(): RawDocumentSource
    {
        return $this->source;
    }

    public function id(): RawDocumentId
    {
        return $this->id;
    }
}
