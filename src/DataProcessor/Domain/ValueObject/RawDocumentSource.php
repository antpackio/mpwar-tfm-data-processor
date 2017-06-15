<?php
/**
 * Created by PhpStorm.
 * User: Carles
 * Date: 15/06/2017
 * Time: 18:06
 */

namespace Mpwar\DataProcessor\Domain\ValueObject;


class RawDocumentSource
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