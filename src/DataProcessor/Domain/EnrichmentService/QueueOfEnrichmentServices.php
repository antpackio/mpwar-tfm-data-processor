<?php

namespace Mpwar\DataProcessor\Domain\EnrichmentService;

use Mpwar\DataProcessor\Domain\Document;
use Mpwar\DataProcessor\Domain\MetadataCollection;

class QueueOfEnrichmentServices implements EnrichmentService
{
    private $queue;

    public function __construct(array $enrichmentServices)
    {
        $this->queue = [];
        foreach ($enrichmentServices as $enrichmentService) {
            $this->addService($enrichmentService);
        }
    }

    public function execute(Document $document): MetadataCollection
    {
        $metadata = new MetadataCollection();

        foreach ($this->queue as $service){
            $metadata->merge($service->execute($document));
        }

        return $metadata;
    }

    private function addService(EnrichmentService $service)
    {
        $this->queue[] = $service;
    }
}