<?php

namespace Mpwar\DataProcessor\Infrastructure\Domain\EnrichmentService;

use Mpwar\DataProcessor\Domain\Document;
use Mpwar\DataProcessor\Domain\EnrichmentService\EnrichmentService;
use Mpwar\DataProcessor\Domain\Metadata;
use Mpwar\DataProcessor\Domain\MetadataCollection;

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

    private function selectCategory(string $keyword): ?string
    {
        switch($keyword){
            case "sunscreen":
                return 'health, summer, skin';
                break;
        }

        return null;
    }
}