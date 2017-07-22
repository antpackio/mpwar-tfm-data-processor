<?php

namespace Mpwar\DataProcessor\Domain\RawDocument;

use InvalidArgumentException;
use Ramsey\Uuid\Uuid;

class RawDocumentId
{
    private $value;

    private function __construct(string $id)
    {
        if (!Uuid::isValid($id)) {
            throw new InvalidArgumentException();
        }

        $this->value = $id;
    }

    public static function fromString(string $id): self
    {
        return new self($id);
    }

    public static function create(): self
    {
        return new self(Uuid::uuid4()->toString());
    }

    public function value(): string
    {
        return $this->value;
    }

    public function __toString()
    {
        return $this->value();
    }
}
