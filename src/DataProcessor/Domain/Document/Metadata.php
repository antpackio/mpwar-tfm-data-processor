<?php

namespace Mpwar\DataProcessor\Domain\Document;

class Metadata
{
    /**
     * @var string
     */
    private $name;
    private $value;

    public function __construct(string $name, $value)
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
    public function value()
    {
        return $this->value;
    }
}
