<?php
/**
 * Created by PhpStorm.
 * User: Carles
 * Date: 05/07/2017
 * Time: 19:38
 */

namespace Mpwar\DataProcessor\Infrastructure\EnrichedDocument\Service\Category;

use Mpwar\DataProcessor\Domain\EnrichedDocument\Metadata;

class Category implements Metadata
{
    public $value;

    public function value()
    {
        return $this->value;
    }
}