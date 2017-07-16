<?php
/**
 * Created by PhpStorm.
 * User: Carles
 * Date: 05/07/2017
 * Time: 18:48
 */

namespace Mpwar\DataProcessor\Domain\EnrichedDocument;


use Mpwar\DataProcessor\Domain\ValueObject\Collection;

class MetadataCollection extends Collection
{

    /**
     * @return string Type of Objects inside collection FQN
     */
    protected function typeOfCollection(): string
    {
        return Metadata::class;
    }

    public function filterByType(string $className) : ?Metadata
    {
        $itemsFiltered = array_filter(
            $this->items,
            function ($item) use ($className) {
                return is_a($item, $className);
            }
        );
        return array_shift($itemsFiltered);
    }
}