<?php

namespace Mpwar\DataProcessor\Test\Infrastructure\Stub;

use Faker\Factory;

abstract class Stub
{
    public static function factory()
    {
        return Factory::create();
    }
}