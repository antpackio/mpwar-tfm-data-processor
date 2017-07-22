<?php

namespace Mpwar\DataProcessor\Domain\RawDocument;

use Mpwar\DataProcessor\Domain\DataType\Collection;

class RawDocumentsCollection extends Collection
{

    protected function typeOfCollection(): string
    {
        return RawDocument::class;
    }
}