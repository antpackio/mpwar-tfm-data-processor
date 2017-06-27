<?php

namespace Mpwar\DataProcessor\Application\Service;

use Mpwar\DataProcessor\Domain\Entity\EnrichedDocument;
use Mpwar\DataProcessor\Domain\Repository\EnrichedDocumentsRepository;
use Mpwar\DataProcessor\Domain\Repository\RawDocumentsRepository;
use Mpwar\DataProcessor\Domain\Service\EnrichmentDocumentService;
use Mpwar\DataProcessor\Domain\Service\ParserService;

class DataProcessor
{
    private $rawDocumentsRepository;
    private $enrichmentDocumentService;
    private $enrichedDocumentsRepository;
    private $parserService;

    public function __construct(
        RawDocumentsRepository $rawDocumentsRepository,
        ParserService $parserService,
        EnrichmentDocumentService $enrichmentDocumentService,
        EnrichedDocumentsRepository $enrichedDocumentsRepository
    ) {
        $this->rawDocumentsRepository = $rawDocumentsRepository;
        $this->parserService = $parserService;
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
            $enrichedDocument = EnrichedDocument::fromRawDocument($rawDocument);
            $enrichedDocument = $this->parserService->execute($enrichedDocument);
            $enrichedDocument = $this->enrichmentDocumentService->execute($enrichedDocument);
            $this->enrichedDocumentsRepository->save($enrichedDocument);
        }
    }
}
