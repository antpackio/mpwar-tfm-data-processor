<?php

namespace Mpwar\DataProcessor\Application\Service;

use Mpwar\DataProcessor\Application\Event\EnrichedDocumentWasProcessed;
use Mpwar\DataProcessor\Application\MessageBus;
use Mpwar\DataProcessor\Domain\EnrichedDocument\EnrichedDocumentsRepository;
use Mpwar\DataProcessor\Domain\EnrichmentService\EnrichmentDocumentService;
use Mpwar\DataProcessor\Domain\Parser\ParserService;
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
        echo 'Processing id: ' . $rawDocument->id() . "\n";
        $parser = $this->parserService->execute($rawDocument->source());
        echo 'Parser Service retrieved. ' . "\n";
        $enrichedDocument = $parser->parse($rawDocument);
        echo 'Parser done. ' . "\n";
        $enrichedDocument = $this->enrichmentDocumentService->execute($enrichedDocument);
        echo 'Enrichment services done. ' . "\n";
        $this->enrichedDocumentsRepository->save($enrichedDocument);
        echo 'Saved document. ' . "\n";
        $this->messageBus->dispatch(EnrichedDocumentWasProcessed::NAME, new EnrichedDocumentWasProcessed($enrichedDocument));
        echo 'Dispatched. ' . "\n";
        echo '------------------. ' . "\n\n\n";
    }
}
