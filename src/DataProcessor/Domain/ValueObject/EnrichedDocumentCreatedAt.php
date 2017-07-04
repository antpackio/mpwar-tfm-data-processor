<?php

namespace Mpwar\DataProcessor\Domain\ValueObject;

use Carbon\Carbon;

class EnrichedDocumentCreatedAt
{
    private $value;

    public function __construct(?string $string)
    {
        if ($string) {
            $this->value = new Carbon($string);
            $this->value->setTimezone('UTC');
        } else {
            $this->value = null;
        }
    }

    public function value(): ?Carbon
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value() ? $this->value()->toAtomString() : 'null';
    }
}
