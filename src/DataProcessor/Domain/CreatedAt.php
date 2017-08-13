<?php

namespace Mpwar\DataProcessor\Domain;

use Mpwar\DataProcessor\Domain\DataType\StringValueObject;

class CreatedAt extends StringValueObject
{
    /**
     * Improved pattern based on https://stackoverflow.com/a/28022901/7943659
     * in order to validate correctly TZ offset range (-11/+14) and recognize only ATOM
     */
    const ATOM_DATE_PATTERN = '/^(?:[1-9]\d{3}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1\d|2[0-8])|(?:0[13-9]|1[0-2])-(?:29|30)|(?:0[13578]|1[02])-31)|(?:[1-9]\d(?:0[48]|[2468][048]|[13579][26])|(?:[2468][048]|[13579][26])00)-02-29)T(?:[01]\d|2[0-3]):[0-5]\d:[0-5]\d(?:(?:[-]1[0-1]|-0\d|[+]0\d|[+]1[0-4]):[0-5]\d)$/';

    protected function setValue(string $value)
    {
        if (!preg_match(self::ATOM_DATE_PATTERN, $value)) {
            throw new \InvalidArgumentException();
        }

        parent::setValue($value);
    }
}
