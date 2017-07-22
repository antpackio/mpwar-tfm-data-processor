<?php
/**
 * Created by PhpStorm.
 * User: Carles
 * Date: 15/06/2017
 * Time: 18:05
 */

namespace Mpwar\DataProcessor\Test\Infrastructure\Stub\RawDocument;


use Mpwar\DataProcessor\Domain\Parser\ConcreteParserService;
use Mpwar\DataProcessor\Domain\RawDocument\RawDocumentSource;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\Stub;

class RawDocumentSourceStub extends Stub
{
    public static function random(): RawDocumentSource
    {
        return self::create(self::factory()->randomElement(ConcreteParserService::SOURCE_SUPPORTED));
    }

    public static function create(String $source): RawDocumentSource
    {
        return new RawDocumentSource($source);
    }

    public static function twitter(): RawDocumentSource
    {
        return self::create('twitter');
    }

    public static function invalid(): RawDocumentSource
    {
        do {
            $word = self::factory()->word;
        } while (in_array($word, ConcreteParserService::SOURCE_SUPPORTED));

        return self::create($word);
    }
}