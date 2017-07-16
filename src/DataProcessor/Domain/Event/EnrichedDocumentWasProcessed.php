<?php
/**
 * Created by PhpStorm.
 * User: Carles
 * Date: 12/07/2017
 * Time: 19:18
 */

namespace Mpwar\DataProcessor\Domain\Event;


use Mpwar\DataProcessor\Domain\EnrichedDocument\EnrichedDocument;
use Mpwar\DataProcessor\Infrastructure\EnrichedDocument\Service\Category\Category;
use Mpwar\DataProcessor\Infrastructure\EnrichedDocument\Service\Location\Location;
use Mpwar\DataProcessor\Infrastructure\EnrichedDocument\Service\Sentiment\Sentiment;

class EnrichedDocumentWasProcessed extends DomainEvent implements \JsonSerializable
{
    const NAME = "EnrichedDocumentWasProcessed";
    private $document;

    public function __construct(EnrichedDocument $enrichedDocument)
    {
        $this->document = $enrichedDocument;
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
            'source' => $this->document->source()->value(),
            'keyword' => $this->document->keyword()->value(),
            'category' => $metadataCategory,
            'content' => $this->document->content()->value(),
            'created_at' => $this->document->createdAt()->__toString(),
            'author_name' => $this->document->author()->value(),
            'author_location' => $metadataLocation,
            'language' => $this->document->language()->value(),
            'sentiment' => $metadataSentiment
        ];
    }
}