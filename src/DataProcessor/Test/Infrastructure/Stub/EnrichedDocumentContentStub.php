<?php
/**
 * Created by PhpStorm.
 * User: Carles
 * Date: 21/06/2017
 * Time: 19:14
 */

namespace Mpwar\DataProcessor\Test\Infrastructure\Stub;


use Mpwar\DataProcessor\Domain\ValueObject\EnrichedDocumentContent;

class EnrichedDocumentContentStub extends Stub
{
    public static function random()
    {
        return self::create(self::factory()->text());
    }

    public static function create(String $source)
    {
        return new EnrichedDocumentContent($source);
    }

}