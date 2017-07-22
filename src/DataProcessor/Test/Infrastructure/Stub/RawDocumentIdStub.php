<?php

namespace Mpwar\DataProcessor\Test\Infrastructure\Stub;

use Mpwar\DataProcessor\Domain\RawDocument\RawDocumentId;

class RawDocumentIdStub extends Stub
{
    public static function random()
    {

        return self::create(
            self::factory()->uuid
        );
    }

    public static function create(string $id)
    {
        return RawDocumentId::fromString($id);
    }
}
