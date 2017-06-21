<?php
/**
 * Created by PhpStorm.
 * User: Carles
 * Date: 21/06/2017
 * Time: 19:11
 */

namespace Mpwar\DataProcessor\Domain\ValueObject;


class EnrichedDocumentContent
{
    private $value;

    public function __construct(string $source)
    {
        $this->value = $source;
    }

    public function value(): string
    {
        return $this->value;
    }

}