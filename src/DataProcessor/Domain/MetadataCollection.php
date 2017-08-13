<?php

namespace Mpwar\DataProcessor\Domain;

use Mpwar\DataProcessor\Domain\DataType\ArrayCollection;

class MetadataCollection extends ArrayCollection
{

    /**
     * @return string Type of Objects inside collection FQN
     */
    protected function typeOfCollection(): string
    {
        return Metadata::class;
    }
}
