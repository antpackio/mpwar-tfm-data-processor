<?php

namespace Mpwar\DataProcessor\Application\Service;

use Mpwar\DataProcessor\Domain\Repository\EnrichedDocumentsRepository;
use Mpwar\DataProcessor\Domain\Repository\RawDocumentsRepository;
use Mpwar\DataProcessor\Domain\Service\EnrichmentDocumentService;

class DataProcessor
{
    private $rawDocumentsRepository;
    private $enrichmentDocumentService;
    private $enrichedDocumentsRepository;

    public function __construct(
        RawDocumentsRepository $rawDocumentsRepository,
        EnrichmentDocumentService $enrichmentDocumentService,
        EnrichedDocumentsRepository $enrichedDocumentsRepository
    ) {
        $this->rawDocumentsRepository = $rawDocumentsRepository;
        $this->enrichmentDocumentService = $enrichmentDocumentService;
        $this->enrichedDocumentsRepository = $enrichedDocumentsRepository;
    }

    public function execute()
    {
        $rawDocumentsCollection = $this->rawDocumentsRepository->all();

        foreach ($rawDocumentsCollection as $rawDocument) {
            $enrichedDocument = $this->enrichmentDocumentService->execute($rawDocument);
            $this->enrichedDocumentsRepository->save($enrichedDocument);

        }
    }
}
