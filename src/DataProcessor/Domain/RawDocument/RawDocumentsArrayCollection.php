<?php

namespace Mpwar\DataProcessor\Domain\RawDocument;

use Mpwar\DataProcessor\Domain\DataType\ArrayCollection;

class RawDocumentsArrayCollection extends ArrayCollection
{

    protected function typeOfCollection(): string
    {
        return RawDocument::class;
    }
}