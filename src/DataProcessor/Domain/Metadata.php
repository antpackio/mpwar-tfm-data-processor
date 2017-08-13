<?php

namespace Mpwar\DataProcessor\Domain;

class Metadata
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $value;

    public function __construct(string $name, string $value)
    {
        $this->name  = $name;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return $this->value;
    }
}
