<?php
/**
 * Created by PhpStorm.
 * User: Carles
 * Date: 05/07/2017
 * Time: 18:37
 */

namespace Mpwar\DataProcessor\Infrastructure\EnrichedDocument\Service\Category;


use Mpwar\DataProcessor\Domain\EnrichedDocument\EnrichedDocument;
use Mpwar\DataProcessor\Domain\EnrichedDocument\Service\EnrichmentDocumentService;
use Mpwar\DataProcessor\Infrastructure\EnrichedDocument\Service\Category\Category;


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