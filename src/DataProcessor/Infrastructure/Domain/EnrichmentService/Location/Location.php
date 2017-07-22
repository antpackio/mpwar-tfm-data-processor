<?php
/**
 * Created by PhpStorm.
 * User: Carles
 * Date: 12/07/2017
 * Time: 18:49
 */

namespace Mpwar\DataProcessor\Infrastructure\Domain\EnrichmentService\Location;

use Mpwar\DataProcessor\Domain\EnrichedDocument\EnrichedDocumentMetadata;

class Location implements EnrichedDocumentMetadata
{
    public $value;

    public function value()
    {
        return $this->value['short_name'];
    }
}