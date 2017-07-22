<?php

namespace Mpwar\DataProcessor\Test\Infrastructure\Stub\RawDocument;

use Mpwar\DataProcessor\Domain\RawDocument\RawDocumentId;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\Stub;

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
