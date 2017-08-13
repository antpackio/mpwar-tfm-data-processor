<?php

namespace Mpwar\DataProcessor\Application;

use Mpwar\DataProcessor\Application\Event\EnrichedDocumentWasProcessed;

class ProcessQueue
{
    /**
     * @var EnrichDocument
     */
    private $enrichDocument;
    /**
     * @var DocumentReader
     */
    private $reader;
    /**
     * @var MessageBus
     */
    private $messageBus;
    /**
     * @var EnrichedDocumentDataTransformer
     */
    private $dataTransformer;

    public function __construct(
        EnrichDocument $enrichDocument,
        DocumentReader $reader,
        MessageBus $messageBus,
        EnrichedDocumentDataTransformer $dataTransformer
    ) {

        $this->enrichDocument  = $enrichDocument;
        $this->reader          = $reader;
        $this->messageBus      = $messageBus;
        $this->dataTransformer = $dataTransformer;
    }

    public function execute()
    {
        $applicationService = $this->enrichDocument;
        $dataTransformer = $this->dataTransformer;
        $enrichedDocument = $this->reader->next($this->enrichDocumentCallback($applicationService, $dataTransformer));
        $this->messageBus->dispatch(EnrichedDocumentWasProcessed::NAME, new EnrichedDocumentWasProcessed($enrichedDocument));
    }

    /**
     * @param $applicationService
     * @param $dataTransformer
     * @return \Closure
     */
    private function enrichDocumentCallback(EnrichDocument $applicationService, $dataTransformer): \Closure
    {
        return function ($document) use ($applicationService, $dataTransformer) {
            return $applicationService->execute($document, $dataTransformer);
        };
    }
}
