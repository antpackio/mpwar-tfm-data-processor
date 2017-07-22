<?php

namespace Mpwar\DataProcessor\Infrastructure\Domain\EnrichmentService\Category;


use Mpwar\DataProcessor\Domain\EnrichedDocument\EnrichedDocument;
use Mpwar\DataProcessor\Domain\EnrichmentService\EnrichmentDocumentService;

class InMemoryCategory implements EnrichmentDocumentService
{

    public function execute(EnrichedDocument $enrichedDocument): EnrichedDocument
    {

        switch($enrichedDocument->keyword()->value()){
            case "sunscreen":
                $category = new Category();
                $category->value = ["health","summer","skin"];
                $enrichedDocument->addMetadata($category);
        }

        return $enrichedDocument;
    }
}