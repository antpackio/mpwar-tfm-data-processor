<?php

namespace Mpwar\DataProcessor\Application\Event;

use Mpwar\DataProcessor\Domain\Document\Document;

class EnrichedDocumentWasProcessed implements \JsonSerializable
{
    const NAME          = "EnrichedDocumentWasProcessed";
    const UNDEFINED_TAG = "undefined";
    private $document;
    private $occurredOn;

    public function __construct(Document $enrichedDocument)
    {
        $this->document = $enrichedDocument;
        $this->occurredOn = new \DateTimeImmutable();
    }

    public function jsonSerialize()
    {
        $metadataCollection = $this->document->metadataCollection();

        $category = $metadataCollection->get('category') ?
            $metadataCollection->get('category')->value() : self::UNDEFINED_TAG;

        $authorLocation = $metadataCollection->get('location') ?
            $metadataCollection->get('location')->value() : self::UNDEFINED_TAG;

        $sentiment = $metadataCollection->get('sentiment') ?
            $metadataCollection->get('sentiment')->value() : self::UNDEFINED_TAG;

        return [
            'eventName' => self::NAME,
            'occurredOn' => $this->occurredOn()->format(DATE_ATOM),
            'enrichedDocument' => [
                'source' => $this->document->sourceName()->value(),
                'keyword' => $this->document->sourceKeyword()->value(),
                'category' => $category,
                'content' => $this->document->content()->value(),
                'created_at' => $this->document->createdAt()->value(),
                'author_name' => $this->document->author()->value(),
                'author_location' => $authorLocation,
                'language' => $this->document->language()->value(),
                'sentiment' => $sentiment,
            ]
        ];
    }

    public function occurredOn(): \DateTimeImmutable
    {
        return $this->occurredOn;
    }
}