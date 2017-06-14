<?php

namespace Mpwar\DataProcessor\Test\Behaviour;

use Mockery\Mock;
use Mpwar\DataProcessor\Application\Service\DataProcessor;
use Mpwar\DataProcessor\Domain\Entity\EnrichedDocument;
use Mpwar\DataProcessor\Domain\Entity\RawDocument;
use Mpwar\DataProcessor\Domain\Repository\EnrichedDocumentsRepository;
use Mpwar\DataProcessor\Domain\Repository\RawDocumentsRepository;
use Mpwar\DataProcessor\Domain\Service\EnrichmentDocumentService;
use Mpwar\DataProcessor\Domain\Service\RawDocumentParser;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\EnrichedDocumentStub;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\RawDocumentsCollectionStub;
use Mpwar\DataProcessor\Test\Infrastructure\UnitTestCase;

class DataProcessorTest extends UnitTestCase
{
    /** @var  Mock|RawDocumentsRepository */
    private $rawDocumentsRepository;
    /** @var  Mock|RawDocumentParser */
    private $rawDocumentParser;
    /** @var  Mock|EnrichmentDocumentService */
    private $enrichmentDocumentService;
    /** @var  Mock|EnrichedDocumentsRepository */
    private $enrichedDocumentsRepository;
    /** @var  DataProcessor */
    private $dataProcessor;

    public function setUp()
    {
        $this->rawDocumentsRepository = $this->mock(RawDocumentsRepository::class);
        $this->rawDocumentParser = $this->mock(RawDocumentParser::class);
        $this->enrichmentDocumentService = $this->mock(EnrichmentDocumentService::class);
        $this->enrichedDocumentsRepository = $this->mock(EnrichedDocumentsRepository::class);
        $this->dataProcessor = new DataProcessor(
            $this->rawDocumentsRepository,
            $this->rawDocumentParser,
            $this->enrichmentDocumentService,
            $this->enrichedDocumentsRepository
        );
    }
    /**
    * @test
    */
    public function itShould()
    {
        $rawDocumentsCollection = RawDocumentsCollectionStub::withTwoDocuments();

        $this->rawDocumentsRepository
            ->shouldReceive('all')
            ->once()
            ->withNoArgs()
            ->andReturn($rawDocumentsCollection);

        $this->rawDocumentParser
            ->shouldReceive('execute')
            ->twice()
            ->with(RawDocument::class)
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

        $this->assertNull($this->dataProcessor->execute());
    }
}
