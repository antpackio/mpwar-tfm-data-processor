<?php

namespace Mpwar\DataProcessor\Application;

use Mpwar\DataProcessor\Domain\Document;
use Mpwar\DataProcessor\Domain\EnrichedDocument\EnrichedDocumentsRepository;
use Mpwar\DataProcessor\Domain\EnrichmentService\EnrichmentDocumentService;

class EnrichDocument
{
    /**
     * @var EnrichmentDocumentService
     */
    private $enrichmentService;
    /**
     * @var EnrichedDocumentsRepository
     */
    private $enrichedDocumentsRepository;

    public function __construct(
        EnrichmentDocumentService $enrichmentService,
        EnrichedDocumentsRepository $enrichedDocumentsRepository
    )
    {
        $this->enrichmentService = $enrichmentService;
        $this->enrichedDocumentsRepository = $enrichedDocumentsRepository;
    }

    public function execute(Document $document, ?EnrichedDocumentDataTransformer $dataTransformer)
    {
        $enrichedDocument = $this->enrichmentService->execute($document);
        $this->enrichedDocumentsRepository->save($enrichedDocument);

        if ($dataTransformer){
            return $dataTransformer->transform($enrichedDocument);
        }

        return $enrichedDocument;
    }
}
