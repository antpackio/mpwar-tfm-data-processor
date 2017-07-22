<?php

namespace Mpwar\DataProcessor\Test\Infrastructure\Stub;

use Mpwar\DataProcessor\Domain\EnrichedDocument\Author;

class EnrichedDocumentAuthorStub extends Stub
{
    public static function random()
    {
        return self::create(self::factory()->text());
    }

    public static function create(String $author)
    {
        return new Author($author);
    }
}
