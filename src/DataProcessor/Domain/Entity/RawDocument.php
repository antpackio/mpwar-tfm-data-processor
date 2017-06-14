<?php

namespace Mpwar\DataProcessor\Domain\Entity;

use Mpwar\DataProcessor\Domain\ValueObject\RawDocumentId;

class RawDocument
{
    private $id;

    public function __construct(RawDocumentId $id)
    {
        $this->id = $id;
    }

    public function id(): RawDocumentId
    {
        return $this->id;
    }
}
