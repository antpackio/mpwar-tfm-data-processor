<?php

namespace Mpwar\DataProcessor\Test\Behaviour;

use Mockery\Mock;
use Mpwar\DataProcessor\Application\ArrayDataTransformer;
use Mpwar\DataProcessor\Application\EnrichDocument;
use Mpwar\DataProcessor\Application\EnrichedDocumentDataTransformer;
use Mpwar\DataProcessor\Domain\EnrichedDocument\EnrichedDocumentsRepository;
use Mpwar\DataProcessor\Domain\EnrichmentService\EnrichmentDocumentService;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\AuthorLocationStub;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\AuthorStub;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\ContentStub;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\CreatedAtStub;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\DocumentStub;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\EnrichedDocumentStub;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\LanguageStub;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\SourceDocumentIdStub;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\SourceKeywordStub;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\SourceNameStub;
use Mpwar\DataProcessor\Test\Infrastructure\UnitTestCase;

class EnrichDocumentTest extends UnitTestCase
{
    /** @var  Mock|EnrichmentDocumentService */
    private $enrichmentDocumentService;
    /** @var  Mock|EnrichedDocumentsRepository */
    private $enrichedDocumentsRepository;
    /** @var  Mock|EnrichedDocumentDataTransformer */
    private $dataTransformer;
    /** @var  EnrichDocument */
    private $applicationService;

    public function setUp()
    {
        parent::setUp();

        $this->enrichmentDocumentService   = $this->mock(EnrichmentDocumentService::class);
        $this->enrichedDocumentsRepository = $this->mock(EnrichedDocumentsRepository::class);
        $this->dataTransformer             = $this->mock(EnrichedDocumentDataTransformer::class);

        $this->applicationService = new EnrichDocument(
            $this->enrichmentDocumentService, $this->enrichedDocumentsRepository
        );
    }

    /**
     * @test
     */
    public function processDocument()
    {
        $expectedResult = [
            'sourceId' => 'wiki/Star_Wars',
            'source' => 'wiki',
            'keyword' => 'force',
            'content' => 'May the Force be with you',
            'created_at' => '1977-05-25T00:00:00+00:00',
            'author_name' => 'George Lucas',
            'author_location' => 'US',
            'language' => 'en',
            'metadata' => []
        ];

        $document = DocumentStub::create(
            SourceDocumentIdStub::create($expectedResult['sourceId']),
            SourceKeywordStub::create($expectedResult['keyword']),
            SourceNameStub::create($expectedResult['source']),
            ContentStub::create($expectedResult['content']),
            CreatedAtStub::create($expectedResult['created_at']),
            AuthorStub::create($expectedResult['author_name']),
            AuthorLocationStub::create($expectedResult['author_location']),
            LanguageStub::create($expectedResult['language'])
        );
        $enrichedDocument = EnrichedDocumentStub::create(
            $document
        );

        $this->enrichmentDocumentService()
             ->shouldReceive('execute')
             ->once()
             ->with($document)
             ->andReturn($enrichedDocument);

        $this->enrichedDocumentsRepository()
             ->shouldReceive('save')
             ->once()
             ->with(equalTo($enrichedDocument))
             ->andReturn();

        $this->dataTransformer()
             ->shouldReceive('transform')
             ->once()
             ->with(equalTo($enrichedDocument))
             ->andReturn($expectedResult);

        $result = $this->applicationService()
             ->execute($document, $this->dataTransformer());

        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @return Mock|EnrichmentDocumentService
     */
    public function enrichmentDocumentService()
    {
        return $this->enrichmentDocumentService;
    }

    /**
     * @return Mock|EnrichedDocumentsRepository
     */
    public function enrichedDocumentsRepository()
    {
        return $this->enrichedDocumentsRepository;
    }

    /**
     * @return Mock|ArrayDataTransformer
     */
    public function dataTransformer()
    {
        return $this->dataTransformer;
    }

    /**
     * @return EnrichDocument
     */
    public function applicationService(): EnrichDocument
    {
        return $this->applicationService;
    }
}
