<?php
/**
 * Created by PhpStorm.
 * User: Carles
 * Date: 21/06/2017
 * Time: 18:35
 */

namespace Mpwar\DataProcessor\Test\Infrastructure\Stub;


use Mpwar\DataProcessor\Domain\ValueObject\RawDocumentContent;

class RawDocumentContentStub extends Stub
{
    public static function random()
    {
        return self::create(self::factory()->text);
    }

    public static function create(string $content)
    {
        return new RawDocumentContent($content);
    }

    public static function empty()
    {
        return self::create("");
    }

}