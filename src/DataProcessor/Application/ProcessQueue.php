<?php

namespace Mpwar\DataProcessor\Application;

use Mpwar\DataProcessor\Application\Event\EnrichedDocumentWasProcessed;
use Mpwar\DataProcessor\Domain\Author;
use Mpwar\DataProcessor\Domain\AuthorLocation;
use Mpwar\DataProcessor\Domain\Content;
use Mpwar\DataProcessor\Domain\CreatedAt;
use Mpwar\DataProcessor\Domain\Language;
use Mpwar\DataProcessor\Domain\SourceId;
use Mpwar\DataProcessor\Domain\SourceKeyword;
use Mpwar\DataProcessor\Domain\SourceName;

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
        $data = $this->dataQueue->next();
        $document = $this->createDocument->execute(
            new SourceId($data['source_id']),
            new SourceKeyword($data['keyword']),
            new SourceName($data['source']),
            new Content($data['content']),
            new CreatedAt($data['created_at']),
            new Author($data['author']),
            new AuthorLocation($data['author_location']),
            new Language($data['metadata']['language'])
        );
        $document = $this->enrichDocument->execute($document);
        $this->messageBus->dispatch(EnrichedDocumentWasProcessed::NAME, new EnrichedDocumentWasProcessed($document));
    }
}
