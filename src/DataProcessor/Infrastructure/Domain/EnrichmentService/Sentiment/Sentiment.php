<?php
/**
 * Created by PhpStorm.
 * User: Carles
 * Date: 11/07/2017
 * Time: 19:11
 */

namespace Mpwar\DataProcessor\Infrastructure\Domain\EnrichmentService\Sentiment;


use Mpwar\DataProcessor\Domain\EnrichedDocument\EnrichedDocumentMetadata;

class Sentiment implements EnrichedDocumentMetadata
{
    public $value;

    public function value()
    {
        return $this->value['score'];
    }
}