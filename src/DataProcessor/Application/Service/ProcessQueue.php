<?php

namespace Mpwar\DataProcessor\Application\Service;

use Mpwar\DataProcessor\Application\DataQueue;
use Mpwar\DataProcessor\Application\DataRequest;
use Mpwar\DataProcessor\Application\Event\EnrichedDocumentWasProcessed;
use Mpwar\DataProcessor\Application\MessageBus;
use Mpwar\DataProcessor\Domain\Document\Author;
use Mpwar\DataProcessor\Domain\Document\AuthorLocation;
use Mpwar\DataProcessor\Domain\Document\Content;
use Mpwar\DataProcessor\Domain\Document\CreatedAt;
use Mpwar\DataProcessor\Domain\Document\Language;
use Mpwar\DataProcessor\Domain\Document\SourceId;
use Mpwar\DataProcessor\Domain\Document\SourceKeyword;
use Mpwar\DataProcessor\Domain\Document\SourceName;

class ProcessQueue
{
    /**
     * @var CreateDocument
     */
    private $createDocument;
    /**
     * @var DataQueue
     */
    private $dataQueue;
    /**
     * @var MessageBus
     */
    private $messageBus;

    public function __construct(
        DataQueue $dataQueue,
        CreateDocument $createDocument,
        EnrichDocument $enrichDocument,
        MessageBus $messageBus
    ) {

        $this->dataQueue      = $dataQueue;
        $this->createDocument = $createDocument;
        $this->enrichDocument = $enrichDocument;
        $this->messageBus     = $messageBus;
    }

    public function execute()
    {
        /** @var DataRequest $dataRequest */
        $dataRequest = $this->dataQueue->next();
        $document = $this->createDocument->execute(
            new SourceId($dataRequest->sourceId()),
            new SourceKeyword($dataRequest->keyword()),
            new SourceName($dataRequest->source()),
            new Content($dataRequest->content()),
            new CreatedAt($dataRequest->createdAt()),
            new Author($dataRequest->author()),
            new AuthorLocation($dataRequest->authorLocation()),
            new Language($dataRequest->language())
        );
        $document = $this->enrichDocument->execute($document);
        $this->messageBus->dispatch(EnrichedDocumentWasProcessed::NAME, new EnrichedDocumentWasProcessed($document));
    }
}
