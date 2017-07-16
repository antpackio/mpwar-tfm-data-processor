<?php
/**
 * Created by PhpStorm.
 * User: Carles
 * Date: 12/07/2017
 * Time: 18:49
 */

namespace Mpwar\DataProcessor\Infrastructure\EnrichedDocument\Service\Location;

use Mpwar\DataProcessor\Domain\EnrichedDocument\Metadata;

class Location implements Metadata
{
    public $value;

    public function value()
    {
        return $this->value['short_name'];
    }
}