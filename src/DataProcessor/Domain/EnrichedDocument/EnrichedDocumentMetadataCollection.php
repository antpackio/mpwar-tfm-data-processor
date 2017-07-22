<?php
/**
 * Created by PhpStorm.
 * User: Carles
 * Date: 05/07/2017
 * Time: 18:48
 */

namespace Mpwar\DataProcessor\Domain\EnrichedDocument;


use Mpwar\DataProcessor\Domain\DataType\Collection;

class EnrichedDocumentMetadataCollection extends Collection
{

    /**
     * @return string Type of Objects inside collection FQN
     */
    protected function typeOfCollection(): string
    {
        return EnrichedDocumentMetadata::class;
    }

    public function filterByType(string $className) : ?EnrichedDocumentMetadata
    {
        $itemsFiltered = array_filter(
            $this->items,
            function ($item) use ($className) {
                return is_a($item, $className);
            }
        );
        return array_shift($itemsFiltered);
    }

    public function __toString(): string
    {
        return json_encode($this->items);
    }
}