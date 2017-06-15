<?php

namespace Mpwar\DataProcessor\Application\Service;

use Mpwar\DataProcessor\Domain\Repository\EnrichedDocumentsRepository;
use Mpwar\DataProcessor\Domain\Repository\RawDocumentsRepository;
use Mpwar\DataProcessor\Domain\Service\EnrichmentDocumentService;
use Mpwar\DataProcessor\Domain\Service\RawDocumentParserService;

class DataProcessor
{
    private $rawDocumentsRepository;
    private $enrichmentDocumentService;
    private $enrichedDocumentsRepository;
    private $rawDocumentParser;

    public function __construct(
        RawDocumentsRepository $rawDocumentsRepository,
        RawDocumentParserService $rawDocumentParser,
        EnrichmentDocumentService $enrichmentDocumentService,
        EnrichedDocumentsRepository $enrichedDocumentsRepository
    ) {
        $this->rawDocumentsRepository = $rawDocumentsRepository;
        $this->rawDocumentParser = $rawDocumentParser;
        $this->enrichmentDocumentService = $enrichmentDocumentService;
        $this->enrichedDocumentsRepository = $enrichedDocumentsRepository;
    }

    public function execute(): void
    {
        $rawDocumentsCollection = $this->rawDocumentsRepository->all();

        foreach ($rawDocumentsCollection as $rawDocument) {
            if ($this->enrichedDocumentsRepository->hasRawDocumentId($rawDocument->id()) !== null) {
                continue;
            }
            $enrichedDocument = $this->rawDocumentParser->execute($rawDocument);
            $enrichedDocument = $this->enrichmentDocumentService->execute($enrichedDocument);
            $this->enrichedDocumentsRepository->save($enrichedDocument);
        }
    }
}
