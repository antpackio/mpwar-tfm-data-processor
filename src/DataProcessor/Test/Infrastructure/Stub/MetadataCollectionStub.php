<?php

namespace Mpwar\DataProcessor\Test\Infrastructure\Stub;

use Mpwar\DataProcessor\Domain\MetadataCollection;

class MetadataCollectionStub extends Stub
{
    public static function create()
    {
        return new MetadataCollection();
    }

    public static function random()
    {
        $metadataCollection = self::create();
        $metadataCollection->add(MetadataStub::random());

        return $metadataCollection;
    }

    public static function empty()
    {
        return self::create();
    }
}
