<?php

namespace Mpwar\DataProcessor\Test\Infrastructure\Stub;

use Mpwar\DataProcessor\Domain\Entity\EnrichedDocument;

class EnrichedDocumentStub extends Stub
{
    public static function random()
    {

        return self::create();
    }

    public static function create()
    {
        return new EnrichedDocument();
    }
}