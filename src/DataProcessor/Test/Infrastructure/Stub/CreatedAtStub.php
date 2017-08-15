<?php

namespace Mpwar\DataProcessor\Test\Infrastructure\Stub;

use Mpwar\DataProcessor\Domain\Document\CreatedAt;

class CreatedAtStub extends Stub
{
    public static function random()
    {
        $atomDate = self::factory()
                        ->date(DATE_ATOM);

        return self::create($atomDate);
    }

    public static function create($value)
    {
        return new CreatedAt($value);
    }
}
