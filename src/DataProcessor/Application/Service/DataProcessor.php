<?php

namespace Mpwar\DataProcessor\Application\Service;

use Mpwar\DataProcessor\Application\Event\EnrichedDocumentWasProcessed;
use Mpwar\DataProcessor\Application\MessageBus;
use Mpwar\DataProcessor\Domain\EnrichedDocument\EnrichedDocumentsRepository;
use Mpwar\DataProcessor\Domain\EnrichmentService\EnrichmentDocumentService;
use Mpwar\DataProcessor\Domain\Parser\ParserService;
use Mpwar\DataProcessor\Domain\RawDocument\RawDocument;
use Mpwar\DataProcessor\Domain\RawDocument\RawDocumentsRepository;

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
        $rawDocument = $this->rawDocumentsRepository->first();
        if ($rawDocument === null) {
            return;
        }

        if ($this->enrichedDocumentsRepository->hasRawDocumentId($rawDocument->id()) !== null) {
            return;
        }
        $parser = $this->parserService->execute($rawDocument->source());
        $enrichedDocument = $parser->parse($rawDocument);
        $enrichedDocument = $this->enrichmentDocumentService->execute($enrichedDocument);
        $this->enrichedDocumentsRepository->save($enrichedDocument);
        $this->messageBus->dispatch(EnrichedDocumentWasProcessed::NAME, new EnrichedDocumentWasProcessed($enrichedDocument));

    }
}
