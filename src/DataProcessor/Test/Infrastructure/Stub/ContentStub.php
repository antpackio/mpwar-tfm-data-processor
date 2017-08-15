<?php

namespace Mpwar\DataProcessor\Test\Infrastructure\Stub;

use Mpwar\DataProcessor\Domain\Document\Content;

class ContentStub extends Stub
{
    public static function random()
    {
        $text = self::factory()
                    ->text('200');

        return self::create($text);
    }

    public static function create($value)
    {
        return new Content($value);
    }
}
