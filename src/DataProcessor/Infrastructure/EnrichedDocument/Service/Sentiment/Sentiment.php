<?php
/**
 * Created by PhpStorm.
 * User: Carles
 * Date: 11/07/2017
 * Time: 19:11
 */

namespace Mpwar\DataProcessor\Infrastructure\EnrichedDocument\Service\Sentiment;


use Mpwar\DataProcessor\Domain\EnrichedDocument\Metadata;

class Sentiment implements Metadata
{
    public $value;

    public function value()
    {
        return $this->value['score'];
    }
}