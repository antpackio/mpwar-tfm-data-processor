<?php

namespace Mpwar\DataProcessor\Application\Service;

use Mpwar\DataProcessor\Domain\EnrichedDocument\EnrichedDocument;
use Mpwar\DataProcessor\Domain\Event\EnrichedDocumentWasProcessed;
use Mpwar\DataProcessor\Domain\MessageBus;
use Mpwar\DataProcessor\Domain\Repository\EnrichedDocumentsRepository;
use Mpwar\DataProcessor\Domain\Repository\RawDocumentsRepository;
use Mpwar\DataProcessor\Domain\EnrichedDocument\Service\EnrichmentDocumentService;
use Mpwar\DataProcessor\Domain\Parser\ParserService;

class DataProcessor
{
    private $rawDocumentsRepository;
    private $enrichmentDocumentService;
    private $enrichedDocumentsRepository;
    private $parserService;
    private $messageBus;

    public function __construct(
        RawDocumentsRepository $rawDocumentsRepository,
        ParserService $parserService,
        EnrichmentDocumentService $enrichmentDocumentService,
        EnrichedDocumentsRepository $enrichedDocumentsRepository,
        MessageBus $messageBus
    ) {
        $this->rawDocumentsRepository = $rawDocumentsRepository;
        $this->parserService = $parserService;
        $this->enrichmentDocumentService = $enrichmentDocumentService;
        $this->enrichedDocumentsRepository = $enrichedDocumentsRepository;
        $this->messageBus = $messageBus;
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
            $this->messageBus->dispatch(EnrichedDocumentWasProcessed::NAME, new EnrichedDocumentWasProcessed($enrichedDocument));
        }
    }
}
