<?php

namespace Mpwar\DataProcessor\Test\Behaviour;

use Mpwar\DataProcessor\Test\Infrastructure\Stub\EnrichedDocumentStub;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\TweetContent;
use Mpwar\DataProcessor\Domain\EnrichedDocument\EnrichedDocument;
use Mpwar\DataProcessor\Domain\Exception\NotSupportedSourceException;
use Mpwar\DataProcessor\Domain\Parser\ConcreteParserService;
use Mpwar\DataProcessor\Domain\Parser\ParserService;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\RawDocumentStub;
use Mpwar\DataProcessor\Test\Infrastructure\UnitTestCase;

class ConcreteParserServiceTest extends UnitTestCase
{
    use TweetContent;
    /**
     * @var ParserService
     */
    private $parserService;

    public function setUp()
    {
        parent::setUp();
        $this->parserService = new ConcreteParserService();
    }

    /** @test */
    public function itShouldPass()
    {
        $rawDocumentFromTwitter = RawDocumentStub::validFromTwitter();
        $enrichedDocument = EnrichedDocumentStub::create($rawDocumentFromTwitter);
        $this->assertInstanceOf(EnrichedDocument::class, $this->parserService->execute($enrichedDocument));
    }

    /** @test */
    public function itShouldThrowAndExceptionWhenNotCorrectSource()
    {
        $invalidRawDocument = RawDocumentStub::withInvalidSource();
        $enrichedDocument = EnrichedDocumentStub::create($invalidRawDocument);
        $this->expectException(NotSupportedSourceException::class);
        $this->parserService->execute($enrichedDocument);
    }
}