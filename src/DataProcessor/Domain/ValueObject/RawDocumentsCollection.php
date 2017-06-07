<?php

namespace Mpwar\DataProcessor\Domain\ValueObject;

use Mpwar\DataProcessor\Domain\Entity\RawDocument;

class RawDocumentsCollection extends Collection
{

    protected function typeOfCollection(): string
    {
        return RawDocument::class;
    }
}