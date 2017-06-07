<?php

namespace Mpwar\DataProcessor\Application\Service;

use Mpwar\DataProcessor\Domain\Repository\EnrichedDocumentsRepository;
use Mpwar\DataProcessor\Domain\Repository\RawDocumentsRepository;
use Mpwar\DataProcessor\Domain\Service\EnrichmentDocumentService;
use Mpwar\DataProcessor\Domain\Service\RawDocumentParser;

class DataProcessor
{
    private $rawDocumentsRepository;
    private $enrichmentDocumentService;
    private $enrichedDocumentsRepository;
    private $rawDocumentParser;

    public function __construct(
        RawDocumentsRepository $rawDocumentsRepository,
        RawDocumentParser $rawDocumentParser,
        EnrichmentDocumentService $enrichmentDocumentService,
        EnrichedDocumentsRepository $enrichedDocumentsRepository
    ) {
        $this->rawDocumentsRepository = $rawDocumentsRepository;
        $this->rawDocumentParser = $rawDocumentParser;
        $this->enrichmentDocumentService = $enrichmentDocumentService;
        $this->enrichedDocumentsRepository = $enrichedDocumentsRepository;
    }

    public function execute()
    {
        $rawDocumentsCollection = $this->rawDocumentsRepository->all();

        foreach ($rawDocumentsCollection as $rawDocument) {
            $enrichedDocument = $this->rawDocumentParser->execute($rawDocument);
            $enrichedDocument = $this->enrichmentDocumentService->execute($enrichedDocument);
            $this->enrichedDocumentsRepository->save($enrichedDocument);
        }
    }
}
