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

    function jsonSerialize()
    {
        return [
            'source' => $this->document->source()->value(),
            'keyword' => $this->document->keyword()->value(),
            'category' =>$this->document->metadata()->filterByType(Category::class)->value(),
            'content' => $this->document->content()->value(),
            'created_at' => $this->document->createdAt()->value(),
            'author_name' => $this->document->author()->value(),
            'author_location' => $this->document->metadata()->filterByType(Location::class)->value()->short_name,
            'language' => $this->document->language()->value(),
            'sentiment' => $this->document->metadata()->filterByType(Sentiment::class)->value()->score
        ];
    }
}