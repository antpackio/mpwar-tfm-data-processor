<?php
/**
 * Created by PhpStorm.
 * User: Carles
 * Date: 05/07/2017
 * Time: 19:38
 */

namespace Mpwar\DataProcessor\Infrastructure\Domain\EnrichmentService\Category;

use Mpwar\DataProcessor\Domain\EnrichedDocument\EnrichedDocumentMetadata;

class Category implements EnrichedDocumentMetadata
{
    public $value;

    public function value()
    {
        return $this->value;
    }
}