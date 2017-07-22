<?php

namespace Mpwar\DataProcessor\Test\Behaviour;

use Mockery\Mock;
use Mpwar\DataProcessor\Application\Event\EnrichedDocumentWasProcessed;
use Mpwar\DataProcessor\Application\MessageBus;
use Mpwar\DataProcessor\Application\Service\DataProcessor;
use Mpwar\DataProcessor\Domain\EnrichedDocument\EnrichedDocument;
use Mpwar\DataProcessor\Domain\EnrichedDocument\EnrichedDocumentsRepository;
use Mpwar\DataProcessor\Domain\EnrichmentService\EnrichmentDocumentService;
use Mpwar\DataProcessor\Domain\Parser\Parser;
use Mpwar\DataProcessor\Domain\Parser\ParserService;
use Mpwar\DataProcessor\Domain\RawDocument\RawDocumentSource;
use Mpwar\DataProcessor\Domain\RawDocument\RawDocumentsRepository;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\EnrichedDocument\EnrichedDocumentStub;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\RawDocument\RawDocumentsCollectionStub;
use Mpwar\DataProcessor\Test\Infrastructure\UnitTestCase;

class DataProcessorTest extends UnitTestCase
{
    /** @var  Mock|RawDocumentsRepository */
    private $rawDocumentsRepository;
    /** @var  Mock|ParserService */
    private $parserService;
    /** @var  Mock|EnrichmentDocumentService */
    private $enrichmentDocumentService;
    /** @var  Mock|EnrichedDocumentsRepository */
    private $enrichedDocumentsRepository;
    /** @var  Mock|MessageBus */
    private $messageBus;
    /** @var  Mock|Parser */
    private $parser;
    /** @var  DataProcessor */
    private $dataProcessor;

    public function setUp()
    {
        $this->rawDocumentsRepository = $this->mock(RawDocumentsRepository::class);
        $this->parserService = $this->mock(ParserService::class);
        $this->parser = $this->mock(Parser::class);
        $this->enrichmentDocumentService = $this->mock(EnrichmentDocumentService::class);
        $this->enrichedDocumentsRepository = $this->mock(EnrichedDocumentsRepository::class);
        $this->messageBus = $this->mock(MessageBus::class);
        $this->dataProcessor = new DataProcessor(
            $this->rawDocumentsRepository,
            $this->parserService,
            $this->enrichmentDocumentService,
            $this->enrichedDocumentsRepository,
            $this->messageBus
        );
    }
    /**
    * @test
    */
    public function itShouldProperlyCompleteTheDataProcessorProcess()
    {
        $rawDocumentsCollection = RawDocumentsCollectionStub::withTwoDocuments();

        $this->rawDocumentsRepository
            ->shouldReceive('all')
            ->once()
            ->withNoArgs()
            ->andReturn($rawDocumentsCollection);

        $this->enrichedDocumentsRepository
            ->shouldReceive('hasRawDocumentId')
            ->once()
            ->with($rawDocumentsCollection[0]->id())
            ->andReturn(null);

        $this->enrichedDocumentsRepository
            ->shouldReceive('hasRawDocumentId')
            ->once()
            ->with($rawDocumentsCollection[1]->id())
            ->andReturn(null);
        
        $this->parserService
            ->shouldReceive('execute')
            ->twice()
            ->with(RawDocumentSource::class)
            ->andReturn($this->parser);

        $this->parser
            ->shouldReceive('parse')
            ->once()
            ->with($rawDocumentsCollection[0])
            ->andReturn(EnrichedDocumentStub::random());

        $this->parser
            ->shouldReceive('parse')
            ->once()
            ->with($rawDocumentsCollection[1])
            ->andReturn(EnrichedDocumentStub::random());

        $this->enrichmentDocumentService
            ->shouldReceive('execute')
            ->twice()
            ->with(EnrichedDocument::class)
            ->andReturn(EnrichedDocumentStub::random());

        $this->enrichedDocumentsRepository
            ->shouldReceive('save')
            ->twice()
            ->with(EnrichedDocument::class)
            ->andReturnNull();

        $this->messageBus
            ->shouldReceive('dispatch')
            ->twice()
            ->with('EnrichedDocumentWasProcessed', EnrichedDocumentWasProcessed::class)
            ->andReturn();

        $this->assertNull($this->dataProcessor->execute());
    }
}
