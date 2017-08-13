<?php

namespace Mpwar\DataProcessor\Application;

use Mpwar\DataProcessor\Domain\EnrichedDocument;
use Mpwar\DataProcessor\Domain\Metadata;
use Mpwar\DataProcessor\Domain\MetadataCollection;

class ArrayDataTransformer implements EnrichedDocumentDataTransformer
{
    public function transform(EnrichedDocument $document): array
    {
        return [
            'sourceId' => $document->sourceDocumentId()->value(),
            'source' => $document->sourceName()->value(),
            'keyword' => $document->sourceKeyword()->value(),
            'content' => $document->content()->value(),
            'created_at' => $document->createdAt()->value(),
            'author_name' => $document->author()->value(),
            'author_location' => $document->authorLocation()->value(),
            'language' => $document->language()->value(),
            'metadata' => $this->transformMetadataCollection($document->metadataCollection())
        ];
    }

    private function transformMetadataCollection(MetadataCollection $metadataCollection): array
    {
        $result = [];
        /** @var Metadata $metadata */
        foreach($metadataCollection as $metadata){
            $result[$metadata->name()] = $metadata->value();
        }

        return $result;
    }
}
