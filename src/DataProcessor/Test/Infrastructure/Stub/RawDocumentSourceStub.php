<?php
/**
 * Created by PhpStorm.
 * User: Carles
 * Date: 15/06/2017
 * Time: 18:05
 */

namespace Mpwar\DataProcessor\Test\Infrastructure\Stub;


use Mpwar\DataProcessor\Domain\ValueObject\RawDocumentSource;

class RawDocumentSourceStub extends Stub
{
    public static function random()
    {
        return self::create(self::factory()->name);
    }

    public static function create(String $source)
    {
        return new RawDocumentSource($source);
    }

    public static function twitter()
    {
        return self::create('Twitter');
    }
}