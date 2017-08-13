<?php

namespace Mpwar\DataProcessor\Test\Behaviour;

use Mockery\Mock;
use Mpwar\DataProcessor\Domain\EnrichedDocument\EnrichDocument;
use Mpwar\DataProcessor\Domain\EnrichedDocument\EnrichedDocumentFactory;
use Mpwar\DataProcessor\Domain\Parser\ConcreteParserService;
use Mpwar\DataProcessor\Domain\Parser\NotSupportedSourceException;
use Mpwar\DataProcessor\Domain\Parser\Parser;
use Mpwar\DataProcessor\Domain\Parser\ParserService;
use Mpwar\DataProcessor\Domain\Parser\Twitter\TwitterParser;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\EnrichedDocument\EnrichedDocumentStub;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\RawDocument\RawDocumentSourceStub;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\RawDocument\RawDocumentStub;
use Mpwar\DataProcessor\Test\Infrastructure\UnitTestCase;

class ConcreteParserServiceTest extends UnitTestCase
{
    /**
     * @var Mock | ParserService
     */
    private $parserService;
    /**
     * @var Mock | EnrichedDocumentFactory
     */
    private $enrichedDocumentRepository;

    public function setUp()
    {
        parent::setUp();
        $this->enrichedDocumentRepository = $this->mock(EnrichedDocumentFactory::class);
        $this->parserService = new ConcreteParserService($this->enrichedDocumentRepository);

    }

    /** @test */
    public function itShouldReturnAParserWhenCorrectSource()
    {
        $this->assertInstanceOf(
            TwitterParser::class,
            $this->parserService->execute(RawDocumentSourceStub::twitter())
        );
    }

    /** @test */
    public function itShouldThrowAndExceptionWhenNotCorrectSource()
    {
        $this->expectException(NotSupportedSourceException::class);
        $this->parserService->execute(RawDocumentSourceStub::invalid());
    }
}