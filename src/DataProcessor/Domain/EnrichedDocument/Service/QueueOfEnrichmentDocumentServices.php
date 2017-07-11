<?php
/**
 * Created by PhpStorm.
 * User: Carles
 * Date: 11/07/2017
 * Time: 19:16
 */

namespace Mpwar\DataProcessor\Domain\EnrichedDocument\Service;


use Mpwar\DataProcessor\Domain\EnrichedDocument\EnrichedDocument;

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

    public function execute(EnrichedDocument $document): EnrichedDocument
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