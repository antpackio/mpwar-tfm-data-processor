<?php

namespace Mpwar\DataProcessor\Application\Event;

use Mpwar\DataProcessor\Domain\EnrichedDocument;

class EnrichedDocumentWasProcessed implements \JsonSerializable
{
    const NAME          = "EnrichedDocumentWasProcessed";
    const UNDEFINED_TAG = "undefined";
    private $document;
    private $occurredOn;

    public function __construct(EnrichedDocument $enrichedDocument)
    {
        $this->document = $enrichedDocument;
        $this->occurredOn = new \DateTimeImmutable();
    }

    public function jsonSerialize()
    {
        $metadataCollection = $this->document->metadataCollection();

        return [
            'eventName' => self::NAME,
            'occurredOn' => $this->occurredOn()->format(DATE_ATOM),
            'enrichedDocument' => [
                'source' => $this->document->sourceName()->value(),
                'keyword' => $this->document->sourceKeyword()->value(),
                'category' => $metadataCollection->get('category') ?: self::UNDEFINED_TAG,
                'content' => $this->document->content()->value(),
                'created_at' => $this->document->createdAt()->__toString(),
                'author_name' => $this->document->author()->value(),
                'author_location' => $metadataCollection->get('location') ?: self::UNDEFINED_TAG,
                'language' => $this->document->language()->value(),
                'sentiment' => $metadataCollection->get('sentiment') ?: self::UNDEFINED_TAG,
            ]
        ];
    }

    public function occurredOn(): \DateTimeImmutable
    {
        return $this->occurredOn;
    }
}