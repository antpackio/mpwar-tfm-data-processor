<?php

namespace Mpwar\DataProcessor\Application\Service;

use Mpwar\DataProcessor\Domain\Document\Document;
use Mpwar\DataProcessor\Domain\Document\DocumentRepository;
use Mpwar\DataProcessor\Domain\EnrichmentService\EnrichmentService;

class EnrichDocument
{
    /**
     * @var EnrichmentService
     */
    private $enrichmentService;
    /**
     * @var DocumentRepository
     */
    private $documentRepository;

    public function __construct(EnrichmentService $enrichmentService, DocumentRepository $documentRepository)
    {
        $this->enrichmentService = $enrichmentService;
        $this->documentRepository = $documentRepository;
    }

    public function execute(Document $document): Document
    {
        $document->metadataCollection()->merge($this->enrichmentService->execute($document));
        $this->documentRepository->save($document);
        return $document;
    }
}
