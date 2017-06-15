<?php
/**
 * Created by PhpStorm.
 * User: Carles
 * Date: 15/06/2017
 * Time: 18:05
 */

namespace Mpwar\DataProcessor\Test\Infrastructure\Stub;


use Mpwar\DataProcessor\Domain\Service\ConcreteRawDocumentParserService;
use Mpwar\DataProcessor\Domain\ValueObject\RawDocumentSource;

class RawDocumentSourceStub extends Stub
{
    public static function random()
    {
        return self::create(self::factory()->randomElement(ConcreteRawDocumentParserService::SOURCE_SUPPORTED));
    }

    public static function create(String $source)
    {
        return new RawDocumentSource($source);
    }

    public static function twitter()
    {
        return self::create('twitter');
    }

    public static function invalid()
    {
        do {
            $word = self::factory()->word;
        } while (in_array($word, ConcreteRawDocumentParserService::SOURCE_SUPPORTED));

        return self::create($word);
    }
}