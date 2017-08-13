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

    public function execute(Document $document): EnrichedDocument
    {
        foreach ($this->queue as $service){
            $document = $service->execute($document);
        }

        return $document;
    }

    private function addService(EnrichmentDocumentService $service)
    {
        $this->queue[] = $service;
    }


}