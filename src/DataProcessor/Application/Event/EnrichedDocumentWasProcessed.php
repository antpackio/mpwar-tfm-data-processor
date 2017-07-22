<?php
/**
 * Created by PhpStorm.
 * User: Carles
 * Date: 12/07/2017
 * Time: 19:18
 */

namespace Mpwar\DataProcessor\Application\Event;


use Mpwar\DataProcessor\Domain\EnrichedDocument\EnrichedDocument;
use Mpwar\DataProcessor\Infrastructure\Domain\EnrichmentService\Category\Category;
use Mpwar\DataProcessor\Infrastructure\Domain\EnrichmentService\Location\Location;
use Mpwar\DataProcessor\Infrastructure\Domain\EnrichmentService\Sentiment\Sentiment;

class EnrichedDocumentWasProcessed implements \JsonSerializable
{
    const NAME = "EnrichedDocumentWasProcessed";
    private $document;
    private $occurredOn;

    public function __construct(EnrichedDocument $enrichedDocument)
    {
        $this->document = $enrichedDocument;
        $this->occurredOn = new \DateTimeImmutable();
    }

    public function jsonSerialize()
    {
        $metadataCategory = $this->document->metadata()->filterByType(
            Category::class
        ) ? $this->document->metadata()->filterByType(
            Category::class
        )->value() : EnrichedDocument::UNDEFINED_TAG;
        $metadataLocation = $this->document->metadata()->filterByType(
            Location::class
        ) ? $this->document->metadata()->filterByType(
            Location::class
        )->value() : EnrichedDocument::UNDEFINED_TAG;
        $metadataSentiment = $this->document->metadata()->filterByType(
            Sentiment::class
        ) ? $this->document->metadata()->filterByType(
            Sentiment::class
        )->value() : EnrichedDocument::UNDEFINED_TAG;
        return [
            'eventName' => self::NAME,
            'occurredOn' => $this->occurredOn()->format(DATE_ATOM),
            'enrichedDocument' => [
                'source' => $this->document->source()->value(),
                'keyword' => $this->document->keyword()->value(),
                'category' => $metadataCategory,
                'content' => $this->document->content()->value(),
                'created_at' => $this->document->createdAt()->__toString(),
                'author_name' => $this->document->author()->value(),
                'author_location' => $metadataLocation,
                'language' => $this->document->language()->value(),
                'sentiment' => $metadataSentiment
            ]
        ];
    }

    public function occurredOn(): \DateTimeImmutable
    {
        return $this->occurredOn;
    }
}