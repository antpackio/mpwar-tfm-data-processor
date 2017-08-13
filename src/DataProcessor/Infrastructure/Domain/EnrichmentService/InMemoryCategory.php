<?php

namespace Mpwar\DataProcessor\Infrastructure\Domain\EnrichmentService;


use Mpwar\DataProcessor\Domain\Document;
use Mpwar\DataProcessor\Domain\EnrichedDocument;
use Mpwar\DataProcessor\Domain\EnrichmentService\EnrichmentDocumentService;
use Mpwar\DataProcessor\Domain\Metadata;

class InMemoryCategory implements EnrichmentDocumentService
{

    public function execute(Document $document): EnrichedDocument
    {
        if(!is_a($document, EnrichedDocument::class)){
            $document = EnrichedDocument::fromDocument($document);
        }

        $category = $this->selectCategory($document->sourceKeyword()->value());

        if ($category) {
            $document->metadataCollection()->add(
                new Metadata('category', $category)
            );
        }

        return $document;
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