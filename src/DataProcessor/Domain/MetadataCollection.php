<?php

namespace Mpwar\DataProcessor\Domain;

use Mpwar\DataProcessor\Domain\DataType\ArrayCollection;

class MetadataCollection extends ArrayCollection
{
    public function get(string $metadataName): ?Metadata
    {
        $itemsFound = array_filter($this->items, $this->metadataNameFilter($metadataName));

        return array_shift($itemsFound);
    }

    public function merge(MetadataCollection $metadataCollection)
    {
        $this->items = array_merge($this->items, $metadataCollection->toArray());
    }

    public function toArray(): array
    {
        return $this->items;
    }

    /**
     * @return string Type of Objects inside collection FQN
     */
    protected function typeOfCollection(): string
    {
        return Metadata::class;
    }

    /**
     * @param string $metadataName
     * @return \Closure
     */
    private function metadataNameFilter(string $metadataName): \Closure
    {
        return function ($item) use ($metadataName) {
            /** @var Metadata $item */
            return $item->name() == $metadataName;
        };
    }
}
