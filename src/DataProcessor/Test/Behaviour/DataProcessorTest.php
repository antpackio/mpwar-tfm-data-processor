<?php

namespace Mpwar\DataProcessor\Test\Behaviour;

use Mockery\Mock;
use Mpwar\DataProcessor\Application\Service\DataProcessor;
use Mpwar\DataProcessor\Domain\Repository\EnrichedDocumentsRepository;
use Mpwar\DataProcessor\Domain\Repository\RawDocumentsRepository;
use Mpwar\DataProcessor\Domain\Service\EnrichmentDocumentService;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\EnrichedDocumentStub;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\RawDocumentsCollectionStub;
use Mpwar\DataProcessor\Test\Infrastructure\UnitTestCase;

class DataProcessorTest extends UnitTestCase
{
    /** @var  Mock|RawDocumentsRepository */
    private $rawDocumentsRepository;
    /** @var  Mock|EnrichmentDocumentService */
    private $enrichmentDocumentService;
    /** @var  Mock|EnrichedDocumentsRepository */
    private $enrichedDocumentsRepository;
    /** @var  DataProcessor */
    private $dataProcessor;

    public function setUp()
    {
        $this->rawDocumentsRepository = $this->mock(RawDocumentsRepository::class);
        $this->enrichmentDocumentService = $this->mock(EnrichmentDocumentService::class);
        $this->enrichedDocumentsRepository = $this->mock(EnrichedDocumentsRepository::class);
        $this->dataProcessor = new DataProcessor(
            $this->rawDocumentsRepository,
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
        $enrichedDocument = EnrichedDocumentStub::random();
        $anotherEnrichedDocument = EnrichedDocumentStub::random();

        $this->rawDocumentsRepository
            ->shouldReceive('all')
            ->once()
            ->withNoArgs()
            ->andReturn($rawDocumentsCollection);

        $this->enrichmentDocumentService
            ->shouldReceive('execute')
            ->once()
            ->with($rawDocumentsCollection[0])
            ->andReturn($enrichedDocument);

        $this->enrichmentDocumentService
            ->shouldReceive('execute')
            ->once()
            ->with($rawDocumentsCollection[1])
            ->andReturn($anotherEnrichedDocument);

        $this->enrichedDocumentsRepository
            ->shouldReceive('save')
            ->once()
            ->with($enrichedDocument)
            ->andReturnNull();

        $this->enrichedDocumentsRepository
            ->shouldReceive('save')
            ->once()
            ->with($anotherEnrichedDocument)
            ->andReturnNull();

        $this->assertNull($this->dataProcessor->execute());
    }
}
