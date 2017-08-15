<?php

namespace Mpwar\DataProcessor\Infrastructure\Domain\EnrichmentService;

use Mpwar\DataProcessor\Domain\Document\Document;
use Mpwar\DataProcessor\Domain\EnrichmentService\EnrichmentService;
use Mpwar\DataProcessor\Domain\Document\Metadata;
use Mpwar\DataProcessor\Domain\Document\MetadataCollection;

class InMemoryCategory implements EnrichmentService
{

    public function execute(Document $document): MetadataCollection
    {
        $metadataCollection = new MetadataCollection();
        $category = $this->selectCategory($document->sourceKeyword()->value());

        if ($category) {
            $metadataCollection->add(
                new Metadata('category', $category)
            );
        }

        return $metadataCollection;
    }

    private function selectCategory(string $keyword)
    {
        switch($keyword){
            case "sunscreen":
                return [
                    'health', 'summer', 'skin'
                ];
                break;
        }

        return null;
    }
}