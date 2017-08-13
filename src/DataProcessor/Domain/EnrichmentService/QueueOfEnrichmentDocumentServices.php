<?php

namespace Mpwar\DataProcessor\Domain\EnrichmentService;

use Mpwar\DataProcessor\Domain\Document;
use Mpwar\DataProcessor\Domain\EnrichedDocument;

class QueueOfEnrichmentDocumentServices implements EnrichmentDocumentService
{
    private $queue;

    public function __construct(array $enrichmentServices)
    {
        $this->queue = [];
        foreach ($enrichmentServices as $enrichmentService) {
            $this->addService($enrichmentService);
        }
    }

    public function execute(Document $documentdocument): EnrichedDocument
    {
        foreach ($this->queue as $service){
            $documentdocument = $service->execute($documentdocument);
        }

        return $documentdocument;
    }

    private function addService(EnrichmentDocumentService $service)
    {
        $this->queue[] = $service;
    }


}