<?php
/**
 * Created by PhpStorm.
 * User: Carles
 * Date: 21/06/2017
 * Time: 18:37
 */

namespace Mpwar\DataProcessor\Domain\ValueObject;


class RawDocumentContent
{
    private $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }
}